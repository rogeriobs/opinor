<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ArtigosController extends AppController
{

    private $__format_article = [
        '__p25' => '__p25',
        '__p50' => '__p50'
    ];

    public function initialize()
    {
        parent::initialize();

    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->loadModel("Newsortopic");

        $this->set("format_article", $this->__format_article);

    }

    public function clearFilters()
    {
        $this->request->session()->delete("Filtros.{$this->name}");

        return $this->redirect(['action' => 'index']);

    }

    public function index()
    {
        if($this->request->is("post")){

            $dados_para_busca = $this->request->data;

            $this->request->session()->write("Filtros.{$this->name}", $dados_para_busca);
        }else{

            $dados_para_busca = $this->request->session()->read("Filtros.{$this->name}");

            $this->request->data = $dados_para_busca;
        }

    }

    private function __get_conditions_filters()
    {
        if(!$this->request->session()->check("Filtros.{$this->name}")){
            return false;
        }

        $conditions = [];

        $dados_para_busca = $this->request->session()->read("Filtros.{$this->name}");

        if(is_numeric($dados_para_busca['buscar_id'])){

            $conditions[] = "Newsortopic.id = '" . $dados_para_busca['buscar_id'] . "'::integer";
        }

        if(trim($dados_para_busca['buscar_titulo'])){

            $conditions[] = "Newsortopic.titulo ILIKE '%" . $dados_para_busca['buscar_titulo'] . "%'::text";
        }

        if(is_numeric($dados_para_busca['buscar_shutoff'])){

            $conditions[] = "Newsortopic.shutoff = " . $dados_para_busca['buscar_shutoff'] . "::boolean";
        }

        if(trim($dados_para_busca['buscar_cadastroem'])){

            switch($dados_para_busca['buscar_cadastroem']):

                case 'nestemes':

                    $conditions[] = "EXTRACT(MONTH FROM Newsortopic.created) = EXTRACT(MONTH FROM CURRENT_DATE) ";
                    $conditions[] = "EXTRACT(YEAR FROM Newsortopic.created) = EXTRACT(YEAR FROM CURRENT_DATE)";

                    break;
                case 'nesteano':

                    $conditions[] = "EXTRACT(YEAR FROM Newsortopic.created) = EXTRACT(YEAR FROM CURRENT_DATE)";

                    break;
            endswitch;
        }

        return $conditions;

    }

    public function loadData()
    {
        $this->autoRender = false;

        $this->paginate = [
            'limit'      => 1000,
            'order'      => [
                'Newsortopic.created' => 'desc'
            ],
            'contain'    => ["Poll", "Dominus", "NewsortopicTags" => ["fields" => ["NewsortopicTags.newsortopic_id", "NewsortopicTags.tag"]]],
            "fields"     => [
                "Newsortopic.id",
                "Newsortopic.titulo",
                "Newsortopic.alias",
                "Newsortopic.data_de_publicacao",
                "Newsortopic.data_da_fonte",
                "texto_resumo"      => "substring(Newsortopic.texto_resumo from 0 for 50)",
                "texto_full"        => "substring(Newsortopic.texto_full from 0 for 50)",
                "Newsortopic.meta_title",
                "Newsortopic.meta_description",
                "Newsortopic.meta_keywords",
                "Newsortopic.format_article",
                "shutoff_label"     => "CASE WHEN Newsortopic.shutoff = true THEN 'Sim' ELSE 'Não' END",
                "Newsortopic.created",
                "Newsortopic.modified",
                "modified_formated" => "TO_CHAR(Newsortopic.modified, 'DD/MM/YYYY HH24:MI:SS')",
                "created_formated"  => "TO_CHAR(Newsortopic.created, 'DD/MM/YYYY HH24:MI:SS')",
                "Poll.id",
                "Poll.titulo",
                "Poll.expiration_date",
                "count_votes"       => "(SELECT COUNT(*) FROM poll_options_votes pov WHERE pov.poll_id = Poll.id)",
                "count_comentarios" => "(SELECT COUNT(*) FROM newsortopic_comments nc WHERE nc.newsortopic_id = Newsortopic.id)",
                "count_imagens"     => "(SELECT COUNT(*) FROM newsortopic_imagens ni WHERE ni.newsortopic_id = Newsortopic.id)",
                "Dominus.id",
                "Dominus.nome",
                "Dominus.email",
            ],
            "conditions" => []
        ];

        $conditions = $this->__get_conditions_filters();

        if($conditions === false || !count($conditions)){

            $artigos = [];
        }else{

            $this->paginate['conditions'] = $conditions;

            $artigos = $this->paginate($this->Newsortopic);
        }

        $data = [];

        foreach($artigos as $index => $artigo):

            $data[$index]                = $artigo;
            $data[$index]->dominus_id    = $artigo->dominus->id;
            $data[$index]->dominus_nome  = $artigo->dominus->nome;
            $data[$index]->dominus_email = $artigo->dominus->email;
            $data[$index]->poll_id       = isset($artigo->poll->id) ? $artigo->poll->id : '';
            $data[$index]->poll_titulo   = isset($artigo->poll->titulo) ? $artigo->poll->titulo : '';
            $data[$index]->poll_validade = isset($artigo->poll->expiration_date) ? $artigo->poll->expiration_date : '';
            $data[$index]->texto_full    = strip_tags($artigo->texto_full);

        endforeach;

        //pr($data); die();

        $this->response->type('json');
        $this->response->body(json_encode($data));

    }

    private function __add_poll($dados)
    {
        if(!is_array($dados)){
            return false;
        }

        if(count($dados) < 3){
            return false;
        }

        $pollTable = TableRegistry::get('Poll');

        $poll = $pollTable->newEntity();

        $poll->titulo  = $dados[0];
        $poll->shutoff = 0;

        if($pollTable->save($poll)){

            $poll_id = $poll->id;

            unset($dados[0]);

            foreach($dados as $ordem => $label):

                $this->__cnx->insert('poll_options', [
                    'label_text' => trim($label),
                    'ordem'      => trim($ordem),
                    'poll_id'    => $poll_id,
                    'created'    => date("Y-m-d H:i:s"),
                    'modified'   => date("Y-m-d H:i:s"),
                ]);

            endforeach;

            return $poll_id;
        }

        return false;

    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $newsortopic = $this->Newsortopic->newEntity();

        if($this->request->is('post')){

            $this->request->data['data_de_publicacao'] = date("Y-m-d H:i:s");
            $this->request->data['data_da_fonte']      = date("Y-m-d H:i:s");
            $this->request->data['texto_resumo']       = strip_tags($this->request->data['texto_resumo']);
            $this->request->data['texto_full']         = "empty";
            $this->request->data['dominus_id']         = 1;
            $this->request->data['alias']              = \Cake\Utility\Inflector::slug($this->request->data['titulo']);

            if(!is_numeric($this->request->data['poll_id']) && !empty(trim($this->request->data['newpoll']))){

                $nova_enquete = explode(PHP_EOL, $this->request->data['newpoll']);

                $this->request->data['poll_id'] = $this->__add_poll($nova_enquete);
            }

            $newsortopic = $this->Newsortopic->patchEntity($newsortopic, $this->request->getData());

            if($this->Newsortopic->save($newsortopic)){
                $this->Flash->success(__('The newsortopic has been saved.'));

                return $this->redirect(['action' => 'edit', $newsortopic->id]);
            }else{
                $this->Flash->error(__('The newsortopic could not be saved. Please, try again.'));

                return $this->redirect(['action' => 'index']);
            }
        }

        $poll = $this->Newsortopic->Poll->find('list', [
            'limit'      => 1000,
            'conditions' => [
                "Poll.id NOT IN (SELECT poll_id FROM newsortopic GROUP BY poll_id)"
            ]
        ]);

        $this->set(compact('newsortopic', 'poll'));
        $this->set('_serialize', ['newsortopic']);

    }

    /**
     * Edit method
     *
     * @param string|null $id Newsortopic id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $newsortopic = $this->Newsortopic->get($id, [
            'contain' => ["Poll"]
        ]);
        if($this->request->is(['patch', 'post', 'put'])){
            $newsortopic = $this->Newsortopic->patchEntity($newsortopic, $this->request->getData());
            if($this->Newsortopic->save($newsortopic)){
                $this->Flash->success(__('The newsortopic has been saved.'));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('The newsortopic could not be saved. Please, try again.'));
        }

        $this->set(compact('newsortopic'));
        $this->set('_serialize', ['newsortopic']);

    }

    public function delete()
    {
        $this->autoRender = false;

        $this->request->allowMethod(['delete']);

        $jsonData = $this->request->input('json_decode');

        if(!count($jsonData)){
            die();
        }

        $return_json = [];
        $deletados   = 0;

        try
        {
            foreach($jsonData as $object):

                $this->__cnx->delete('newsortopic', ['id' => $object->id]);

                $deletados++;

            endforeach;

            $return_json = ['text' => __("Foram deletados {0} registros", $deletados), 'icon' => 'success'];
        }catch(\Exception $ex)
        {

            $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
        }

        $this->response->type('json');
        $this->response->body(json_encode($return_json));

    }

    public function SelecionarEnquete()
    {
        $enquete = TableRegistry::get("Poll");

        $enquetes = $enquete->find("all", [
                    "conditions" => [],
                    "order"      => ["Poll.created" => 'DESC'],
                    "contain"    => ['PollOptions']
                ])->toArray();

        $this->set(compact("enquetes"));

    }

    public function listarTags($artigo_id)
    {
        $artigoTags = TableRegistry::get("newsortopicTags");

        $tags = $artigoTags->find('all', [
                    "conditions" => [
                        "newsortopicTags.newsortopic_id" => $artigo_id
                    ],
                    "order"      => [
                        "newsortopicTags.tag" => "ASC"
                    ]
                ])->toArray();

        $this->set(compact("tags"));

    }

    /**
     * 
     * Array
     *   (
     *       [tag] => dasdasd
     *   )
     * 
     * @param type $artigo_id
     */
    public function addTag($artigo_id)
    {
        $this->autoRender = false;

        $return_json = [];

        if($this->request->is("post")){

            $tag = $this->request->data['tag'];

            try
            {

                $this->__cnx->insert('newsortopic_tags', [
                    'tag'            => $tag,
                    'newsortopic_id' => $artigo_id
                ]);

                $return_json = ['text' => "Tag incluida com sucesso!", 'icon' => 'success'];
            }catch(\Exception $ex)
            {
                $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
            }


            $this->response->type('json');
            $this->response->body(json_encode($return_json));
        }

    }

    /**
     * 
     * Array
     *   (
     *       [tag] => dasdasd
     *   )
     * 
     * @param type $artigo_id
     */
    public function deleteTag($artigo_id)
    {
        $this->autoRender = false;

        $return_json = [];

        if($this->request->is("post")){

            $tag = $this->request->data['tag'];

            try
            {

                $this->__cnx->delete('newsortopic_tags', [
                    'tag'            => $tag,
                    'newsortopic_id' => $artigo_id
                ]);

                $return_json = ['text' => "Tag removida com sucesso!", 'icon' => 'success'];
            }catch(\Exception $ex)
            {
                $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
            }


            $this->response->type('json');
            $this->response->body(json_encode($return_json));
        }

    }

    public function listImages($artigo_id)
    {
        $NewsortopicImagens = TableRegistry::get('NewsortopicImagens');

        $imagens_do_artigo = $NewsortopicImagens->find("all", [
                    "conditions" => [
                        "NewsortopicImagens.newsortopic_id" => $artigo_id
                    ],
                    "order"      => [
                        "NewsortopicImagens.id"
                    ]
                ])->toArray();

        $this->set("artigo_id", $artigo_id);
        $this->set("imagens_do_artigo", $imagens_do_artigo);

    }

    public function listPoll($artigo_id, $poll_id = false)
    {
        $enquete = [];

        if($poll_id){

            $poll = TableRegistry::get('Poll');

            $enquete = $poll->find("all", [
                        "conditions" => [
                            "Poll.id" => $poll_id
                        ],
                        "order"      => [
                            "Poll.id"
                        ]
                    ])->firstOrFail();

            $enquete->pollOptions = $poll->get_options_with_results($poll_id);
        }

        $this->set("enquete", $enquete);

    }

    public function listComments($artigo_id)
    {
        $newsortopicComments = TableRegistry::get('NewsortopicComments');

        $comentarios = $newsortopicComments->find("all", [
                    "fields"     => [
                        "NewsortopicComments.id",
                        "NewsortopicComments.comentario",
                        "NewsortopicComments.data_e_hora",
                        "NewsortopicComments.status",
                        "NewsortopicComments.ipsum_id",
                        "likes"    => "(SELECT COUNT(*) FROM newsortopic_comments_rating NewsortopicCommentsRating WHERE NewsortopicCommentsRating.newsortopic_comments_id = NewsortopicComments.id AND NewsortopicCommentsRating.type = '1')",
                        "notlikes" => "(SELECT COUNT(*) FROM newsortopic_comments_rating NewsortopicCommentsRating WHERE NewsortopicCommentsRating.newsortopic_comments_id = NewsortopicComments.id AND NewsortopicCommentsRating.type = '2')",
                        "maybes"   => "(SELECT COUNT(*) FROM newsortopic_comments_rating NewsortopicCommentsRating WHERE NewsortopicCommentsRating.newsortopic_comments_id = NewsortopicComments.id AND NewsortopicCommentsRating.type = '3')",
                    ],
                    "conditions" => [
                        "NewsortopicComments.newsortopic_id" => $artigo_id
                    ],
                    "order"      => [
                        "NewsortopicComments.id"
                    ],
                    "contain"    => ['Ipsum' => ['fields' => ["Ipsum.nome", "Ipsum.status"]]]
                ])->toArray();

        $this->set("comentarios", $comentarios);

    }

    /**
     * Array
     *   (
     *       [artigo_imagem_id] => 2
     *       [newURL] => https://s3.amazonaws.com/feather-client-files-aviary-prod-us-east-1/2017-06-03/379ba7b9-b0de-4cb4-bead-fba58ca06b25.jpg
     *   )
     */
    public function saveImageEdited($artigo_id)
    {
        $this->autoRender = false;

        if($this->request->is("post")){

            extract($this->request->data);

            copy($newURL, DIR_FRONT . "webroot/img/articles/alta/{$artigo_imagem_filename}");
        }

    }

    /**
     * Array
     *   (
     *       [artigo_id] => 3
     *       [fileimage] => Array
     *           (
     *               [0] => Array
     *                   (
     *                       [tmp_name] => /tmp/phpJTnVNs
     *                       [error] => 0
     *                       [name] => Pokemon.png
     *                       [type] => image/png
     *                       [size] => 217810
     *                   )
     *
     *           )
     *
     *   )
     */
    public function uploadImage()
    {
        require_once PATH_VENDOR_OPINOR . 'class.verotupload.php';

        $this->autoRender = false;

        if(isset($this->request->data['artigo_id']) && is_numeric($this->request->data['artigo_id'])){

            $artigo_id = $this->request->data['artigo_id'];
        }

        $handle = new \Upload($this->request->data['fileimage'][0]);
        
        if($handle->uploaded){

            $handle->file_new_name_body = md5(uniqid(rand(), true));

            $handle->process(DIR_FRONT . 'webroot/img/articles/alta/');

            if($handle->processed){

                $this->__cnx->insert('newsortopic_imagens', [
                    'filename'       => $handle->file_dst_name,
                    'head'           => 0,
                    'real_width'     => $handle->image_src_x,
                    'real_height'    => $handle->image_src_y,
                    'use_width'      => '100%',
                    'use_height'     => 'auto',
                    'newsortopic_id' => $artigo_id,
                ]);

                $handle->clean();
            }else{
                echo 'error : ' . $handle->error;
            }
        }

    }

    /**
     * Array
     *   (
     *       [imagem_id] => 63
     *   )
     */
    public function deleteImage()
    {
        $this->autoRender = false;

        if($this->request->is("delete")){

            try
            {
                $return_json = [];

                $this->loadModel("NewsortopicImagens");

                $id = $this->request->data['imagem_id'];

                $newsortopicImagen = $this->NewsortopicImagens->get($id);

                $this->NewsortopicImagens->delete($newsortopicImagen);

                $return_json = ['text' => "Imagem deletada com sucesso.", 'icon' => 'success'];
            }catch(\Exception $ex)
            {
                $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
            }

            $this->response->type('json');
            $this->response->body(json_encode($return_json));
        }

    }

    /**
     * Array
     *   (
     *       [imagem_id] => 56
     *       [legenda] => 
     *       [use_largura] => 
     *       [use_altura] => 
     *   )
     */
    public function saveDataImage()
    {
        $this->autoRender = false;

        $return_json = [];

        if($this->request->is("put")):

            try
            {
                $this->__cnx->update('newsortopic_imagens', [
                    'legenda'    => $this->request->data['legenda'],
                    'use_width'  => $this->request->data['use_largura'],
                    'use_height' => $this->request->data['use_altura'],
                        ], ['id' => $this->request->data['imagem_id']]
                );

                $return_json = ['text' => "Dados salvo com sucesso.", 'icon' => 'success'];
            }catch(\Exception $ex)
            {
                $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
            }

        endif;

        $this->response->type('json');
        $this->response->body(json_encode($return_json));

    }

    /**
     * Array
     *   (
     *       [imagem_id] => 15
     *       [artigo_id] => 3
     *   )
     */
    public function setHeadImagem()
    {
        $this->autoRender = false;

        $return_json = [];

        if($this->request->is("put")){

            try
            {
                $imagem_id = $this->request->data['imagem_id'];
                $artigo_id = $this->request->data['artigo_id'];

                $this->__cnx->update('newsortopic_imagens', ['head' => 0], ['newsortopic_id' => $artigo_id]);
                $this->__cnx->update('newsortopic_imagens', ['head' => 1], ['id' => $imagem_id]);

                $return_json = ['text' => "Imagem setada como principal com sucesso.", 'icon' => 'success'];
            }catch(\Exception $ex)
            {
                $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
            }

            $this->response->type('json');
            $this->response->body(json_encode($return_json));
        }

    }

}

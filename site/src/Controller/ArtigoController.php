<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\InternalErrorException;

class ArtigoController extends AppController
{

    use \App\Traits\AccessLog;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');

    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['view', 'refreshPoll', 'getPollDetails']);

    }

    public function beforeRender(\Cake\Event\Event $event)
    {
        parent::beforeRender($event);        
    }

    public function view($alias)
    {
        $this->viewBuilder()->layout("article");
        
        $this->loadModel("Newsortopic");
        $this->loadModel("PollOptions");

        $seo = [
            'title'       => '',
            'keywords'    => '',
            'description' => ''
        ];

        $artigo = $this->Newsortopic->find("all", [
                    "conditions" => [
                        "Newsortopic.alias"   => $alias,
                        "Newsortopic.shutoff" => false
                    ],
                    "contain"    => [
                        "Poll",
                        "NewsortopicImagens" => ['sort' => ['NewsortopicImagens.head' => 'ASC']],
                        "NewsortopicTags"
                    ]
                ])->first();

        if(!$artigo){
            throw new \Cake\Network\Exception\NotFoundException();
        }

        $artigo->pollOptions = $this->PollOptions->get_options_with_results($artigo->poll_id);

        $pollOptionsId = [];

        foreach($artigo->pollOptions as $pollOption):

            $pollOptionsId[] = $pollOption['id'];

        endforeach;

        $opcao_da_enquete_votada = $this->__user_ja_votou_na_enquete($pollOptionsId);

        /**
         * SEO
         */
        if($artigo->meta_title){
            $seo['title'] = $artigo->meta_title;
        }else{
            $seo['title'] = $artigo->titulo;
        }

        if($artigo->meta_keywords){
            $seo['keywords'] = $artigo->meta_keywords;
        }else{

            $tags = [];

            foreach($artigo->newsortopic_tags as $tag):

                $tags[] = $tag->tag;

            endforeach;

            $seo['keywords'] = implode(", ", $tags);
        }

        if($artigo->meta_description){
            $seo['description'] = $artigo->meta_description;
        }else{
            $seo['description'] = $artigo->texto_resumo;
        }
        //-->

        $this->set(compact("artigo", "opcao_da_enquete_votada", "seo"));

        //register log
        $this->register_page_access($this->__cnx, [
            'ipsum_id'       => $this->getUserData('id'),
            'newsortopic_id' => $artigo->id,
            'ip'             => getIP(),
        ]);

    }

    private function __user_ja_votou_na_enquete($poll_options_id = [])
    {        
        if(!is_numeric($this->getUserData("id"))){
            return false;
        }

        $poll_options_id = implode(", ", $poll_options_id);

        $sql = "SELECT poll_options_id FROM poll_options_votes WHERE poll_options_id IN({$poll_options_id}) AND ipsum_id = :ipsum_id";

        $result = $this->__cnx->execute($sql, [
                    'ipsum_id' => $this->getUserData("id")
                ])->fetchAll('assoc');

        if(count($result)){

            return $result[0]['poll_options_id'];
        }

        return false;

    }

    /**
     * Array
     *   (
     *       [_poid] => Vyt6ekVyc2t5SmduNzdxK0JRVFltUT09
     *       [optionVote] => bHNGU01peU5FNHBOQm5GL2dIM1hxdz09
     *   )
     */
    public function vote()
    {
        $this->viewBuilder()->layout("ajax");
        
        $this->autoRender = false;

        if($this->request->is("post")){

            $return = [
                "result"  => false,
                "message" => "",
            ];

            $optionVote = isset($this->request->data['optionVote']) ? $this->request->data['optionVote'] : false;
            $poll_id    = $this->request->data['_poid'];

            try
            {
                if(!$optionVote){
                    throw new InternalErrorException("Ocorreu um erro interno");
                }

                $optionVote = decrypt($optionVote, CRYPT_KEY_FOR_ID);
                $poll_id    = decrypt($poll_id, CRYPT_KEY_FOR_ID);

                if(!is_numeric($optionVote) || !is_numeric($poll_id)){
                    throw new InternalErrorException("Ocorreu um erro interno", 500);
                }

                if(!$this->isLogged()){
                    throw new InternalErrorException("Você precisa estar logado no site para votar", 500);
                }

                $user_id = $this->getUserData("id");

                $this->__cnx->insert('poll_options_votes', [
                    'ipsum_id'        => $user_id,
                    'poll_options_id' => $optionVote,
                    'poll_id'         => $poll_id,
                    'ip'              => getIP(),
                    'created'         => date("Y-m-d"),
                    'modified'        => date("Y-m-d"),
                ]);

                $return = [
                    "result"       => true,
                    "message"      => "Voto computado com sucesso!",
                    "message_icon" => "success",
                ];
            }catch(\PDOException $ex)
            {

                if(strpos($ex->getMessage(), "duplicate key") !== false){

                    $return = [
                        "result"       => false,
                        "message"      => "Voce ja votou nesta enquete.",
                        "message_icon" => "warning",
                    ];
                }else{
                    $return = [
                        "result"       => false,
                        "message"      => $ex->getMessage(),
                        "message_icon" => "error",
                    ];
                }
            }catch(InternalErrorException $ex)
            {

                $return = [
                    "result"       => false,
                    "message"      => $ex->getMessage(),
                    "message_icon" => "error",
                ];

                $this->response->statusCode(500);
            }catch(\Exception $ex)
            {

                //Melhorar quando for user root

                $return = [
                    "result"       => false,
                    "message"      => $ex->getMessage(),
                    "message_icon" => "error",
                ];

                $this->response->statusCode(500);
            }

            $this->response->type('json');
            $this->response->body(json_encode($return));
        }

    }

    /**
     * 
     * Array
     *   (
     *       [0] => Array
     *           (
     *               [count] => 1
     *               [poll_options_id] => 10
     *           )
     *
     *   )
     * 
     * @param type $poll_id
     */
    public function refreshPoll($poll_id = '')
    {
        $this->viewBuilder()->layout("ajax");
        
        $this->autoRender = false;

        if(!$poll_id){
            die();
        }

        $poll_id = decrypt($poll_id, CRYPT_KEY_FOR_ID);

        $sql     = "SELECT 
                    COUNT(pov.ipsum_id), 
                    pov.poll_options_id 
                FROM poll_options_votes pov 
                WHERE poll_id = :poll_id 
                GROUP BY pov.poll_options_id";
        $results = $this->__cnx->execute($sql, ['poll_id' => $poll_id])->fetchAll('assoc');

        if($results){

            $total_da_votos = 0;
            $return         = [
                'total_de_votos' => 0,
                'options'        => [],
            ];

            foreach($results as $option):
                $total_da_votos += $option['count'];
            endforeach;

            foreach($results as $index => $option):

                $return['options'][] = [
                    "__"         => encrypt($option['poll_options_id'], CRYPT_KEY_FOR_ID),
                    "votos"      => $option['count'],
                    "votos_perc" => round((($option['count'] * 100) / $total_da_votos), 2),
                ];

            endforeach;

            $return['total_de_votos'] = $total_da_votos;

            $this->response->type('json');
            $this->response->body(json_encode($return));
        }

    }

    public function getPollDetails()
    {
        $this->viewBuilder()->layout("ajax");

        if($this->request->is('post')){

            $dados = [];

            $poll_id = $this->request->data['pollid'];

            $poll_id = decrypt($poll_id, CRYPT_KEY_FOR_ID);

            $sql = "SELECT 
                        COUNT(*) AS votos,
                        e.regiao,
                        DATE_PART('year',AGE(i.data_nascimento)) AS idade
                    FROM poll_options_votes pov 
                        INNER JOIN ipsum i ON i.id = pov.ipsum_id
                        INNER JOIN cidades c ON c.id = i.cidade_id
                        INNER JOIN estados e ON e.id = c.estado_id
                    WHERE pov.poll_id = :poll_id
                    GROUP BY idade, e.regiao
                    ORDER BY idade";

            $results = $this->__cnx->execute($sql, ['poll_id' => $poll_id])->fetchAll('assoc');

            if(count($results)){
                foreach($results as $result):

                    $dados[$result['idade']][$result['regiao']] = $result['votos'];

                endforeach;
            }

            $this->set("dados", $dados);
        }

    }

}

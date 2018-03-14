<?php

namespace App\Controller;

use App\Controller\AppController;

class EnquetesController extends AppController
{

    public function initialize()
    {
        parent::initialize();

    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->loadModel("Poll");
        $this->loadModel("PollOptions");
        $this->loadModel("PollOptionsVotes");

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

            $conditions[] = "Poll.id = '" . $dados_para_busca['buscar_id'] . "'::integer";
        }

        if(trim($dados_para_busca['buscar_titulo'])){

            $conditions[] = "Poll.titulo ILIKE '%" . $dados_para_busca['buscar_titulo'] . "%'::text";
        }

        if(is_numeric($dados_para_busca['buscar_shutoff'])){

            $conditions[] = "Poll.shutoff = " . $dados_para_busca['buscar_shutoff'] . "::boolean";
        }

        if(trim($dados_para_busca['buscar_cadastroem'])){
                        
            switch($dados_para_busca['buscar_cadastroem']):
                
                case 'nestemes':
                                        
                    $conditions[] = "EXTRACT(MONTH FROM Poll.created) = EXTRACT(MONTH FROM CURRENT_DATE) ";                    
                    $conditions[] = "EXTRACT(YEAR FROM Poll.created) = EXTRACT(YEAR FROM CURRENT_DATE)";

                    break;
                case 'nesteano':
                                        
                    $conditions[] = "EXTRACT(YEAR FROM Poll.created) = EXTRACT(YEAR FROM CURRENT_DATE)";

                    break;
            endswitch;
        }

        return $conditions;

    }

    public function loadData()
    {
        $this->autoRender = false;

        $this->paginate = [
            'limit' => 1000,
            'order' => [
                'Poll.created' => 'desc'
            ],
            'contain' => ["Newsortopic" => ["fields" => ["Newsortopic.poll_id", "Newsortopic.titulo", "Newsortopic.id"]]],
            "fields" => [
                "Poll.id",
                "Poll.titulo",
                "shutoff_label" => "CASE WHEN Poll.shutoff = true THEN 'Sim' ELSE 'Não' END",
                "validade" => "TO_CHAR(Poll.expiration_date, 'DD/MM/YYYY')",
                "count_options" => "(SELECT COUNT(*) FROM poll_options po WHERE po.poll_id = Poll.id)",
                "count_votes" => "(SELECT COUNT(*) FROM poll_options_votes pov WHERE pov.poll_id = Poll.id)",
                "Poll.created",
                "Poll.modified",
                "modified_formated" => "TO_CHAR(Poll.modified, 'DD/MM/YYYY HH24:MI:SS')",
                "created_formated" => "TO_CHAR(Poll.created, 'DD/MM/YYYY HH24:MI:SS')",
            ],
            "conditions" => []
        ];

        $conditions = $this->__get_conditions_filters();

        if($conditions === false || !count($conditions)){

            $enquetes = [];
        }else{

            $this->paginate['conditions'] = $conditions;

            $enquetes = $this->paginate($this->Poll);
        }

        $data = [];

        foreach($enquetes as $index => $enquete):

            $data[$index] = $enquete;
            $data[$index]->artigo_id = @$enquete->newsortopic[0]->id;
            $data[$index]->artigo_titulo = @$enquete->newsortopic[0]->titulo;

        endforeach;

        //pr($data); die();

        $this->response->type('json');
        $this->response->body(json_encode($data));

    }

    public function add()
    {
        $poll = $this->Poll->newEntity();
        if($this->request->is('post')){
            $poll = $this->Poll->patchEntity($poll, $this->request->getData());
            if($this->Poll->save($poll)){
                $this->Flash->success(__('The poll has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The poll could not be saved. Please, try again.'));
        }
        $this->set(compact('poll'));
        $this->set('_serialize', ['poll']);

    }

    public function edit($id = null)
    {
        $poll = $this->Poll->get($id, [
            "contain" => [
                "PollOptions" => [
                    "fields" => [
                        "PollOptions.id",
                        "PollOptions.poll_id",
                        "PollOptions.label_text",
                        "PollOptions.created",
                        "PollOptions.modified",
                        "PollOptions.ordem",
                        "count_votes" => "(SELECT COUNT(*) FROM poll_options_votes pov WHERE pov.poll_options_id = PollOptions.id)"
                    ],
                    "sort" => ["PollOptions.created" => "DESC"]
                ]
            ]
        ]);

        if($this->request->is(['patch', 'post', 'put'])){
            $poll = $this->Poll->patchEntity($poll, $this->request->getData());
            if($this->Poll->save($poll)){
                $this->Flash->success(__('The poll has been saved.'));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('The poll could not be saved. Please, try again.'));
        }
        
        $poll_options = json_encode($poll->poll_options);
                
        $this->set(compact('poll', 'poll_options'));

    }

    public function addOption($poll_id)
    {
        $pollOption = $this->PollOptions->newEntity();
        if($this->request->is('post')){
            $pollOption = $this->PollOptions->patchEntity($pollOption, $this->request->getData());
            if($this->PollOptions->save($pollOption)){
                $this->Flash->success(__('The poll option has been saved.'));
            }else{
                $this->Flash->error(__('The poll option could not be saved. Please, try again.'));
            }

            return $this->redirect(['action' => 'edit', $poll_id]);
        }

        $this->set(compact('pollOption', 'poll_id'));

    }

    public function editOption($id = null)
    {
        $pollOption = $this->PollOptions->get($id, [
            'contain' => []
        ]);

        if($this->request->is(['patch', 'post', 'put'])){
            $pollOption = $this->PollOptions->patchEntity($pollOption, $this->request->getData());
            if($this->PollOptions->save($pollOption)){
                $this->Flash->success(__('The poll option has been saved.'));
            }else{
                $this->Flash->error(__('The poll option could not be saved. Please, try again.'));
            }

            return $this->redirect(['action' => 'edit', $pollOption->poll_id]);
        }
        $this->set(compact('pollOption'));
        $this->set('_serialize', ['pollOption']);

    }

    public function listOptionVotes()
    {
        if($this->request->is("post")){

            $poll_option_id = $this->request->data['poll_option_id'];

            $votos = $this->PollOptionsVotes->find("all", [
                        "conditions" => [
                            "PollOptionsVotes.poll_options_id" => $poll_option_id
                        ],
                        "contain" => ["Ipsum"]
                    ])->toArray();

            $this->set(compact('votos'));
            $this->set('poll_option_id', $poll_option_id);
        }

    }

    public function deleteOption($poll_id)
    {
        $this->autoRender = false;

        $this->request->allowMethod(['delete']);

        $poll_option_id = $this->request->data['poll_option_id'];

        $pollOption = $this->PollOptions->get($poll_option_id);

        if($pollOption->poll_id != $poll_id){
            $this->Flash->error(__('The poll option could not be deleted. Please, try again.'));
        }else{

            if($this->PollOptions->delete($pollOption)){
                $this->Flash->success(__('The poll option has been deleted.'));
            }else{
                $this->Flash->error(__('The poll option could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'edit', $poll_id]);

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
        $deletados = 0;

        try
        {
            foreach($jsonData as $object):

                if(!in_array($object->id, [1, 2])){

                    $this->__cnx->delete('poll', ['id' => $object->id]);

                    $deletados++;
                }

            endforeach;

            $return_json = ['text' => __("Foram deletados {0} registros", $deletados), 'icon' => 'success'];
            
        }catch(\Exception $ex)
        {

            $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
        }

        $this->response->type('json');
        $this->response->body(json_encode($return_json));

    }

}

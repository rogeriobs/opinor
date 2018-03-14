<?php

namespace App\Controller;

use App\Controller\AppController;

class PerfilUsuariosController extends AppController
{

    public function initialize()
    {
        parent::initialize();

    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->loadModel("DominusPerfis");

    }

    /**
     * Array
     *   (
     *       [buscar_descricao] => teste
     *   )
     * 
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //pr($this->name);

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

        if(trim($dados_para_busca['buscar_descricao'])){

            $conditions[] = "DominusPerfis.descricao ILIKE '%".$dados_para_busca['buscar_descricao']."%'::text";
        }

        return $conditions;

    }

    public function loadData()
    {
        $this->autoRender = false;

        $this->paginate = [
            'limit' => 1000,
            'order' => [
                'DominusPerfis.created' => 'desc'
            ],
            "fields" => [
                "DominusPerfis.id",
                "DominusPerfis.descricao",
                "role" =>
                "CASE DominusPerfis.role 
                        WHEN 'R' THEN 'root'
                        WHEN 'S' THEN 'super usuário'
                        WHEN 'U' THEN 'usuário comum'
                        ELSE 'undefined'
                END",
                "DominusPerfis.created",
                "DominusPerfis.modified",
                "modified_formated" => "TO_CHAR(DominusPerfis.modified, 'DD/MM/YYYY HH24:MI:SS')",
                "created_formated" => "TO_CHAR(DominusPerfis.created, 'DD/MM/YYYY HH24:MI:SS')",
            ],
            "conditions" => []
        ];

        $conditions = $this->__get_conditions_filters();
                
        if($conditions === false || !count($conditions)){

            $dominusPerfis = [];
            
        }else{

            $this->paginate['conditions'] = $conditions;

            $dominusPerfis = $this->paginate($this->DominusPerfis);
        }

        $this->response->type('json');
        $this->response->body(json_encode($dominusPerfis));

    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dominusPerfi = $this->DominusPerfis->newEntity();

        if($this->request->is('post')){

            $this->request->data['role'] = 'U';
            $this->request->data['permissoes'] = '{}';

            $dominusPerfi = $this->DominusPerfis->patchEntity($dominusPerfi, $this->request->getData());

            if($this->DominusPerfis->save($dominusPerfi)){

                $this->Flash->success(__('The dominus perfi has been saved.'));

                return $this->redirect(['action' => 'add']);
            }

            $this->Flash->error(__('The dominus perfi could not be saved. Please, try again.'));
        }
        $this->set(compact('dominusPerfi'));
        $this->set('_serialize', ['dominusPerfi']);

    }

    /**
     * Edit method
     *
     * @param string|null $id Dominus Perfi id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dominusPerfi = $this->DominusPerfis->get($id, [
            'contain' => []
        ]);
        if($this->request->is(['patch', 'post', 'put'])){
            $dominusPerfi = $this->DominusPerfis->patchEntity($dominusPerfi, $this->request->getData());
            if($this->DominusPerfis->save($dominusPerfi)){
                $this->Flash->success(__('The dominus perfi has been saved.'));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('The dominus perfi could not be saved. Please, try again.'));
        }
        $this->set(compact('dominusPerfi'));
        $this->set('_serialize', ['dominusPerfi']);

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

        try{
            foreach($jsonData as $object):

                if(!in_array($object->id, [1, 2])){

                    $this->__cnx->delete('dominus_perfis', ['id' => $object->id]);

                    $deletados++;
                }

            endforeach;

            $return_json = ['text' => __("Foram deletados {0} registros", $deletados), 'icon' => 'success'];
            
        }catch(\Exception $ex){

            $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
        }

        $this->response->type('json');
        $this->response->body(json_encode($return_json));

    }

}

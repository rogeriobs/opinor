<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * AdminMenuItens Controller
 *
 * @property \App\Model\Table\AdminMenuItensTable $AdminMenuItens
 */
class MenusController extends AppController {

    public function initialize() {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);

        $this->loadModel("AdminMenuItens");
        $this->loadModel("AdminMenu");
    }

    public function clearFilters() {
        $this->request->session()->delete("Filtros.{$this->name}");

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {

        if ($this->request->is("post")) {

            $dados_para_busca = $this->request->data;

            $this->request->session()->write("Filtros.{$this->name}", $dados_para_busca);
        } else {

            $dados_para_busca = $this->request->session()->read("Filtros.{$this->name}");

            $this->request->data = $dados_para_busca;
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $adminMenuIten = $this->AdminMenuItens->newEntity();
        if ($this->request->is('post')) {
            $adminMenuIten = $this->AdminMenuItens->patchEntity($adminMenuIten, $this->request->getData());
            if ($this->AdminMenuItens->save($adminMenuIten)) {
                $this->Flash->success(__('The admin menu iten has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The admin menu iten could not be saved. Please, try again.'));
        }
        $adminMenu = $this->AdminMenuItens->AdminMenu->find('list', ['limit' => 200]);
        $this->set(compact('adminMenuIten', 'adminMenu'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin Menu Iten id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $adminMenuIten = $this->AdminMenuItens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $adminMenuIten = $this->AdminMenuItens->patchEntity($adminMenuIten, $this->request->getData());
            if ($this->AdminMenuItens->save($adminMenuIten)) {
                $this->Flash->success(__('The admin menu iten has been saved.'));

                return $this->redirect(['action' => 'edit', $id]);
            }
            $this->Flash->error(__('The admin menu iten could not be saved. Please, try again.'));
        }
        $adminMenu = $this->AdminMenuItens->AdminMenu->find('list', ['limit' => 200]);
        $this->set(compact('adminMenuIten', 'adminMenu'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin Menu Iten id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        
        $this->autoRender = false;

        $this->request->allowMethod(['delete']);

        $jsonData = $this->request->input('json_decode');

        if (!count($jsonData)) {
            die();
        }

        $return_json = [];
        $deletados = 0;

        try {
            foreach ($jsonData as $object):

                if (!in_array($object->id, [1, 2])) {

                    $this->__cnx->delete('admin_menu_itens', ['id' => $object->id]);

                    $deletados++;
                }

            endforeach;

            $return_json = ['text' => __("Foram deletados {0} registros", $deletados), 'icon' => 'success'];
        } catch (\Exception $ex) {

            $return_json = ['text' => $ex->getMessage(), 'icon' => 'error'];
        }

        $this->response->type('json');
        $this->response->body(json_encode($return_json));
    }

    private function __get_conditions_filters() {

        if (!$this->request->session()->check("Filtros.{$this->name}")) {
            return false;
        }

        $conditions = [];

        $dados_para_busca = $this->request->session()->read("Filtros.{$this->name}");

        if (trim($dados_para_busca['buscar_descricao'])) {

            $conditions[] = "AdminMenuItens.descricao ILIKE '%" . $dados_para_busca['buscar_descricao'] . "%'::text";
        }

        if (trim($dados_para_busca['buscar_descricao_pai'])) {

            $conditions[] = "AdminMenu.descricao ILIKE '%" . $dados_para_busca['buscar_descricao_pai'] . "%'::text";
        }

        if (is_numeric($dados_para_busca['buscar_id'])) {

            $conditions[] = "AdminMenuItens.id = '" . $dados_para_busca['buscar_id'] . "'::integer";
        }

        return $conditions;
    }

    public function loadData() {
        $this->autoRender = false;

        $this->paginate = [
            'contain' => ['AdminMenu'],
            'limit' => 1000,
            'order' => [
                'AdminMenuItens.created' => 'desc'
            ],
            "fields" => [
                "AdminMenuItens.id",
                "AdminMenuItens.descricao",
                "AdminMenuItens.ordem",
                "AdminMenuItens.params",
                "AdminMenuItens.action_perm",
                "AdminMenuItens.controller_go",
                "AdminMenuItens.action_go",
                "AdminMenuItens.created",
                "AdminMenuItens.modified",
                "admin_menu_descricao" => "AdminMenu.descricao",
                "modified_formated" => "TO_CHAR(AdminMenuItens.modified, 'DD/MM/YYYY HH24:MI:SS')",
                "created_formated" => "TO_CHAR(AdminMenuItens.created, 'DD/MM/YYYY HH24:MI:SS')",
            ],
            "conditions" => []
        ];

        $conditions = $this->__get_conditions_filters();

        $this->paginate['conditions'] = $conditions;

        $adminMenuItens = $this->paginate($this->AdminMenuItens);

        //pr($adminMenuItens); die();

        $this->response->type('json');
        $this->response->body(json_encode($adminMenuItens));
    }

    public function managerMenuParent() {

        $AdminMenu = TableRegistry::get('AdminMenu');

        $menus_parents = $AdminMenu->find("all", [
                    "order" => ["AdminMenu.created" => "DESC"]
                ])->toArray();

        $this->set(compact("menus_parents"));
    }

    public function MenuParentNew() {

        $adminMenu = $this->AdminMenu->newEntity();
        if ($this->request->is('post')) {
            $adminMenu = $this->AdminMenu->patchEntity($adminMenu, $this->request->getData());
            if ($this->AdminMenu->save($adminMenu)) {

                $this->Flash->success(__('The admin menu has been saved.'));

                $this->set("reload", true);

                return;
            }
            $this->Flash->error(__('The admin menu could not be saved. Please, try again.'));
        }
        $this->set(compact('adminMenu'));
    }

    public function deleteMenuParent() {

        $this->autoRender = false;

        $return_json = [];

        $this->request->allowMethod(['post', 'delete']);

        $id = $this->request->data['id'];

        $adminMenu = $this->AdminMenu->get($id);

        if ($this->AdminMenu->delete($adminMenu)) {

            $return_json = ['text' => "Menu deletado com sucesso.", 'icon' => 'success'];
        } else {
            $return_json = ['text' => "Ocorreu um erro ao tentar deletar o menu.", 'icon' => 'error'];
        }

        $this->response->type('json');
        $this->response->body(json_encode($return_json));
    }

    public function MenuParentEdit($id = null) {
        $adminMenu = $this->AdminMenu->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $adminMenu = $this->AdminMenu->patchEntity($adminMenu, $this->request->getData());
            if ($this->AdminMenu->save($adminMenu)) {
                $this->Flash->success(__('The admin menu has been saved.'));

                $this->set("reload", true);

                return;
            }
            $this->Flash->error(__('The admin menu could not be saved. Please, try again.'));
        }
        $this->set(compact('adminMenu'));
    }

}

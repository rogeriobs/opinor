<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    use \App\Traits\Permissoes;

    /**
     * Atributo para guardar o link da conexão
     * 
     * @var resource 
     */
    protected $__cnx = false;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'passwordHasher' => [
                        'className' => 'Default',
                    ],
                    'scope' => ['shutoff' => false],
                    'userModel' => 'Dominus',
                    'fields' => ['username' => 'username', 'password' => 'password'],
                ]
            ],
            'storage' => ['className' => 'Session', 'key' => 'Auth.Dominus'],
            'loginAction' => ['controller' => 'Login', 'action' => 'index'],
            'authError' => true,
            'unauthorizedRedirect' => true
        ]);

        $this->__cnx = ConnectionManager::get('default');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if($this->request->session()->check("Auth.Dominus")){

            $objPerfil = TableRegistry::get('DominusPerfis');

            $perfil_do_usuario = $objPerfil->find("all", [
                        "conditions" => [
                            "DominusPerfis.id" => $this->Auth->user("id")
                        ]
                    ])->firstOrFail();

            $ultima_atualizacao_do_perfil = false;

            if($this->request->session()->check("Auth.Perfil")){

                $ultima_atualizacao_do_perfil = $this->request->session()->read("Auth.Perfil.modified");

                $perfil_db_modified = $perfil_do_usuario->modified;
                $perfil_session_modified = $ultima_atualizacao_do_perfil;

                $perfil_db_modified = (strtotime($perfil_db_modified->format('Y-m-d H:i:s')));
                $perfil_session_modified = (strtotime($perfil_session_modified->format('Y-m-d H:i:s')));

                if($perfil_db_modified > $perfil_session_modified){

                    $this->request->session()->write("Auth.Perfil", $perfil_do_usuario);
                }
            }else{

                $this->request->session()->write("Auth.Perfil", $perfil_do_usuario);
            }
        }

        //if(!$this->request->session()->check("Auth.Menu")){

        $objMenu = TableRegistry::get('AdminMenu');

        $menu = $objMenu->find("all", [
                    "contain" => [
                        'AdminMenuItens' => ['sort' => ['AdminMenuItens.ordem' => 'ASC']]],
                    "order" => ['AdminMenu.ordem' => 'ASC']
                ])->toArray();

        $this->request->session()->write("Auth.Menu", $menu);
        //}

        $menu = $this->request->session()->read("Auth.Menu");

        $this->set(compact("menu"));

    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if(!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ){
            $this->set('_serialize', true);
        }

    }

}

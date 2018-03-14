<?php

namespace App\Controller;

use App\Controller\AppController;

class LoginController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');

    }
    
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        if($this->request->session()->check("Auth")){
            
            //$this->redirect(['controller' => 'main', 'action' => 'index']);
            
        }
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('login');

        if($this->request->is('post')){

            $user = $this->Auth->identify();

            if($user){

                $this->Auth->setUser($user);

                return $this->redirect(["controller" => "main", "action" => "index"]);
                
            }else{
                $this->Flash->error(__('Username or password is incorrect'));
            }
        }

    }

    public function logout()
    {
        $this->Auth->logout();
        
        $this->request->session()->delete("Auth");
        
        return $this->redirect(['controller' => "Login", "action" => "index"]);
    }

}

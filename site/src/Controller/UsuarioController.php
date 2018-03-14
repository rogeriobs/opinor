<?php

namespace App\Controller;

use App\Controller\AppController;

class UsuarioController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Csrf');

        $this->loadModel("Ipsum");
        $this->loadModel("Estados");

    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->viewBuilder()->layout("usuario");

        $this->Auth->allow(['meusDados', 'criarNovaSenha']);

    }

    public function meusDados()
    {
        $ipsum = $this->Ipsum->get($this->getUserData("id"), [
            'contain' => ["Cidades"]
        ]);

        if($this->request->is('put')){

            $ipsum = $this->Ipsum->patchEntity($ipsum, $this->request->data);

            if($this->Ipsum->save($ipsum)){

                $this->Flash->success("Dados atualizado com sucesso!");

                $this->request->session()->write("Auth.Ipsum.nome", $ipsum->nome);
                $this->request->session()->write("Auth.Ipsum.data_nascimento", $ipsum->data_nascimento);
                $this->request->session()->write("Auth.Ipsum.cidade_id", $ipsum->cidade_id);
            }else{
                $this->Flash->error(__('The ipsum could not be saved. Please, try again.'));
            }
        }

        $estados = $this->Estados->get_for_options_in_select();

        $this->set(compact('ipsum', 'estados'));

    }

    /**
     * Array
     *   (
     *       [senha_atual] => roger23423423
     *       [senha_nova] => 1231
     *       [senha_nova_reedigitada] => 2312
     *   )
     */
    public function alterarSenha()
    {        
        if($this->request->is('post')){

            extract($this->request->data);

            $greenHasher = new \App\Auth\GreenPasswordHasher();

            $senha_atual = $greenHasher->hash($senha_atual);

            $usuario = $this->Ipsum->find("all", [
                        "conditions" => [
                            "Ipsum.id"       => $this->getUserData("id"),
                            "Ipsum.password" => $senha_atual
                        ]
                    ])->first();

            try
            {

                if(!count($usuario)){
                    throw new \Exception("A senha atual não está correta...");
                }

                if(strlen(trim($senha_nova)) <= 0){
                    throw new \Exception("Digite uma nova senha...");
                }

                if(strlen(trim($senha_nova)) <= 3){
                    throw new \Exception("Nova senha muito curta, digite uma senha com mais de 3 caracteres...");
                }

                if($senha_nova != $senha_nova_reedigitada){
                    throw new \Exception("A nova senha digitada não corresponde com senha de confirmação.");
                }

                $usuario->password = $senha_nova;

                if($this->Ipsum->save($usuario)){

                    $this->Flash->success("Senha alterada com sucesso!");
                }
            }catch(\Exception $ex)
            {

                $this->Flash->warn($ex->getMessage());
            }
        }

    }

    public function criarNovaSenha($codigo = '')
    {
        $this->viewBuilder()->layout("public");

        if(!$codigo){
            return $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }

        $result = $this->__cnx->execute('SELECT * FROM ipsum_recovery_password WHERE codigo = :codigo', ['codigo' => $codigo])->fetchAll('assoc');

        if(!count($result)){
            return $this->redirect(['controller' => 'Home', 'action' => 'index']);
        }

        if($this->request->is("post")){

            extract($this->request->data);

            try
            {
                $usuario = $this->Ipsum->find("all", [
                    "conditions" => [
                        "Ipsum.id" => $result[0]['ipsum_id']
                    ]
                ])->first();
                
                if(!count($usuario)){
                    throw new \Exception("Usuário não encontrado...");
                }

                if(strlen(trim($senha_nova)) <= 0){
                    throw new \Exception("Digite uma nova senha...");
                }

                if(strlen(trim($senha_nova)) <= 3){
                    throw new \Exception("Nova senha muito curta, digite uma senha com mais de 3 caracteres...");
                }

                if($senha_nova != $senha_nova_reedigitada){
                    throw new \Exception("A nova senha digitada não corresponde com senha de confirmação.");
                }

                $usuario->password = $senha_nova;

                if($this->Ipsum->save($usuario)){

                    $this->Flash->success("Senha alterada com sucesso!");
                    
                    $this->__cnx->delete('ipsum_recovery_password', ["codigo = '{$codigo}'"]);
                    
                    return $this->redirect(['controller' => 'Home', 'action' => 'index']);
                    
                }
            }catch(\Exception $ex)
            {

                $this->Flash->warn($ex->getMessage());
            }
        }

    }

}

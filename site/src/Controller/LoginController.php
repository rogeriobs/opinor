<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\Core\Exception\Exception;

class UsuarioBloqueadoException extends Exception
{
    
}

class SenhaOuLoginInvalidosException extends Exception
{
    
}

class RecaptchaException extends Exception
{
    
}

class LoginController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel("Ipsum");

        $this->loadComponent('Csrf');

    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['signup', 'in', 'out', 'activeUser', 'reenviarEmailParaConfirmacao', 'recoverPassword']);

    }

    public function signup()
    {
        if(!$this->request->is("ajax")){
            exit();
        }

        try
        {
            $ipsum = $this->Ipsum->newEntity();

            if($this->request->is("post")){

                $this->request->data['status'] = "B";

                $ipsum = $this->Ipsum->patchEntity($ipsum, $this->request->data);

                if($result = $this->Ipsum->save($ipsum)){

                    $ipsum = $result;

                    $token = $this->__get_token_for_activation($ipsum->id);

                    $this->__enviar_email_para_confirmacao($ipsum, $token);

                    $this->set("email", $ipsum->email);

                    $this->render("success", "ajax");
                }else{
                    $this->Flash->error(__('Não é possível adicionar o usuário.'));
                }
            }
        }catch(Exception $ex)
        {

            //if(root)
            //$this->Flash->error($ex->getMessage());

            $this->Flash->error(__('Não foi possível adicionar o usuário.'));
        }

        $this->loadModel("Estados");

        $estados = $this->Estados->get_for_options_in_select();

        $this->set('ipsum', $ipsum);
        $this->set('estados', $estados);

    }

    public function in()
    {
        if(!$this->request->is("ajax")){
            exit();
        }

        if($this->request->is('post')){

            $recaptcha = new \ReCaptcha\ReCaptcha(RECAPTCHA_SECRET_KEY);

            try
            {

                $resp = $recaptcha->verify($this->request->data['g-recaptcha-response'], getIP());

                if(!$resp->isSuccess()){

                    //$errorsCodes = $resp->getErrorCodes();

                    throw new RecaptchaException("Houve um problema na validação do recaptcha...");
                }

                $user = $this->Auth->identify();

                if(!$user){

                    throw new SenhaOuLoginInvalidosException("E-mail e/ou senha invalidos.");
                }

                switch($user['status']):
                    case 'A':
                        $this->Auth->setUser($user);
                        $this->render("reload", "ajax");
                        break;
                    case 'B':
                        throw new UsuarioBloqueadoException("E-mail do usuário ainda não foi confirmado");
                        break;
                    case 'O':
                        throw new \Exception("E-mail ainda não confirmado.");
                        break;
                    default:

                        throw new \Exception("E-mail e/ou senha invalidos.");
                        break;
                endswitch;
            }catch(UsuarioBloqueadoException $ex)
            {

                $this->Flash->warn($ex->getMessage());

                $email = $this->request->data['email'];

                $ipsum = $this->Ipsum->find("all", [
                            "conditions" => [
                                "Ipsum.email"  => $email,
                                "Ipsum.status" => "B"
                            ],
                            "fields"     => [
                                "id",
                                "email",
                            ]
                        ])->first();

                $ipsum_id = isset($ipsum->id) ? encrypt($ipsum->id, CRYPT_KEY_FOR_ID) : false;

                if(!$ipsum_id){
                    die();
                }

                $this->set("ipsum_id", $ipsum_id);
                $this->set("email", $ipsum->email);
            }catch(\Exception $ex)
            {

                $this->Flash->error($ex->getMessage());
            }
        }

    }

    public function logout()
    {
        $this->Auth->logout();

        $this->request->session()->delete("Auth");

        return $this->redirect(["controller" => "Home", "action" => "index"]);

    }

    private function __get_token_for_activation($ipsum_id)
    {
        $this->loadModel("IpsumActivate");

        $ipsumActivate = $this->IpsumActivate->find("all", [
                    "conditions" => [
                        "IpsumActivate.ipsum_id" => $ipsum_id
                    ]
                ])->first();

        if(!$ipsumActivate){

            $token = md5(uniqid(rand(), true));

            $data = [
                "ipsum_id"        => $ipsum_id,
                "token"           => $token,
                "expiration_date" => date("Y-m-d", strtotime("+1 year"))
            ];

            $ipsumActivate = $this->IpsumActivate->newEntity();

            $ipsumActivate = $this->IpsumActivate->patchEntity($ipsumActivate, $data);

            $ipsumActivate = $this->IpsumActivate->save($ipsumActivate);
        }

        return $ipsumActivate->token;

    }

    public function activeUser($token = '')
    {
        $this->autoRender = false;

        $this->loadModel("IpsumActivate");

        if(!$token){
            die();
        }

        $ipsumActivate = $this->IpsumActivate->find("all", [
                    "conditions" => [
                        "IpsumActivate.token" => $token
                    ],
                    "contain"    => [
                        "Ipsum"
                    ]
                ])->first();

        if(isset($ipsumActivate->ipsum_id)){

            $this->__cnx->update('ipsum', ['status' => 'A'], ['id' => $ipsumActivate->ipsum_id]);

            $this->IpsumActivate->delete($ipsumActivate);

            $this->Flash->success(__('Confirmação realizada com sucesso.'));

            $this->Auth->setUser($ipsumActivate->ipsum);

            $this->redirect(["controller" => "Home", "action" => "index"]);
        }

        $this->redirect(["controller" => "Home", "action" => "index"]);

    }

    private function __enviar_email_para_confirmacao($ipsum, $token)
    {
        $email = new Email('default');

        if(AMBIENTE == 'LOCAL'){
            $email->to("rogerio.programmer@gmail.com");
        }else{
            $email->to($ipsum->email);
        }

        $link = Router::url(['controller' => 'Login', 'action' => 'activeUser', $token], true);

        $email->emailFormat('html');
        $email->template('activate_user', 'basic');
        $email->subject(__('Confirmação de email'));
        $email->viewVars(['link' => $link, 'nome' => $ipsum->nome]);

        return $email->send();

    }

    private function __enviar_email_para_recuperar_senha($ipsum, $codigo)
    {
        $email = new Email('default');

        if(AMBIENTE == 'LOCAL'){
            $email->to("rogerio.programmer@gmail.com");
        }else{
            $email->to($ipsum->email);
        }

        $link = Router::url(['controller' => 'Usuario', 'action' => 'criarNovaSenha', $codigo], true);

        $email->emailFormat('html');
        $email->template('criar_nova_senha', 'basic');
        $email->subject(__('Link para geração de nova senha'));
        $email->viewVars(['link' => $link, 'ipsum' => $ipsum]);

        return $email->send();

    }

    public function reenviarEmailParaConfirmacao()
    {
        $this->autoRender = false;

        $this->loadModel("IpsumActivate");

        if($this->request->is("ajax")){

            $jsonData = $this->request->input('json_decode');

            $ipsum_id = decrypt($jsonData->code, CRYPT_KEY_FOR_ID);

            $ipsumActivate = $this->IpsumActivate->find("all", [
                        "conditions" => [
                            "IpsumActivate.ipsum_id" => $ipsum_id
                        ],
                        "contain"    => [
                            "Ipsum"
                        ]
                    ])->first();

            if($ipsumActivate){

                if($this->__enviar_email_para_confirmacao($ipsumActivate->ipsum, $ipsumActivate->token)){

                    $this->response->type('json');
                    $this->response->body(json_encode(["message" => "O e-mail com o link foi reenviado com sucesso!"]));
                }
            }
        }

    }

    public function recoverPassword()
    {
        if($this->request->is('post')){

            extract($this->request->data);

            try
            {

                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    throw new \Exception("E-mail invalido...");
                }

                $ipsum = $this->Ipsum->find("all", [
                            "conditions" => [
                                "Ipsum.email" => $email
                            ]
                        ])->first();

                if(!count($ipsum)){

                    $this->Flash->success(__('E-mail não encontrado no sistema...'));

                    return $this->redirect(['action' => 'recoverPassword']);
                }

                $data_atual = date("Y-m-d");

                $codigo   = sha1(base64_encode(sha1(md5($ipsum->id))));
                $validade = date("Y-m-d", strtotime("+1 day"));

                $this->__cnx->delete('ipsum_recovery_password', ["validade_do_link <= '{$data_atual}' OR codigo = '{$codigo}'"]);

                $this->__cnx->insert('ipsum_recovery_password', [
                    'codigo'           => $codigo,
                    'ipsum_id'         => $ipsum->id,
                    'validade_do_link' => $validade,
                    'created'          => date("Y-m-d H:i:s"),
                ]);

                $result = $this->__enviar_email_para_recuperar_senha($ipsum, $codigo);

                $this->set("email", $email);

                $this->render("recovery_password_success", "ajax");
            }catch(\Exception $ex)
            {
                $this->Flash->success($ex->getMessage());
            }
        }

    }

}

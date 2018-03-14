<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * NewsortopicComments Controller
 *
 * @property \App\Model\Table\NewsortopicCommentsTable $NewsortopicComments
 */
class CommentsController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow(['load', 'save']);

    }

    public function load($artigo_id = '', $next = 0)
    {
        if(!$artigo_id){
            die();
        }

        if($this->request->is("ajax")){

            $artigo_id = decrypt($artigo_id, CRYPT_KEY_FOR_ID);

            $offset = ($next * 20);

            $next++;

            $orders_possiveis = [
                "mar" => "data_e_hora DESC",
                "map" => "total_rating DESC",
                "mao" => "positivo DESC",
                "man" => "negativo DESC"
            ];

            $orderBy = isset($orders_possiveis[$this->request->query("order")]) ?
                    $orders_possiveis[$this->request->query("order")] : "data_e_hora DESC";

            $sql = "SELECT 
                    nc.*,
                    i.nome,
                    COUNT(CASE WHEN ncr.type = '1' THEN 1 END) AS positivo,
                    COUNT(CASE WHEN ncr.type = '2' THEN 1 END) AS negativo,
                    COUNT(CASE WHEN ncr.type = '3' THEN 1 END) AS meio,
                    COUNT(CASE WHEN (ncr.type = '1' OR ncr.type = '2' OR ncr.type = '3') THEN 1 END) AS total_rating 
                FROM newsortopic_comments nc 
                    INNER JOIN ipsum i ON nc.ipsum_id = i.id
                LEFT JOIN newsortopic_comments_rating ncr ON ncr.newsortopic_comments_id = nc.id
                WHERE nc.newsortopic_id = :artigo_id AND nc.status = '1'
                GROUP BY nc.id, i.nome
                ORDER BY {$orderBy} OFFSET :offset LIMIT 20";

            $sql = $this->__cnx->execute($sql, ['artigo_id' => $artigo_id, 'offset' => $offset])->fetchAll('assoc');

            $sql_count = "SELECT COUNT(*) FROM newsortopic_comments nc WHERE nc.newsortopic_id = :artigo_id";
            $sql_count = $this->__cnx->execute($sql_count, ['artigo_id' => $artigo_id])->fetchAll('assoc');

            $show_btn_load_more = false;
            $total_de_comentarios = $sql_count[0]['count'];

            $possiveis_next = ceil($total_de_comentarios / 20);

            if($possiveis_next > $next){
                $show_btn_load_more = true;
            }

            /**
             * Pegar o rating do comentarios do usuario logado
             */
            $markratings = [];
            if($this->isLogged()):
                $sql_ratings = "SELECT 
                            ncr.type,
                            nc.id AS comentario_id
                           FROM newsortopic_comments_rating ncr 
                           INNER JOIN newsortopic_comments nc ON nc.id = ncr.newsortopic_comments_id 
                           WHERE ncr.ipsum_id = :ipsum_id AND nc.newsortopic_id = :artigo_id AND nc.status = '1'";
                $sql_ratings = $this->__cnx->execute($sql_ratings, ['artigo_id' => $artigo_id, 'ipsum_id' => $this->getUserData("id")])->fetchAll('assoc');

                foreach($sql_ratings as $_rating):
                    $markratings[$_rating['comentario_id']] = $_rating['type'];
                endforeach;
            endif;
            //-->

            $this->set("markratings", $markratings);
            $this->set("next", $next);
            $this->set("show_btn_load_more", $show_btn_load_more);
            $this->set("total_de_comentarios", $total_de_comentarios);
            $this->set("comentarios", $sql);

            if($next > 1){
                $this->render("load_more_comments", "ajax");
            }
        }

    }

    /**
     * Array
     *   (
     *       [_csrfToken] => e9e4c07c1ae2f74301dd5bfbe8a7a77ed8c474a3ffa6a359a6d2e8ea566612c560f7768feba705fed417d8b912d4f6d25be1a8c3ef41acb26997a0455be6c60f
     *       [mensagem] => dasdas
     *       [local] => localhost
     *       [__] => dXlpVVZyYWhUNjhLZEdubXJ3Nkg5dz09
     *   )
     */
    public function save()
    {
        $this->autoRender = false;

        if($this->request->is("ajax") && $this->request->is("post")){

            if($this->isLogged()){

                $return = [];

                extract($this->request->data);

                if(env("HTTP_HOST") == $local){ //validação muito simples
                    try{

                        $mensagem = h($mensagem);

                        $mensagem = strip_tags($mensagem, "<b><strong><em><i>");
                        
                        $mensagem = substr($mensagem, 0, 400);

                        if(!$mensagem){
                            die();
                        }

                        $newsortopic_id = decrypt($__, CRYPT_KEY_FOR_ID);

                        $this->__cnx->insert('newsortopic_comments', [
                            'newsortopic_id' => $newsortopic_id,
                            'ipsum_id' => $this->getUserData("id"),
                            'comentario' => $mensagem,
                            'data_e_hora' => date("Y-m-d H:i:s"),
                            'status' => "1",
                        ]);

                        $return = [
                            "result" => true,
                            "message" => "Comentário enviado.",
                            "message_icon" => "success"
                        ];
                    }catch(\Exception $ex){

                        $return = [
                            "result" => true,
                            "message" => "deu erro.",
                            "message_icon" => "error"
                        ];

                        if(Configure::read('debug')){
                            $return = [
                                "result" => false,
                                "message" => $ex->getMessage(),
                                "message_icon" => "error"
                            ];
                        }
                    }

                    $this->response->type('json');
                    $this->response->body(json_encode($return));
                }
            }
        }

    }

    /**
     * Array
     *   (
     *       [rate] => 3
     *       [commentset] => NjMveVhuT0o0UTQxT1doUG84aGVSV3VtSWIzdGlzWDBJci8yY3JVZnpacz0=
     *   )
     */
    public function setRatingInComment()
    {
        $this->autoRender = false;

        if(!$this->isLogged()){
            die('403');
        }

        if($this->request->is("post") && $this->request->is("ajax")){

            extract($this->request->data);

            $comentario_id = decrypt($commentset, CRYPT_KEY_FOR_ID);

            if(!$rate || !is_numeric($comentario_id)){
                die('a');
            }

            if(!is_numeric($rate) || ($rate < 1 || $rate > 3)){
                die('rate');
            }

            try{

                $result_count = $this->__cnx->execute("
                            SELECT COUNT(*) AS count FROM newsortopic_comments_rating 
                            WHERE ipsum_id = {$this->getUserData("id")} AND newsortopic_comments_id = {$comentario_id}       
                        ")->fetchAll('assoc');
                
                if($result_count[0]['count']){
                    die();
                }            
                            
                $this->__cnx->insert('newsortopic_comments_rating', [
                    'ipsum_id' => $this->getUserData("id"),
                    'newsortopic_comments_id' => $comentario_id,
                    'type' => $rate
                ]);
                
            }catch(\Exception $ex){

                die();
            }
        }

    }

}

<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class HomeController extends AppController
{

    use \App\Traits\AccessLog;

    /**
     * Atributo para guardar o link da conexão
     * 
     * @var resource 
     */
    protected $__cnx            = false;
    protected $__filtros_ativos = [];

    const limit_por_page = 50;

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

        $this->loadComponent('Csrf');

        //Pega a conexao
        $this->__cnx = ConnectionManager::get('default');

    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        if($this->request->session()->check("filters")){
            $this->__filtros_ativos = $this->request->session()->read("filters");
        }

        $this->Auth->allow(['index', 'removeFilter', 'loadMoreArticles', 'suggestions']);

    }

    public function index($offset = 0)
    {
        $this->loadModel("PollOptions");

        if($this->request->is('post')){

            $search = $this->request->data['search'];

            $termo = $this->__add_termo_in_session($search);

            //register log
            $this->register_search_term($this->__cnx, $termo);
        }

        $limit      = self::limit_por_page;
        $offset_set = 0;

        if($offset){
            $offset_set = $offset * $limit;
        }

        $filtros_ativos = $this->__make_filters_sql();

        $sql = "SELECT 
                    a.id AS article_id,
                    ARRAY_AGG(f.tag) AS Tags,
                    a.titulo AS article_titulo, 
                    a.texto_resumo AS article_resumo, 
                    a.alias AS article_alias, 
                    a.format_article AS article_format, 
                    a.fonte AS fonte, 
                    b.id AS enquete_id, 
                    b.titulo AS enquete_titulo, 
                    b.expiration_date AS enquete_validade, 
                    d.filename AS imagem_filename, 
                    d.legenda AS imagem_legenda, 
                    d.use_width AS imagem_width, 
                    d.use_height AS imagem_height, 
                    (
                      SELECT COUNT(*) FROM newsortopic_comments c WHERE c.newsortopic_id = a.id AND c.status = '1'
                    ) as total_de_comentarios 
              FROM 
                newsortopic a 
                INNER JOIN poll b ON a.poll_id = b.id 
                LEFT JOIN newsortopic_imagens d ON d.id = (
                  SELECT id FROM newsortopic_imagens e WHERE e.newsortopic_id = a.id AND e.head = true LIMIT 1
                ) LEFT JOIN newsortopic_tags f ON a.id = f.newsortopic_id
              WHERE 
                a.shutoff = false AND d.filename IS NOT NULL
                {$filtros_ativos}
              GROUP BY a.id, b.id, d.filename, d.legenda, d.use_width, d.use_height
              ORDER BY a.destaque_ordem ASC, a.id DESC
              LIMIT {$limit} OFFSET {$offset_set}";

        $articles_result = $this->__cnx->execute($sql)->fetchAll('assoc');

        if(count($articles_result)){

            foreach($articles_result as $indexList => $article):

                $option_poll = $this->PollOptions->get_options_with_results($article['enquete_id']);

                $articles_result[$indexList]['enquente_options'] = $option_poll;

            endforeach;
        }

        $offset++;

        $this->set("articles", $articles_result);
        $this->set("offset", $offset);
        $this->set("filtros_ativos", $this->__filtros_ativos);

        if($this->request->is('ajax')){
            $this->render('load_more_articles', 'ajax');
        }

    }

    private function __add_termo_in_session($termo)
    {
        if(empty(trim($termo))){
            return false;
        }

        $termo = \Cake\Utility\Text::truncate($termo, 40);

        $termo_key       = md5(strtolower($termo));
        $termo_descricao = $termo;

        $this->__filtros_ativos[$termo_key] = $termo_descricao;

        $this->request->session()->write("filters", $this->__filtros_ativos);

        return $termo;

    }

    public function removeFilter($key)
    {
        $this->request->session()->delete("filters.{$key}");

        return $this->redirect(['action' => 'index']);

    }

    private function __make_filters_sql()
    {
        //AND ((levenshtein(UNACCENT(LOWER(f.tag)), UNACCENT('desenho')) <= 2) OR (UNACCENT(a.titulo) ILIKE UNACCENT('%desenho%')) OR (UNACCENT(a.texto_resumo) ILIKE UNACCENT('%desenho%')) OR (UNACCENT(b.titulo) ILIKE UNACCENT('%desenho%')))
        $sqlWhere = '';

        $filtros = $this->__filtros_ativos;

        foreach($filtros as $key => $termo):

            $termo = escape_quote_pgsql($termo);

            $sqlWhere .= " AND (
                            (levenshtein(UNACCENT(LOWER(f.tag)), UNACCENT('{$termo}')) <= 2) OR 
                            (UNACCENT(a.titulo) ILIKE UNACCENT('%{$termo}%')) OR 
                            (UNACCENT(a.texto_resumo) ILIKE UNACCENT('%{$termo}%')) OR 
                            (UNACCENT(b.titulo) ILIKE UNACCENT('%{$termo}%'))
                         )";

        endforeach;

        return $sqlWhere;

    }

    public function suggestions($query = '')
    {
        $this->autoRender = false;

        $data = [];

        $primeiro_filtro = reset($this->__filtros_ativos);

        if($primeiro_filtro){

            $sql = "WITH __SQL AS (
                            SELECT a.tag AS Tag1, b.tag AS Tag2 
                            FROM newsortopic_tags a INNER JOIN newsortopic_tags b ON a.newsortopic_id = b.newsortopic_id
                            WHERE 
                            ((levenshtein(UNACCENT(LOWER(a.tag)), UNACCENT('{$primeiro_filtro}')) <= 1) OR a.tag ILIKE '%{$primeiro_filtro}%')
                            AND b.tag <> '{$primeiro_filtro}'
                            GROUP BY Tag2, Tag1
                            LIMIT 50
                    )

                    SELECT * FROM __SQL AS c
                    WHERE (levenshtein(UNACCENT(LOWER(c.tag2)), UNACCENT('{$query}')) <= 1) OR c.tag2 ILIKE '%{$query}%'";
        }else{

            $sql = "WITH __SQL AS (
                            SELECT LOWER(UNACCENT(a.tag)) AS tag2 FROM newsortopic_tags a
                            GROUP BY Tag2
                            LIMIT 50
                    )

                    SELECT * FROM __SQL AS c
                    WHERE (levenshtein(UNACCENT(LOWER(c.tag2)), UNACCENT('{$query}')) <= 1) OR c.tag2 ILIKE '%{$query}%'";
        }

        $sugestoes = $this->__cnx->execute($sql)->fetchAll('assoc');

        foreach($sugestoes as $sugestao):

            $data[] = ['value' => $sugestao['tag2'], 'data' => $sugestao['tag2']];

        endforeach;

        $this->response->type('json');
        $this->response->body(json_encode($data));

    }

}

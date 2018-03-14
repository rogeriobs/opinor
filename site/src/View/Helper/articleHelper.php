<?php

namespace App\View\Helper;

use Cake\View\Helper;

class articleHelper extends Helper
{

    public $helpers    = ['Url'];
    public $colors_tag = [
        "serie"         => ['class' => 'typeF', 'placeholder' => 'Digite um título, artista, diretor, etc.'],
        "series"        => ['class' => 'typeF', 'placeholder' => 'Digite um título, artista, diretor, etc.'],
        "filme"         => ['class' => 'typeF', 'placeholder' => 'Digite um título, artista, diretor, etc.'],
        "filmes"        => ['class' => 'typeF', 'placeholder' => 'Digite um título, artista, diretor, etc.'],
        "novela"        => ['class' => 'typeG', 'placeholder' => 'Digite um título, artista, diretor, etc.'],
        "novelas"       => ['class' => 'typeG', 'placeholder' => 'Digite um título, artista, diretor, etc.'],
        "personalidade" => ['class' => 'typeD', 'placeholder' => 'Digite o nome da personalidade...'],
        "famosos"       => ['class' => 'typeD', 'placeholder' => 'Digite o nome do famoso...'],
        "famoso"        => ['class' => 'typeD', 'placeholder' => 'Digite o nome do famoso...'],
        "celebridade"   => ['class' => 'typeD', 'placeholder' => 'Digite o nome da celebridade...'],
        "noticias"      => ['class' => 'typeA', 'placeholder' => 'Digite um título, fonte ou palavra-chave'],
        "noticia"       => ['class' => 'typeA', 'placeholder' => 'Digite um título, fonte ou palavra-chave...'],
        "carro"         => ['class' => 'typeE', 'placeholder' => 'Digite o nome do carro, marca, modelo, etc.'],
        "lugares"       => ['class' => 'typeC', 'placeholder' => 'Digite o nome de um lugar, cidade, estado, etc.'],
        "cidades"       => ['class' => 'typeC', 'placeholder' => 'Digite o nome de um lugar, cidade, estado, etc.'],
        "cidade"        => ['class' => 'typeC', 'placeholder' => 'Digite o nome de um lugar, cidade, estado, etc.'],
        "aplicativo"    => ['class' => 'typeE', 'placeholder' => 'Digite o nome do aplicativo...'],
        "app"           => ['class' => 'typeE', 'placeholder' => 'Digite o nome do aplicativo...'],
        "eletronico"    => ['class' => 'typeE', 'placeholder' => 'Digite um título, modelo ou marca...'],
        "comida"        => ['class' => 'typeJ', 'placeholder' => 'Digite o nome de um prato, ingrediente, restaurante e etc.'],
        "pratos"        => ['class' => 'typeJ', 'placeholder' => 'Digite o nome de um prato, ingrediente, restaurante e etc.'],
        "prato"         => ['class' => 'typeJ', 'placeholder' => 'Digite o nome de um prato, ingrediente, restaurante e etc.'],
        "alimento"      => ['class' => 'typeJ', 'placeholder' => 'Digite o nome de um prato, ingrediente, restaurante e etc.'],
    ];

    public function initialize(array $config)
    {
        parent::initialize($config);

    }

    public function picture($article)
    {
        if(empty($article['imagem_filename'])){
            return '';
        }

        $width       = ($article['imagem_width']) ? $article['imagem_width'] : "100%";
        $height      = ($article['imagem_height']) ? $article['imagem_height'] : "auto";
        $legenda     = $article['imagem_legenda'];
        $imagem_leve = $this->Url->build('/img/articles/leve/' . $article['imagem_filename'], true);
        $imagem_alta = $this->Url->build('/img/articles/alta/' . $article['imagem_filename'], true);

        $picture =  "<picture>
                        <source srcset=\"{$imagem_leve}\" media=\"(min-width: 1px) and (max-width: 767px)\">
                        <source srcset=\"{$imagem_alta}\" media=\"(min-width: 768px) and (max-width: 3200px)\">
                        <img srcset=\"{$imagem_alta}\" alt=\"{$legenda}\" width=\"{$width}\" height=\"{$height}\">
                    </picture>";
                        
        return remove_newlines($picture);

    }

    /**
     * Array
     *   (
     *       [id] =&gt; 2
     *       [label_text] =&gt; Bom
     *       [votos] =&gt; 2
     *       [total_votos] =&gt; 3
     *       [porcentagem] =&gt; 0.06
     *   )
     * 
     * @param type $option
     * @return string
     */
    public function get_option_poll($option)
    {
        extract($option);

        $label_total_votos = ($votos > 1) ? "{$votos} votos" : "{$votos} voto";
        $porcentagem       = ($porcentagem) ? round($porcentagem, 2) . "%" : 0;

        $li = "<li>
                    <div class =\"bs-callout\">
                        <h4>{$label_text}</h4>
                        {$porcentagem} - {$label_total_votos}
                    </div>
               </li>";
        return remove_newlines($li);

    }

    public function get_count_comentarios($comentarios)
    {

        return ($comentarios == 1) ? "{$comentarios} comentários" : "{$comentarios} comentário";

    }

    public function get_option_poll_votes($votos)
    {
        return ($votos == 1) ? "{$votos} voto" : "{$votos} votos";

    }

    public function get_option_poll_round($porcentagem)
    {
        return round($porcentagem, 2);

    }

    public function setMarkRating_in_comentario($ratings, $comentario_id, $type)
    {
        if(count($ratings)){

            if(isset($ratings[$comentario_id])){

                return $ratings[$comentario_id] == $type ? "ratecommentcomputed{$type}" : "";
            }
        }

        return "";

    }

    /**
     * 
     * 
     * @param type $termo
     */
    public function adjust_filter($filtro, $keyFilter)
    {
        $filtro_digitado = $filtro;

        $filtro = \Cake\Utility\Inflector::slug($filtro, '_');

        $termo = isset($this->colors_tag[$filtro]) ? $this->colors_tag[$filtro] : false;

        $classType   = '';
        $placeholder = '';

        if($termo){

            $classType   = $termo['class'];
            $placeholder = $termo['placeholder'];

            echo "<script>
                    $(function () {
                        $(\"#input-search\").prop('placeholder', '" . $placeholder . "');
                    });
                 </script>";
        }

        echo "<li class='{$classType}'>";
        echo "<a href='" . $this->Url->build(['controller' => 'Home', 'action' => 'removeFilter', $keyFilter]) . "' title=\"Clique aqui para remover este filtro\">";
        echo $filtro_digitado;
        echo "<i class=\"fa fa-times\" aria-hidden=\"true\"></i>";
        echo "</a>";
        echo "</li>";

    }

}

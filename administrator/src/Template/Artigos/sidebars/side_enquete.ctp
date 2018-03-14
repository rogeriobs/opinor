<div class="input-group">
    <input id="artigo_enquete_titulo" type="text" class="form-control" placeholder="Nenhuma enquete selecionada..." disabled="disabled" value="<?= @$newsortopic->poll->titulo ?>">
    <span class="input-group-btn">
        <a class="btn btn-default"  href="javascript:void(0)">
            <span class="glyphicon glyphicon-remove"></span>
        </a>
        <a class="get-async-modal btn btn-default" data-modal="#ModalEnquete"  href="<?= $this->Url->build(["action" => "SelecionarEnquete"]) ?>">Selecionar</a>
    </span>
</div><!-- /input-group -->

<?php

include '../src/Template/Artigos/modais/enquete.ctp';
//require 'modais/new_enquete.ctp';

echo $this->Form->control('poll_id', ['id' => 'artigo_enquete_id', 'type' => 'hidden', 'value' => $newsortopic->poll_id]);

?>
<div id="alert-poll-notsave" style="display: none; margin-top: 20px" class="alert alert-info" role="alert">
    Nova enquete selecionada, ainda não foi salvo no artigo!
</div>
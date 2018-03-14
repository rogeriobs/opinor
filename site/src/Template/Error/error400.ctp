<?php

use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

if(Configure::read('debug')):

    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');

    ?>
    <?php if(!empty($error->queryString)) : ?>
        <p class="notice">
            <strong>SQL Query: </strong>
            <?= h($error->queryString) ?>
        </p>
    <?php endif; ?>
    <?php if(!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
    <?php endif; ?>
    <?= $this->element('auto_table_warning') ?>
    <?php

    if(extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>Oops!</h1>
                <?=$this->Html->image("icons/green-apple.png", ['width' => '35%']) ?>
                <h2>404 - Página não encontrada</h2>
                <div class="error-details">
                    Desculpe, ocorreu um erro, a página solicitada não encontrada!
                </div>
                <div class="error-actions">
                    <a href="<?=$this->Url->build(['controller' => 'Home', 'action' => 'index']) ?>" class="btn btn-primary btn-lg">
                        <span class="glyphicon glyphicon-home"></span>
                        Ir para Home </a>
                    <a href="javascript:void(0)" onclick="history.go(-1); return false;" class="btn btn-link btn-lg">
                        <span class="glyphicon glyphicon-envelope"></span> 
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
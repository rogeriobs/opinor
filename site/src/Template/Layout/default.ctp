<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <meta name="ROBOTS" content="INDEX,FOLLOW">
        <meta name="author" content="enqutes.info">
        <meta name="google-site-verification" content="gtIN3LaPoCfyfwOhQHQ-pkjTUbKASKGWlVPEhbnbOb8" />

        <?= $this->Html->css(['style-base', 'extras', 'loading', 'site']) ?>
        <?= $this->Html->script(['plugins-base', 'scripts']) ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>    
        <?= $this->element("google-analytics") ?>
               
        <?= $this->element("loading") ?>

        <nav class="navbar navbar-home navbar-toggleable-md navbar-inverse bg-inverse fixed-top">

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsHomeSearch" aria-controls="navbarsHomeSearch" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a title="enquetes.info" class="navbar-brand" href="<?= $this->Url->build(['controller' => 'home', 'action' => 'index']) ?>">
                <?=$this->Html->image("icons/logo.png", ['width' => '100%']) ?>
            </a>

            <div class="collapse navbar-collapse" id="navbarsHomeSearch">

                <div class="home-area-search">

                    <div class="container-input">
                        <ul>
                            <?php foreach($filtros_ativos as $keyFilter => $filtro): ?>

                                <?= $this->article->adjust_filter($filtro, $keyFilter); ?>

                            <?php endforeach; ?>
                        </ul>
                        <form method="post" id="frmSearchHome" onsubmit="return $('#input-search').val() != ''">
                            <div style="display:none;">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="_csrfToken" value="<?= $this->request->params['_csrfToken'] ?>">
                            </div>
                            <input id="input-search" class="input-search" type="text" placeholder="Digite um termo para buscar" name="search" autocomplete="off">
                            <button class="btn-go" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="info-userlogged <?= (!$this->Auth->isLogged()) ? "notconnected" : "" ?>">

                    <?php if($this->Auth->isLogged()): ?>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?= $this->Auth->getUserData("nome") ?> <i class="fa fa-user"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="<?= $this->Url->build(['controller' => 'Usuario', 'action' => 'MeusDados']) ?>">Meus dados</a></li>
                                    <li><a href="<?= $this->Url->build(["controller" => "Usuario", "action" => "alterarSenha"]) ?>">Alterar Senha</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= $this->Url->build(['controller' => 'Login', 'action' => 'logout']) ?>">Sair</a></li>
                                </ul>
                            </li>
                        </ul>

                    <?php else: ?>
                        <span class="not-connected">Você não está conectado no site</span>
                        <a class="btn-loginsite MyModalLoginOpen" href="javascript:void(0)">Conectar</a>
                    <?php endif; ?>

                </div>

            </div>

        </nav>

        <div class="content-list">
            <?php echo $this->fetch('content') ?>
        </div>

        <?php echo $this->Flash->render() ?>
    </body>
</html>
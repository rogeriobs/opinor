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

        <?= $this->Html->css(['style-base', 'extras', 'loading', 'site', 'artigo', 'pgwslideshow']) ?>
        <?= $this->Html->script(['plugins-base', 'scripts']) ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>    
        <?= $this->element("google-analytics") ?>
        
        <?php $this->Flash->render() ?>

        <?= $this->element("loading") ?>

        <?= $this->fetch('content') ?>

    </body>
</html>
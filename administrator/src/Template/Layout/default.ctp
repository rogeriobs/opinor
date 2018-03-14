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
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <?php

        echo $this->Html->css([
            'bootstrap.css',
            'bootstrap-theme',
            'font-awesome',
            'menu',
            'jquery.toast',
            'jquery-confirm',
            'tabulator',
            'menu_actions',
            'sumoselect',
            'loading',
            'main',
        ]);
        echo $this->Html->script([
            'jquery-3.2.1.min',
            'bootstrap',
            'moment-with-locales',
            'scoop.min',
            'menu',
            'jquery-confirm',
            'menu_actions',
            'jquery.toast',
            'tabulator',
            'jquery.sumoselect',
            'scripts',
            'scripts_ajax',
        ])

        ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <?= $this->Flash->render() ?>

        <?= $this->element("loading") ?>

        <div id="scoop" class="scoop" style="display: none;">
            <!--    <div class="scoop-overlay-box"></div>-->
            <div class="scoop-container">  
                <header class="scoop-header">
                    <?= $this->element("layout_default/topo") ?>
                </header>
                <div class="scoop-main-container">

                    <div class="scoop-wrapper">

                        <nav class="scoop-navbar">  

                            <div class="scoop-inner-navbar"> 

                                <div class="scoop-navigatio-lavel">Menu</div>

                                <?= $this->element("layout_default/menu") ?>    
                            </div> 
                        </nav> 
                        <div class="scoop-content"> 
                            <div class="scoop-inner-content">
                                <?= $this->fetch('content') ?>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>        
    </body>
</html>

<?php if($menu): ?>
    <?php foreach($menu as $m1): ?>
        <ul class="scoop-item scoop-left-item">   

            <li class="scoop-hasmenu">
                <a href="javascript:void(0)">
                    <span class="scoop-micon">
                        <i class="fa <?= $m1->faicon ?>"></i>
                    </span>
                    <span class="scoop-mtext"><?= $m1->descricao ?></span>
                    <span class="scoop-mcaret"></span>
                </a>

                <ul class="scoop-submenu">
                    <?php foreach($m1->admin_menu_itens as $menu_item): ?>
                        <li>
                            <a href="<?= $this->Url->build(["controller" => $menu_item->controller_go, "action" => $menu_item->action_go, $menu_item->params]) ?>">
                                <span class="scoop-micon"><i class="icon-link"></i></span>
                                <span class="scoop-mtext"><?= $menu_item->descricao ?></span>
                                <span class="scoop-mcaret"></span>
                            </a> 
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li> 
        </ul>
    <?php endforeach; ?>
<?php endif; ?>
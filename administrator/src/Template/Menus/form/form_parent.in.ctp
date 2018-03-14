<?php

echo $this->Form->control('admin_menu_id', ['options' => $adminMenu]);
echo $this->Form->control('descricao');
echo $this->Form->control('ordem');
echo $this->Form->control('action_perm');
echo $this->Form->control('params');
echo $this->Form->control('controller_go');
echo $this->Form->control('action_go');
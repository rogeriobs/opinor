<div class="row">
    <div class="col-md-6 padR">
        <?php echo $this->Form->control('admin_menu_id', ['options' => $adminMenu, 'class' => 'form-control sumo_select', 'empty' => '&nbsp;']); ?>
    </div>
    <div class="col-md-6 padL">
        <?php echo $this->Form->control('descricao', ['class' => 'form-control']); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 padR">
        <?php echo $this->Form->control('controller_go', ['class' => 'form-control']); ?>
    </div>
    <div class="col-md-6 padL">
        <?php echo $this->Form->control('action_go', ['class' => 'form-control']); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4 padR">
        <?php echo $this->Form->control('params', ['class' => 'form-control']); ?>
    </div>
    <div class="col-md-4 padR padL">
        <?php echo $this->Form->control('ordem', ['class' => 'form-control']); ?>
    </div>
    <div class="col-md-4 padL">
        <?php echo $this->Form->control('action_perm', ['class' => 'form-control']); ?>
    </div>
</div>
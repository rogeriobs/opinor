<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('shutoff'); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('titulo', ['class' => 'form-control']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('texto_resumo', ['class' => 'form-control', 'type' => 'textarea']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('poll_id', ['options' => $poll, 'empty' => ' -- Enquete -- ', 'class' => 'sumo_select']); ?>
    </div>
</div>
<div class="row __newpoll" style="display: none;">
    <div class="col-md-12">
        <?php echo $this->Form->control('newpoll', ['type' => "textarea", 'class' => 'form-control', 'escape' => false, 'label' => 'Nova Enquete']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <?php echo $this->Form->control('format_article', ['class' => 'sumo_select', 'options' => $format_article]); ?>
    </div>
</div>

<script type="text/javascript">
    $("#btn-newPoll").click(function(){
        $(".__newpoll").fadeIn();
    });
</script>
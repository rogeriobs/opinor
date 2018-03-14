<div class="row">
    <div class="col-md-12">
        <?php echo $this->Form->control('label_text', ['class' => 'form-control']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php echo $this->Form->control('ordem', ['class' => 'form-control']); ?>
    </div>
    <div class="col-md-6">
        <?php echo $this->Form->control('poll_id', ['type' => 'hidden', 'value' => isset($poll_id) ? $poll_id : $pollOption->poll_id]); ?>
    </div>
</div>
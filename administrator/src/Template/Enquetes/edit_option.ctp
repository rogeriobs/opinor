<?= $this->Form->create($pollOption) ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="ModalNewLabel"><?= __('Editar opção de enquete') ?></h4>
</div>
<div class="modal-body">
    <?php require_once 'form/form_option.in.ctp'; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Salvar</button>
</div>
<?= $this->Form->end() ?>
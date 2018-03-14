<?php if (isset($reload)): ?>

    <script>
        var ModalManagerParent = $("#ModalManagerParent");

        ModalManagerParent.find('.modal-content');

        $.get('<?= $this->Url->build(['controller' => 'Menus', 'action' => 'managerMenuParent']) ?>', function (html) {
            ModalManagerParent.find('.modal-content').html(html);
        });
    </script>

<?php else: ?> 

    <hr>

    <div class="bs-callout bs-callout-primary">
        <h4>Você esta editando:</h4>
        registro id: <?=$adminMenu->id?>
    </div>

    <?= $this->Form->create($adminMenu, ["id" => "frm-Menuparent"]) ?>
    <div class="row">
        <div class="col-md-6 padR">
            <?php echo $this->Form->control('descricao', ['class' => 'form-control', 'label' => 'Descrição']); ?>
        </div>
        <div class="col-md-2 padR padL">
            <?php echo $this->Form->control('ordem', ['class' => 'form-control']); ?>
        </div>
        <div class="col-md-4 padL">
            <?php echo $this->Form->control('faicon', ['class' => 'form-control', 'label' => 'fa-icon']); ?>
        </div>
    </div>

    <br>

    <button type="button" class="btn btn-success btn-saveMenuParent"><i class="fa fa-arrow-right"></i> Salvar</button>

    <?= $this->Form->end() ?>

    <script>

        $(".btn-saveMenuParent").click(function (e) {

            var dataForm = $("#frm-Menuparent").serialize();

            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Menus', 'action' => 'MenuParentEdit', $adminMenu->id]) ?>',
                type: 'POST',
                data: dataForm,
                beforeSend: function (xhr) {
                    $("#__menu-parent-form").html(get_loading_inner_modal());
                },
                success: function (data, textStatus, jqXHR) {

                    $("#__menu-parent-form").html(data);
                }
            });

        });
    </script>

<?php endif; ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="modal-title" id="ModalNewLabel"><?= __('Editar Perfil') ?></h3>
</div>
<div class="modal-body" id="modal-body-list-menus" style="visibility: hidden">
    <table id="tbl__listMenusParent" class="display" cellspacing="0" width="100%" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Ordem</th>
                <th>Icon</th>
                <th>Criado em:</th>
                <th>Modificado em:</th>
                <th class="centered-text"></th>
                <th class="centered-text"></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Ordem</th>
                <th>Icon</th>
                <th>Criado em:</th>
                <th>Modificado em:</th>
                <th class="centered-text"></th>
                <th class="centered-text"></th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($menus_parents as $menu): ?>
                <tr data-id="<?= $menu->id ?>">
                    <td class="size1"><?= $menu->id ?></td>
                    <td><?= $menu->descricao ?></td>
                    <td><?= $menu->ordem ?></td>
                    <td><i class="fa <?= $menu->faicon ?>"></i> (<?= $menu->faicon ?>)</td>
                    <td><?= $menu->created->format("d/m/Y H:i") ?></td>
                    <td><?= $menu->modified->format("d/m/Y H:i") ?></td>
                    <td class="centered-text size1"><a title="Editar" class="btn btn-default btn-editmenuparent" href="javascript:void(0)"><i class="fa fa-pencil"></i></a></td>
                    <td class="centered-text size1"><a title="Excluir" class="btn btn-danger btn-removemenuparent" href="javascript:void(0)"><i class="fa fa-remove"></i></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <div id="__menu-parent-form">



    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" id="btnNewMenuParent"><i class="fa fa-plus"></i> Novo</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
</div>

<script>

    setTimeout(function () {

        tableMMP = $('#tbl__listMenusParent').DataTable({
            scrollY: 300,
            scrollX: true,
            aaSorting: [],
            bAutoWidth: true,
            "aoColumnDefs": [
                {'bSortable': false, 'aTargets': [6, 7]},
                { type: 'de_datetime', aTargets: [4, 5]}
            ]
        });

        $("#modal-body-list-menus").css('visibility', 'visible');

        $('#tbl__listMenusParent tbody').on('click', '.btn-removemenuparent', function () {

            var tr = $(this).parents('tr');
            var id = tr.data("id");

            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Menus', 'action' => 'deleteMenuParent']) ?>',
                type: 'DELETE',
                data: {'id': id},
                success: function (msg, textStatus, jqXHR) {
                    tableMMP.row(tr).remove().draw();
                    $.toast(msg);
                    $("#__menu-parent-form").html("");
                }
            });

        });

        $('#tbl__listMenusParent tbody').on('click', '.btn-editmenuparent', function () {

            var tr = $(this).parents('tr');
            var id = tr.data("id");

            $("#__menu-parent-form").html(get_loading_inner_modal());

            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Menus', 'action' => 'MenuParentEdit']) ?>/' + id ,
                success: function (data, textStatus, jqXHR) {
                    $("#__menu-parent-form").html(data);
                }
            });

        });

    }, 100);

    $("#btnNewMenuParent").click(function (e) {

        $("#__menu-parent-form").html(get_loading_inner_modal());

        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Menus', 'action' => 'MenuParentNew']) ?>',
            success: function (data, textStatus, jqXHR) {
                $("#__menu-parent-form").html(data);
            }
        });
    });

</script>

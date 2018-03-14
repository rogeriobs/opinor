<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="ModalNewLabel"><?= __('Nova enquete') ?></h4>
</div>
<div class="modal-body">

    <table id="tbl_selectPOll" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>Enquete</th>
                <th>ID</th>
                <th>Validade</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>Enquete</th>
                <th>ID</th>
                <th>Validade</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach($enquetes as $enquete): ?>
                <tr>
                    <td class="size1">
                        <a class="btn btn-default btn-select-poll" data-titulo="<?= $enquete->titulo ?>" data-id="<?= $enquete->id ?>"><i class="fa fa-check"></i></a>
                    </td>
                    <td nowrap="nowrap"><?= $enquete->titulo ?></td>
                    <td><?= $enquete->id ?></td>
                    <td><?= $enquete->expiration_date ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
</div>

<script>
    $(document).ready(function () {

        setTimeout(function () {

            $('#tbl_selectPOll').DataTable({
                scrollY: 300,
                scrollX: true,
                aaSorting: [],
                bAutoWidth: true,
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [0]},
                            //{ type: 'de_datetime', aTargets: [4, 5]}
                ]
            });

            $(".btn-select-poll").click(function () {
                var objInputTitulo = $("#artigo_enquete_titulo");
                var objInputId = $("#artigo_enquete_id");

                var titulo = $(this).data("titulo");
                var pollid = $(this).data("id");

                objInputId.val(pollid);
                objInputTitulo.val(titulo);
                
                $("#alert-poll-notsave").fadeIn();

                $("#ModalEnquete").modal("hide");
            });

        }, 100);
    });
</script>
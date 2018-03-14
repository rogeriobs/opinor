<table id="tbl__listComments" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th class="center-text">Status Usuário</th>
            <th>Comentario</th>
            <th>ID Comentário</th>
            <th>Status Comentário</th>
            <th class="center-text">Data e hora</th>
            <th>Likes</th>
            <th>Unlikes</th>
            <th>Maybes</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Nome</th>
            <th class="center-text">Status Usuário</th>
            <th>Comentario</th>
            <th>ID Comentário</th>
            <th>Status Comentário</th>
            <th nowrap="nowrap">Data e hora</th>
            <th>Likes</th>
            <th>Unlikes</th>
            <th>Maybes</th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach($comentarios as $comentario): ?>
            <tr>
                <td nowrap="nowrap"><?= $comentario->ipsum->nome ?></td>
                <td class="center-text"><?= $comentario->ipsum->status ?></td>
                <td><?= $comentario->comentario ?></td>
                <td class="center-text"><?= $comentario->id ?></td>
                <td class="center-text"><?= ($comentario->status == '1') ? "<span class=\"label label-success\">Ativo</span>" : "<span class=\"label label-danger\">Desativado</span>" ?> </td>
                <td nowrap="nowrap"><?= $comentario->data_e_hora ?></td>
                <td class="center-text"><?= $comentario->likes ?></td>
                <td class="center-text"><?= $comentario->notlikes ?></td>
                <td class="center-text"><?= $comentario->maybes ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>

    setTimeout(function () {

        tableMMP = $('#tbl__listComments').DataTable({
            scrollY: 300,
            scrollX: true,
            aaSorting: [],
            bAutoWidth: true,
            "aoColumnDefs": [
                //{'bSortable': false, 'aTargets': [6, 7]},
                {type: 'de_datetime', aTargets: [6]}
            ]
        });

    }, 100);

</script>

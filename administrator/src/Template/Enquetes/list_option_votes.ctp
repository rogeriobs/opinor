<h2 class="subtit-page">Votos da opção :: <?= $poll_option_id ?></h2>


<table id="tbl_list_poll_option_votes" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Usuario ID</th>
            <th>IP</th>
            <th>Criando em</th>
            <th>Modificado em</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Nome</th>
            <th>Usuario ID</th>
            <th>IP</th>
            <th>Criando em</th>
            <th>Modificado em</th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach($votos as $voto): ?>
            <tr>
                <td><?= $voto->ipsum->nome ?></td>
                <td><?= $voto->ipsum->id ?></td>
                <td><?= $voto->ip ?></td>
                <td><?= $voto->created ?></td>
                <td><?= $voto->modified ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $('#tbl_list_poll_option_votes').DataTable({
            aaSorting: [],
            bAutoWidth: true,
            "aoColumnDefs": [
                {type: 'de_datetime', aTargets: [3, 4]}
            ]
        });
    });
</script>
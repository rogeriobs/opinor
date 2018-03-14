<?php if($enquete): ?>

    <?php $total_votos = 0; ?>

    <div class="bs-callout bs-callout-primary" id="callout-labels-inline-block"> 
        <h4><?= $enquete->titulo ?></h4> 
        <br>
        <p>Validade: <strong><?=$enquete->expiration_date ?></strong>
        </p> 
    </div>


    <table id="tbl__listPollOptions" class="display table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Option ID</th>
                <th>Label</th>
                <th>Votos</th>
                <th>Total de Votos</th>
                <th>Porcentagem</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Option ID</th>
                <th>Label</th>
                <th>Votos</th>
                <th>Total de Votos</th>
                <th>Porcentagem</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach($enquete->pollOptions as $option): ?>            
                <tr>
                    <td><?= $option['id'] ?></td>
                    <td><?= $option['label_text'] ?></td>
                    <td><?= $option['votos'] ?></td>
                    <td><?= $option['total_votos'] ?></td>
                    <td><?= round($option['porcentagem'],2) ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>

        setTimeout(function () {

            tableMMP = $('#tbl__listPollOptions').DataTable({
                aaSorting: [],
                bAutoWidth: true,
                "aoColumnDefs": [
                    //{'bSortable': false, 'aTargets': [6, 7]},
                    //{type: 'de_datetime', aTargets: [6]}
                ]
            });

        }, 100);

    </script>

<?php else: ?>

    Nenhuma enquete cadastrada...

<?php endif; ?>

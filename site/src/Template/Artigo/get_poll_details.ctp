<?= $this->Html->script(['jquery.dataTables']) ?><?= $this->Html->css(['datatable.details']) ?><div id="__wrapper-tbl-report" style="visibility: hidden;"><table id="tbl-report-poll" cellspacing="0" width="100%"><thead><tr><th>Idade</th><th>Centro-Oeste</th><th>Nordeste</th><th>Norte</th><th>Sudeste</th><th>Sul</th><th>Total</th></tr></thead><tfoot><tr><th>Idade</th><th>Centro-Oeste</th><th>Nordeste</th><th>Norte</th><th>Sudeste</th><th>Sul</th><th>Total</th></tr></tfoot><tbody><?php foreach($dados as $idade => $regiao): ?><tr><td><?php echo $idade ?> anos</td><td><?php echo isset($regiao['Centro-Oeste']) ? $regiao['Centro-Oeste'] : 0 ?></td><td><?php echo isset($regiao['Nordeste']) ? $regiao['Nordeste'] : 0 ?></td><td><?php echo isset($regiao['Norte']) ? $regiao['Norte'] : 0 ?></td><td><?php echo isset($regiao['Sudeste']) ? $regiao['Sudeste'] : 0 ?></td><td><?php echo isset($regiao['Sul']) ? $regiao['Sul'] : 0 ?></td><td><?php echo array_sum($regiao) ?></td></tr><?php endforeach; ?></tbody></table></div><script type="text/javascript"> $(document).ready(function () { setTimeout(function () { $('#tbl-report-poll').DataTable({ "paging": false, "search": false, "info": false, "searching": false, "scrollY": "400px", "scrollCollapse": true, "aaSorting": [] }); $("#__wrapper-tbl-report").css('visibility', 'visible'); }, 200); }); </script>
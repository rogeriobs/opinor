<div class="content-mydata">

    <?= $this->Form->create($ipsum, ['class' => 'form-labels-on-top', "onsubmit" => "showLoading()"]) ?>

    <div class="form-title-row">
        <h1>Meus Dados</h1>
    </div>

    <div class="form-row">        
        <?php echo $this->Form->input('nome'); ?>
    </div>

    <div class="form-row">        
        <?php echo $this->Form->input('email', ['disabled' => true]); ?>
    </div>

    <div class="form-row">
        <?php echo $this->Form->input('data_nascimento', ['minYear' => date('Y') - 100, 'maxYear' => date('Y') - 18]); ?>
    </div>

    <div class="form-row">
        <?= $this->Form->input('estados', ['required' => true, 'class' => '', "options" => $estados, "label" => "Estado", "empty" => ["" => " -- selecione seu estado -- "], "value" => $ipsum->cidade->estado_id]) ?>
    </div>

    <div class="form-row">
        <?= $this->Form->input('cidade_id', ['class' => '', "options" => [], "label" => "Cidade", "empty" => ["" => " -- selecione sua cidade -- "]]) ?>
    </div>

    <div class="form-row">
        <button class="btn btn-success" type="submit">Salvar dados</button>
    </div>

    <?= $this->Form->end() ?>

</div>

<script type="text/javascript">
    $(function () {

        $("#estados").change(function (e) {

            var estado_selected = $(this).val();

            if (estado_selected == '')
                return false;

            reqCid = $.ajax({
                url: '<?= $this->Url->build(["controller" => "Cidades", "action" => "getCidades"]) ?>',
                cache: false,
                global: false,
                type: 'POST',
                data: {'estado_id': estado_selected},
                beforeSend: function (xhr) {
                    $("#cidade-id").html("<option value=''>Carregando...</option>");
                },
                success: function (data, textStatus, jqXHR) {
                    $.when($("#cidade-id").html(data)).done(function () {

                        var cidade_id_selected = '<?= @$ipsum->cidade_id ?>';
                        $("#cidade-id").val(cidade_id_selected);
                    });
                }
            });
        }).trigger("change");

    });
</script>
<h2 class="tit-page">Artigos</h2>

<div class="row">
    <div class="col-md-6">
        <div class="area-filtros">
            <h4>Filtros</h4>
            <?php

            $this->Form->templates([
                'inputContainer' => '{{content}}',
            ]);

            ?>
            <?= $this->Form->create(null, ['class' => '']) ?>
            <div class="row">
                <div class="col-md-2 padR">
                    <?php echo $this->Form->control('buscar_id', ['class' => 'form-control', "label" => "ID", "type" => 'text']); ?>
                </div>
                <div class="col-md-4 padL padR">
                    <?php echo $this->Form->control('buscar_titulo', ['class' => 'form-control', "label" => "Título"]); ?>
                </div>
                <div class="col-md-2 padL padR">
                    <?php echo $this->Form->control('buscar_shutoff', ['class' => 'form-control sumo_select', "label" => "Shutoff", "options" => ['1'=> "Sim", '0' => "Não"], "empty" => " -- Todos -- "]); ?>
                </div>
                <div class="col-md-4 padL">
                    <?php echo $this->Form->control('buscar_cadastroem', ['class' => 'form-control sumo_select', "label" => "Cadastrado em", "options" => ['nestemes' => "Enquentes cadastradas neste mês", 'nesteano' => "Enquetes cadastradas neste ano"], "empty" => "&nbsp;"]); ?>
                </div>
            </div>           

            <hr>

            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>

            <a class="btn" href="<?= $this->Url->build(['action' => 'clear_filters']) ?>">
                <i class="fa fa-eraser"></i> Limpar filtros
            </a>

            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="col-md-6">
        <!--nada-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="container-grid">
            <div class="container-tools-grid">
                <a href="javascript:void(0)" class="btn btn-gray2 select-all"><i class="fa fa-plus-square-o"></i></a>
                <a href="javascript:void(0)" class="btn btn-gray2 deselect-all"><i class="fa fa-minus-square-o"></i></a>
                <a href="javascript:void(0)" class="btn btn-default download-csv"><i class="fa fa-download"></i> CSV</a>
                <a class="get-async-modal btn btn-default" data-modal="#ModalNew" href="<?= $this->Url->build(["action" => "add"]) ?>"><i class="fa fa-plus"></i> novo</a>
                <a class="btn btn-danger btn-only-selected remove-selected" href="javascript:void(0)" data-urldelete="<?= $this->Url->build(['action' => 'delete']) ?>"><i class="fa fa-trash"></i> excluir itens selecionados</a>
                <a class="btn btn-default btn-only-one edit-selected" href="javascript:void(0)" data-urledit="<?= $this->Url->build(["action" => "edit"]) ?>"><i class="fa fa-pencil"></i> Editar</a>
            </div>
            <div class="tabulator-style" id="table-index-unique" data-load="<?= $this->Url->build(["action" => "loadData"]) ?>"></div>
        </div>
    </div>
</div>

<?php require_once 'modais/new.ctp'; ?>

<script>
    $(function () {

        tablePU = $("#table-index-unique");

        tablePU.tabulator({
            height: "500px",
           // persistentLayout: true, //Enable column layout persistence
            //persistentLayoutID: "<?= $this->name ?>", //id string, can only be numbers, letters, hyphens and underscores.
            //groupBy:"role",
            columns: [
                {formatter: fn_checkInput,
                    width: 40,
                    align: "center",
                    frozen: true
                },
                {title: "id", field: "id", width: 50, sorter: "number"},
                {title: "Título", field: "titulo", width: 300},
                {title: "Alias", field: "alias", width: 200},
                {title: "Shuttoff", field: "shutoff_label", width: 100},
                {title: "Data de publicação", field: "data_de_publicacao", width: 200},
                {title: "Data da fonte", field: "data_da_fonte", width: 200},
                {title: "texto resumo", field: "texto_resumo", width: 200},
                {title: "texto completo", field: "texto_full", width: 200},
                {title: "meta title", field: "meta_title", width: 200},
                {title: "meta description", field: "meta_description", width: 200},
                {title: "meta keywords", field: "meta_keywords", width: 200},
                {title: "format view [class]", field: "format_article", width: 200},
                {title: "Enquete", field: "poll_titulo", width: 210},
                {title: "Enquete ID", field: "poll_id", width: 150},
                {title: "Enquete Validade", field: "poll_validade", width: 200},
                {title: "Enquete total votos", field: "count_votes", width: 200},
                {title: "Total de comentários", field: "count_comentarios", width: 200},
                {title: "Total imagens", field: "count_imagens", width: 200},
                {title: "criado em", field: "created_formated", width: 150, sorter:"datetime"},
                {title: "modificado em", field: "modified_formated", width: 150, sorter:"datetime"},
            ],
            dataLoaded: function () {
                hide_loading_inner_tabulator();
            },
            rowClick: function (e, id, data, row) {

                $(row).find(".tabulator-frozen > .tabulator-cell .check-selectable").trigger("click");

            },
            rowContext: function (e, id, data, row) {
                console.log("Row " + id);
            },
            selectableCheck: function (data, row) {
                if ($(row).hasClass("tabulator-selected")) {
                    $(row).find(".tabulator-frozen > .tabulator-cell .check-selectable").prop("checked", true);
                }
            }
        });
    });
</script>

<?= $this->Html->script(['tabulator_default']); ?>
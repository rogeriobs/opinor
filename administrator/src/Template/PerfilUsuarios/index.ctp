<h2 class="tit-page">Perfis de usuários</h2>

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
                <div class="col-md-12">
                    <?php echo $this->Form->control('buscar_descricao', ['class' => 'form-control', "label" => "Descrição"]); ?>
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>

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
                <a href="<?= $this->Url->build(["action" => "add"]) ?>" class="btn btn-default get-async-modal" data-modal="#ModalNew"><i class="fa fa-plus"></i> novo</a>
                <a href="javascript:void(0)" class="btn btn-default download-csv"><i class="fa fa-download"></i> CSV</a>
                <a href="javascript:void(0)" class="btn btn-danger btn-only-selected remove-selected" data-urldelete="<?= $this->Url->build(['action' => 'delete']) ?>"><i class="fa fa-trash"></i> excluir itens selecionados</a>
                <a class="btn btn-default btn-only-one edit-selected" href="javascript:void(0)" data-modal="#ModalEdit" data-urledit="<?= $this->Url->build(["action" => "edit"]) ?>"><i class="fa fa-pencil"></i> Editar</a>
                <a href="javascript:void(0)" class="btn btn-warning btn-only-one remove-selected"><i class="fa fa-lock"></i> Editar Permissões</a>
            </div>
            <div class="tabulator-style" id="table-index-unique" data-load="<?= $this->Url->build(["action" => "loadData"]) ?>"></div>
        </div>
    </div>
</div>

<?php require_once 'modais/new.ctp'; ?>
<?php require_once 'modais/edit.ctp'; ?>

<script>

    $(function () {

        tablePU = $("#table-index-unique");

        tablePU.tabulator({
            height: "300px",
            //movableCols: true,
            //persistentLayout: true, //Enable column layout persistence
            //persistentLayoutID: "<?= $this->name ?>", //id string, can only be numbers, letters, hyphens and underscores.
            //groupBy:"role",
            columns: [
                {formatter: fn_checkInput,
                    width: 40,
                    align: "center",
                    frozen: true
                },
                {title: "id", field: "id", width: 100, sorter: "number"},
                {title: "descrição", field: "descricao", width: 200},
                {title: "regra", field: "role", width: 200},
                {title: "criado em", field: "created_formated", width: 200},
                {title: "modificado em", field: "modified_formated", width: 200},
            ],
            dataLoaded: function () {
                hide_loading_inner_tabulator();
            },
            rowClick: function (e, id, data, row) {

                $(row).find(".check-selectable").trigger("click");

            },
            rowContext: function (e, id, data, row) {
                console.log("Row " + id);
            }
        });
    });

</script>

<?= $this->Html->script(['tabulator_default']); ?>
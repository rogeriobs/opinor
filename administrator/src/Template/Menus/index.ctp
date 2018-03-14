<?php echo $this->Html->script(['jquery.dataTables.min']) ?>
<?php echo $this->Html->css(['jquery.dataTables']) ?>

<h2 class="tit-page">Menus</h2>

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
                <div class="col-md-5 padL padR">
                    <?php echo $this->Form->control('buscar_descricao_pai', ['class' => 'form-control', "label" => "Descrição Pai"]); ?>
                </div>
                <div class="col-md-5 padL">
                    <?php echo $this->Form->control('buscar_descricao', ['class' => 'form-control', "label" => "Descrição"]); ?>
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
                <a class="get-async-modal btn btn-default" data-modal="#ModalManagerParent" href="<?= $this->Url->build(["action" => "managerMenuParent"]) ?>"><i class="fa fa-list"></i> menu pai</a>
                <a class="get-async-modal btn btn-default" data-modal="#ModalNew" href="<?= $this->Url->build(["action" => "add"]) ?>"><i class="fa fa-plus"></i> novo</a>
                <a class="btn btn-danger btn-only-selected remove-selected" href="javascript:void(0)" data-urldelete="<?= $this->Url->build(['action' => 'delete']) ?>"><i class="fa fa-trash"></i> excluir itens selecionados</a>
                <a class="btn btn-default btn-only-one edit-selected" href="javascript:void(0)" data-modal="#ModalEdit" data-urledit="<?= $this->Url->build(["action" => "edit"]) ?>"><i class="fa fa-pencil"></i> Editar</a>
            </div>
            <div class="tabulator-style" id="table-index-unique" data-load="<?= $this->Url->build(["action" => "loadData"]) ?>"></div>
        </div>
    </div>
</div>

<?php require_once 'modais/new.ctp'; ?>
<?php require_once 'modais/edit.ctp'; ?>
<?php require_once 'modais/manager_parent.ctp'; ?>

<script>
    $(function () {

        tablePU = $("#table-index-unique");

        tablePU.tabulator({
            height: "300px",
            //movableCols: true,
            //persistentLayout: true, //Enable column layout persistence
            //persistentLayoutID: "<?= $this->name ?>", //id string, can only be numbers, letters, hyphens and underscores.
            groupBy:"admin_menu_descricao",
            columns: [
                {formatter: fn_checkInput,
                    width: 40,
                    align: "center",
                    frozen: true
                },
                {title: "id", field: "id", width: 50, sorter: "number"},
                {title: "descrição menu pai", field: "admin_menu_descricao", width: 200},
                {title: "descrição", field: "descricao", width: 200},
                {title: "ordem", field: "ordem", width: 100},
                {title: "act permissão", field: "action_perm", width: 130},
                {title: "Controller", field: "controller_go", width: 130},
                {title: "Action", field: "action_go", width: 130},
                {title: "Parâmetros", field: "params", width: 130},
                {title: "criado em", field: "created_formated", width: 130},
                {title: "modificado em", field: "modified_formated", width: 130},
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
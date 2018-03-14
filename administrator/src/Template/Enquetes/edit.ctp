<?php echo $this->Html->script(['jquery.dataTables.min']) ?>
<?php echo $this->Html->css(['jquery.dataTables']) ?>

<h2 class="tit-page">Enquetes                     
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Voltar</a>
</h2>

<div class="row">
    <div class="col-md-6 padR col-md-12">

        <div class="row">
            <div class="col-sm-6">
                <div class="poll form">
                    <?= $this->Form->create($poll) ?>
                    <?php

                    require_once 'form/form.in.ctp';

                    ?>
                    <br>
                    <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Salvar</button>
                    <?= $this->Form->end() ?>
                </div>

            </div>
            <div class="col-sm-6">

            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-lg-12">

                <h2 class="subtit-page">Opções da enquete</h2>

                <div class="container-grid">
                    <div class="container-tools-grid">
                        <a class="get-async-modal btn btn-default" data-modal="#ModalNew" href="<?= $this->Url->build(["action" => "addOption", $poll->id]) ?>"><i class="fa fa-plus"></i> novo</a>
                        <div class="input-delete-inline" style="display: none">
                            <form id="frmDeletePollOption" action="<?= $this->Url->build(['action' => 'deleteOption', $poll->id]) ?>" method="post" onsubmit="return confirm_delete_poll_option()">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="text" name="poll_option_id" autocomplete="off">
                            </form>
                        </div>
                        <a class="btn btn-danger btnDeletePollOption" href="javascript:void(0)"><i class="fa fa-trash"></i> excluir opção</a>
                        <a class="btn btn-default btn-only-one edit-selected" href="javascript:void(0)" data-urledit="<?= $this->Url->build(["action" => "edit"]) ?>"><i class="fa fa-pencil"></i> Editar</a>
                    </div>
                    <div class="tabulator-style" id="table-options-poll"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-6 padL">

        <div id="__view_votes_options_poll">


        </div>

    </div>
</div>

<?php require_once 'modais/new.ctp'; ?>
<?php require_once 'modais/edit.ctp'; ?>

<script type="text/javascript">

    function confirm_delete_poll_option() {

        return confirm("Você realmente deseja excluir está opção da enquete?");
    }

    $(function () {

        $(".btnDeletePollOption").click(function () {
            $(".input-delete-inline").fadeToggle(200, function(){
                $(".input-delete-inline").find("input[name=poll_option_id]").focus();
            });
        });

        //Generate print icon
        var editIcon = function (value, data, cell, row, options) { //plain text value
            return "<i class='fa fa-pencil'></i>";
        };

        var votesIcon = function (value, data, cell, row, options) { //plain text value
            return "<i class=\"fa fa-user\" aria-hidden=\"true\"></i>";
        };

        tableOptionsPoll = $("#table-options-poll");

        tableOptionsPoll.tabulator({
            columns: [
                {formatter: editIcon, width: 1, align: "center", frozen: true, onClick: function (e, cell, val, data) {

                        var id = data.id;

                        var modal = $("#ModalEdit");

                        $.ajax({
                            url: '<?= $this->Url->build(['controller' => 'Enquetes', 'action' => 'editOption']) ?>/' + id,
                            cache: false,
                            global: false,
                            beforeSend: function (xhr) {
                                modal.find('.modal-content').html(get_loading_inner_modal());
                            },
                            success: function (data, textStatus, jqXHR) {
                                modal.find('.modal-content').html(data);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                switch (jqXHR.status) {
                                    case 403:
                                        window.location.reload();
                                        break;
                                    case 404:
                                    case 500:
                                        modal.find('.modal-content').html(jqXHR.responseText);
                                        break;
                                }
                            }
                        });

                        modal.modal("show");

                    }
                },
                {formatter: votesIcon, width: 1, align: "center", frozen: true, onClick: function (e, cell, val, data) {

                        $.ajax({
                            url: '<?= $this->Url->build(['action' => 'listOptionVotes']) ?>',
                            data: {'poll_option_id': data.id},
                            cache: false,
                            type: 'POST',
                            beforeSend: function (xhr) {
                                $("#__view_votes_options_poll").html(get_loading_inner_html());
                            },
                            success: function (data, textStatus, jqXHR) {
                                $("#__view_votes_options_poll").html(data);
                            }
                        });

                        $("i.icon-votes").each(function (a, b) {
                            $(b).replaceWith("<i class=\"fa fa-user\" aria-hidden=\"true\"></i>");
                        });

                        cell.html("<i class=\"icon-votes fa fa-check-square-o\" aria-hidden=\"true\"></i>");
                    }
                },
                {title: "id", field: "id", width: 50, sorter: "number"},
                {title: "opção", field: "label_text", width: 200},
                {title: "ordem", field: "ordem", sorter: "number", width: 70},
                {title: "enquete id", field: "poll_id", width: 50, sorter: "number", width: 100},
                {title: "qtd votos", field: "count_votes", width: 50, sorter: "number", width: 100},
                {title: "Criado em", field: "created", width: 200},
                {title: "Modificado em", field: "modified", width: 200}
            ],
        });

        tableOptionsPoll.tabulator("setData", '<?= $poll_options ?>');
    })

</script>

<style type="text/css">
    .input-delete-inline{
        display: inline;
    }
    .input-delete-inline form{
        display: inline;
    }
    .input-delete-inline input{
        padding: 7px 10px;
        width: 60px;
        color: #666;
        border-radius: 5px;
        border: 1px #CCC solid;
        box-shadow: 2px 2px 5px 0 #DDD inset;
    }
</style>
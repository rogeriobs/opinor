<div class="row">
    <div class="col-lg-12">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Digite um tag..." id="txt_new_tag" autocomplete="off">
            <span class="input-group-btn">
                <button id="btn-add-new-tag" class="btn btn-default" type="button">Adicionar</button>
            </span>
        </div><!-- /input-group -->
    </div><!-- /.col-lg-6 -->
</div><!-- /.row -->

<div class="row">
    <div class="col-lg-12" id="__content-list-tags">

    </div>
</div>

<style type="text/css">
    .artigos-tags-list{
        /*        border: 1px #000 solid;*/
        padding:15px 0;
    }
    .artigos-tags-list a{
        border: 1px #234a42 solid;
        margin: 5px 10px 5px 0;
        padding: 10px;
        display: inline-block;
        background-color: #2b6659;
        color: #FFF;

        -webkit-transition: all .3s; /* Safari */
        transition: all .3s;

        border-radius: 3px;
    }
    .artigos-tags-list a:hover{
        background-color: #234a42;
        text-decoration: none;
    }
    .artigos-tags-list a span{

    }
    .artigos-tags-list a i{
        margin: 0 0 0 10px;
    }
</style>

<script type="text/javascript">
    function __loadListTags() {
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Artigos', 'action' => 'listarTags', $newsortopic->id]) ?>',
            beforeSend: function (xhr) {
                $("#__content-list-tags").html(get_loading_inner_html());
            },
            success: function (data, textStatus, jqXHR) {
                $("#__content-list-tags").html(data);
            }

        });
    }

    $(function () {

        __loadListTags();

        $("#btn-add-new-tag").click(function (e) {

            var objTag = $("#txt_new_tag");

            if (objTag.val() == '') {
                objTag.focus();
                return false;
            }

            var tag = objTag.val();
            
            objTag.val('');


            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Artigos', 'action' => 'addTag', $newsortopic->id]) ?>',
                type: 'POST',
                data: {'tag': tag},
                beforeSend: function (xhr) {
                    $("#__content-list-tags").html(get_loading_inner_html());
                },
                success: function (msg, textStatus, jqXHR) {
                    $.toast(msg);
                    __loadListTags();


                    objTag.focus();
                }
            });

        });

        $(document).on("click", ".btn-remove-tag", function (e) {

            var tag = $(this).data("tag");

            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Artigos', 'action' => 'deleteTag', $newsortopic->id]) ?>',
                type: 'POST',
                data: {'tag': tag},
                beforeSend: function (xhr) {
                    $("#__content-list-tags").html(get_loading_inner_html());
                },
                success: function (msg, textStatus, jqXHR) {
                    $.toast(msg);
                    __loadListTags();
                }
            });

        });
    });
</script>
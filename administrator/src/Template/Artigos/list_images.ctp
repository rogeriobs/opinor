<?php //pr($imagens_do_artigo);                                                   ?>

<div class="row">
    <div class="col-md-12">
        <form action="exmaple.php" method="post" enctype="multipart/form-data">
            <input id="file-uploadimage" type="file" name="fileimage">
        </form>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">

        <div class="block-thumbnail-container">

            <?php foreach($imagens_do_artigo as $index => $imagem): ?>

                <?php $srcImage = URL_FRONT . 'img/articles/alta/' . $imagem->filename ?>

                <div class="block-thumbnail">

                    <div class="thumbnail">
                        <img id="editableimage<?= $index ?>" src="<?= $srcImage ?>?<?= time() ?>" alt="<?= $imagem->filename ?>" data-id="<?= $imagem->id ?>" data-filename="<?= $imagem->filename ?>">
                        <p>Tamanho imagem: <?= $imagem->real_width ?>/<?= $imagem->real_height ?></p>
                    </div>

                    <div class="caption">

                        <form id="frmDataImage-<?= $imagem->id ?>">

                            <input name="imagem_id" type="hidden" value="<?= $imagem->id ?>">

                            <div class="form-group">
                                <label for="legendaImagem-<?= $imagem->id ?>">Legenda</label>
                                <input name="legenda" type="text" value="<?= $imagem->legenda ?>" id="legendaImagem-<?= $imagem->id ?>" class="form-control" placeholder="Digite um legenda..." />
                            </div>

                            <div class="form-inline">

                                <div class="form-group">
                                    <label for="larguraUseImagem-<?= $imagem->id ?>">Usar largura</label>
                                    <input name="use_largura" value="<?= $imagem->use_width ?>" type="text" class="form-control" id="larguraUseImagem-<?= $imagem->id ?>" placeholder="Largura...">
                                </div>
                                <div class="form-group">
                                    <label for="alturaUseImagem-<?= $imagem->id ?>">Usar altura</label>
                                    <input name="use_altura" value="<?= $imagem->use_height ?>" type="text" class="form-control" id="alturaUseImagem-<?= $imagem->id ?>" placeholder="Altura...">
                                </div>

                            </div>

                        </form>

                        <div class="btn-group" role="group" aria-label="...">

                            <a title="Salvar os dados alterados acima" href="javascript:void(0);" class="btn btn-success btn-saveDataImage" data-id="<?= $imagem->id ?>" role="button">
                                <i class="fa fa-save"></i>
                            </a>

                            <a title="Editar imagem" role="button" href="javascript:void(0);" class="btn btn-default btn-edit-image" style="display: none;" onclick="return launchEditor('editableimage<?= $index ?>', '<?= $srcImage ?>');">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <a title="Remover imagem" href="javascript:void(0);" class="btn btn-default btn-remove-image" role="button" data-id="<?= $imagem->id ?>">
                                <i class="fa fa-remove"></i>
                            </a>

                            <?php if($imagem->head): ?>

                                <a title="Está é a imagem principal do artigo!" disabled="disabled" href="javascript:void(0);" class="btn btn-warning" role="button">
                                    <i class="fa fa-star"></i>
                                </a>

                            <?php else: ?>

                                <a title="Selecionar está imagem como principal?" href="javascript:void(0);" data-id="<?= $imagem->id ?>" class="btn btn-default btn-setHeadImage" role="button">
                                    <i class="fa fa-square-o"></i>
                                </a>

                            <?php endif; ?>
                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>
</div>

<!-- Instantiate the widget -->
<script type="text/javascript">

    var featherEditor = new Aviary.Feather({
        apiKey: '0137a1cadf0a421aa8bd657fb3b0350b',
        //language: 'pt_BR',
        displayImageSize: true,
        onSave: function (imageID, newURL) {

            var img = document.getElementById(imageID);
            img.src = newURL;

            var artigo_imagem_id = $("#" + imageID).data("id");
            var artigo_imagem_filename = $("#" + imageID).data("filename");

            reqEditImage = $.ajax({
                url: '<?= $this->Url->build(['controller' => 'artigos', 'action' => 'saveImageEdited', $artigo_id]) ?>',
                type: 'POST',
                data: {'artigo_imagem_id': artigo_imagem_id, 'newURL': newURL, 'artigo_imagem_filename': artigo_imagem_filename},
                beforeSend: function (xhr) {
                    showLoading();
                },
                success: function (data, textStatus, jqXHR) {

                }
            });

            reqEditImage.always(function () {
                hideLoading();
            });

            featherEditor.close();
        },
        onLoad: function () {
            $(".btn-edit-image").fadeIn();
        }
    });

    function launchEditor(id, src) {
        featherEditor.launch({
            image: id,
            url: src
        });
        return false;
    }

    $('#file-uploadimage').fileuploader({
        upload: {
            url: '<?= $this->Url->build(['action' => 'uploadImage']) ?>',
            start: true,
            synchron: true,
            limit: 1,
            data: {'artigo_id': '<?= $artigo_id ?>'},
            onSuccess: function (data, item, listEl, parentEl, newInputEl, inputEl, textStatus, jqXHR) {

                item.html.find('.column-actions').html('');


            },
            onError: function (item, listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus, errorThrown) {
                var progressBar = item.html.find('.progress-bar2');

                if (progressBar.length > 0) {
                    progressBar.find('span').html(0 + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                    item.html.find('.progress-bar2').fadeOut(400);
                }

                item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                        ) : null;
            },
            onProgress: function (data, item, listEl, parentEl, newInputEl, inputEl) {
                var progressBar = item.html.find('.progress-bar2');

                if (progressBar.length > 0) {
                    progressBar.show();
                    progressBar.find('span').html(data.percentage + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                }
            },
            // Callback fired after all files were uploaded
            onComplete: function (listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {

                if (typeof (idTimeRefresh) !== 'undefined') {

                    clearTimeout(idTimeRefresh);

                }

                idTimeRefresh = setTimeout(function () {
                    $("#btn-aba-imagens").trigger("click");
                }, 500);

            }
        }
    });

    $(document).off('click', '.btn-remove-image');
    $(document).off('click', '.btn-saveDataImage');
    $(document).off('click', '.btn-setHeadImage');

    $(document).on("click", '.btn-remove-image', function (e) {

        var imagem_id = $(this).data("id");

        if (typeof (reqRI) !== 'undefined') {
            if (reqRI.readyState != 4) {
                return;
            }
        }

        reqRI = $.ajax({
            url: '<?= $this->Url->build(['controller' => 'artigos', 'action' => 'deleteImage']) ?>',
            data: {'imagem_id': imagem_id},
            type: 'DELETE',
            beforeSend: function (xhr) {
                showLoading();
            },
            success: function (msg, textStatus, jqXHR) {

                $.toast(msg);

                $("#btn-aba-imagens").trigger("click");

                hideLoading();
            },
            complete: function (jqXHR, textStatus) {
            }
        });
    });
    
    $(document).on("click", '.btn-setHeadImage', function (e) {

        var imagem_id = $(this).data("id");

        if (typeof (reqRI) !== 'undefined') {
            if (reqRI.readyState != 4) {
                return;
            }
        }

        reqRI = $.ajax({
            url: '<?= $this->Url->build(['controller' => 'artigos', 'action' => 'setHeadImagem']) ?>',
            data: {'imagem_id': imagem_id, 'artigo_id': '<?= $artigo_id ?>'},
            type: 'PUT',
            beforeSend: function (xhr) {
                showLoading();
            },
            success: function (msg, textStatus, jqXHR) {

                $.toast(msg);

                $("#btn-aba-imagens").trigger("click");

                hideLoading();
            },
            complete: function (jqXHR, textStatus) {
            }
        });
    });

    $(document).on("click", '.btn-saveDataImage', function (e) {

        var id = $(this).data("id");

        var form = $("#frmDataImage-" + id);
        var dataForm = form.serialize();

        if (typeof (reqSDI) !== 'undefined') {
            if (reqSDI.readyState != 4) {
                return;
            }
        }

        reqSDI = $.ajax({
            url: '<?= $this->Url->build(['controller' => 'artigos', 'action' => 'saveDataImage']) ?>',
            data: dataForm,
            type: 'PUT',
            beforeSend: function (xhr) {
                showLoading();
            },
            success: function (msg, textStatus, jqXHR) {

                $.toast(msg);

                //$("#btn-aba-imagens").trigger("click");

                hideLoading();
            },
            complete: function (jqXHR, textStatus) {
                
            }
        });

    });

</script>                     

<style type="text/css">
    .block-thumbnail-container{
        column-count: 4;
        -moz-column-gap: 20px;
        -webkit-column-gap: 20px;

    }
    .block-thumbnail{
        width: 100%;
        border: 1px #FFF solid;
        height: auto;
        display: inline-block;
        padding: 1.5rem;
        margin-bottom: 20px;
        border-radius: 5px;

        -webkit-transition: all 300ms;
        transition: all 300ms;

    }
    .block-thumbnail:hover{
        box-shadow: 0 0 30px 0 #CCC;
        background-color: #f0f0f0;
        border-color: #DDD;
    }

    .block-thumbnail .caption{
        /*        border: 1px #000 solid;*/
    }

    .block-thumbnail .thumbnail p{
        margin-top: 5px;
        font-size: 9px;
        color: #777;
    }

    .block-thumbnail .form-inline{
        /*        border: 1px #003d4c solid;*/
        margin-bottom: 20px;
    }

    .block-thumbnail .form-inline .form-group{
        width: 30%;
        margin-right: 10px;
    }

    .block-thumbnail .form-inline .form-group input{
        width:100%;
    }

    .block-thumbnail .form-inline label{
        display: block;
    }
</style>
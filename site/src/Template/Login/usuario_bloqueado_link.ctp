<div id="__rowblusbl" class="row">
    <div class="col-md-12">
        <div class="block-user-blocked">
            <p>Clique no link abaixo, para reenvio do link de confirmaçao para: <b><?= $email ?></b></p>
            <a id="btnReeLink" data-code="<?= $ipsum_id ?>" href="javascript:void(0)">Clique aqui</a>
        </div>

    </div>
</div>

<script type="text/javascript">
    $("#btnReeLink").click(function (e) {

        e.preventDefault();

        showLoading();

        var code = $(this).data("code");

        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Login', 'action' => 'reenviarEmailParaConfirmacao']) ?>',
            data: JSON.stringify({'code': code}),
            contentType: "application/json; charset=utf-8",
            type: 'JSON',
            global:true,
            cache:false,
            beforeSend: function (xhr) {

            },
            success: function (data, textStatus, jqXHR) {
                try {

                    $.toast({
                        text: data.message
                    });

                } catch (err) {
                    console.log(err);
                }

                $("#__rowblusbl").slideUp(200, function () {
                    $(this).remove();
                });
            }
        }).always(function () {
            hideLoading();
        });

    });
</script>
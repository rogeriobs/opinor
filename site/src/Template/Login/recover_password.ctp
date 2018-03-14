<?php

$this->Form->templates([
    'inputContainer' => '{{content}} <span class="separator-border"></span>',
]);

?>

<?= $this->Form->create(null, ["id" => "frmRecoverPassword", "onsubmit" => "return false"]) ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="MyModalLoginLabel">Recuperação de senha</h4>
</div>
<div class="modal-body">

    <?php echo $this->Flash->render(); ?>

    <p>Digite seu e-mail abaixo, para receber um e-mail com o link para geração de uma nova senha.</p>

    <br>

    <div class="form-group">
        <?=

        $this->Form->input('email', [
            'class'        => 'form-control input-brd-ani',
            "autocomplete" => "off",
            "type"         => "email",
            "label"        => "E-mail",
            "placeholder"  => "digite seu e-mail...",
            "required"     => true,
        ]);

        ?>

    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-link btn-block" id="btn-back-login">
        <i class="fa fa-arrow-left"></i> Voltar
    </button>
    <button type="submit" class="btn btn-primary"><i class="fa fa-lock"></i> Recuperar senha</button>
</div>

<?= $this->Form->end() ?>

<script type="text/javascript">
    $(function () {

        $(document).off("click", "#btn-back-login");

        $(document).on("click", "#btn-back-login", function () {

            reqGetCad = $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Login', 'action' => 'in']) ?>',
                type: 'GET',
                data: {},
                cache: false,
                global: false,
                beforeSend: function (xhr) {
                    $('#__content-form-login').html(get_spinner_loading());
                },
                success: function (html, textStatus, jqXHR) {
                    $('#__content-form-login').html(html);
                }
            });
            reqGetCad.always(function () {

            });

            reqGetCad.fail(function (jqXHR, textStatus, errorThrown) {
                alert(textStatus);
                window.location.reload();
            });

        });

        $("#frmRecoverPassword").submit(function (e) {

            e.preventDefault();

            var data = $(this).serialize();

            $.ajax({
                url: '<?= $this->Url->build(["controller" => "Login", "action" => "recoverPassword"]) ?>',
                type: 'POST',
                data: data,
                cache: false,
                global: false,
                beforeSend: function (xhr) {
                    showLoading();
                },
                success: function (data, textStatus, jqXHR) {
                    $("#__content-form-login").html(data);
                }
            }).always(function () {
                hideLoading();
            });
        });

        setTimeout(function () {
            $("#email").focus();
        }, 200);

    });
</script>
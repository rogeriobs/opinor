<?php

$this->Form->templates([
    'inputContainer' => '{{content}} <span class="separator-border"></span>',
]);

?>

<?= $this->Form->create(null, ["id" => "frmLogin", "onsubmit" => "return false"]) ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="MyModalLoginLabel">Autenticação</h4>
</div>
<div class="modal-body">

    <?php if(isset($ipsum_id)): ?>

        <?php include_once 'usuario_bloqueado_link.ctp'; ?>

    <?php endif; ?>

    <?php echo $this->Flash->render(); ?>

    <div class="form-group">
        <?=

        $this->Form->input('email', [
            'class'        => 'form-control input-brd-ani',
            "autocomplete" => "off",
            "type"         => "email",
            "label"        => "E-mail",
            "placeholder"  => "digite seu e-mail",
            "required"     => true,
        ]);

        ?>

    </div>
    <div class="form-group">
        <?=

        $this->Form->input('password', [
            'class'       => 'form-control input-brd-ani',
            "type"        => "password",
            "label"       => "Senha",
            "placeholder" => "digite sua senha",
            "required"    => true,
        ])

        ?>        
    </div>   

    <div class="row">
        <div class="col-12">
            <a id="btn-recover-password" href="javascript:void(0)">Esqueci minha senha</a>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-block" id="MyModalSignupOpen">
        <i class="fa fa-sign-in"></i> Inscrever-se
    </button>
    <button type="submit" class="btn btn-primary"><i class="fa fa-lock"></i> Entrar</button>
</div>

<div class="g-recaptcha" style="visibility: hidden"
     data-sitekey="<?= RECAPTCHA_SITE_KEY ?>"
     data-callback="fn_onSubmit"
     data-size="invisible"
     data-badge="bottomright">
</div>

<?= $this->Form->end() ?>

<script>

    function fn_onSubmit(token) {

        var data = $("#frmLogin").serialize();

        reqLogin = $.ajax({
            url: '<?= $this->Url->build(["controller" => "Login", "action" => "in"]) ?>',
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
        });

        reqLogin.fail(function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        });

        reqLogin.always(function () {
            hideLoading();
        });
    }

    hideLoading();

    $("#frmLogin").submit(function (e) {

        grecaptcha.execute();

    });

    $("#btn-recover-password").click(function (e) {

        e.preventDefault();

        $.ajax({
            url: '<?= $this->Url->build(["controller" => "Login", "action" => "recoverPassword"]) ?>',
            type: 'GET',
            data: {'_csrfToken': '<?= $this->request->params['_csrfToken'] ?>'},
            cache: false,
            global: false,
            beforeSend: function (xhr) {
                $("#__content-form-login").html(get_spinner_loading());
            },
            success: function (data, textStatus, jqXHR) {
                $("#__content-form-login").html(data);
            }
        });

    });

    setTimeout(function () {
        $("#email").focus();
    }, 500);

</script>

<script data-no-min="data-no-min" src='<?= RECAPTCHA_SRC_API ?>' async defer></script>

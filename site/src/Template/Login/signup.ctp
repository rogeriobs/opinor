<?php echo $this->Flash->render(); ?>

<?= $this->Form->create($ipsum, ["id" => "frmSignup", "onsubmit" => "return false"]) ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="MyModalSignupLabel">Seus dados</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <?=

        $this->Form->input('nome', [
            'class'        => 'form-control',
            "type"         => "text",
            "label"        => "Nome",
            "placeholder"  => "digite seu nome",
            "autocomplete" => "off"
        ]);

        ?>
    </div>
    <div class="form-group">
        <?=

        $this->Form->input('email', [
            'class'        => 'form-control',
            "type"         => "email",
            "label"        => "E-mail",
            "placeholder"  => "digite seu e-mail",
            "autocomplete" => "off"
        ]);

        ?>
    </div>
    <div class="form-group">
        <?=

        $this->Form->input('password', [
            'class'        => 'form-control',
            "type"         => "password",
            "label"        => "Senha",
            "placeholder"  => "digite uma senha",
            "autocomplete" => "off"
        ]);

        ?>
    </div>
    <div class="form-group">
        <?=

        $this->Form->input('data_nascimento', [
            'class'        => 'form-control input-date',
            "label"        => "Data de Nascimento",
            "empty"        => "digite sua data de nascimento",
            "autocomplete" => "off",
            'empty'        => [
                'year'  => 'Ano... ',
                'month' => 'Mês...',
                'day'   => 'Dia...'
            ],
            'minYear'      => date('Y') - 100,
            'maxYear'      => date('Y') - 18,
        ]);

        ?>
    </div>
    <div class="form-group">
        <p>
            <input type="checkbox" id="__checkSetLocation">
            <label for="__checkSetLocation">selecionar local automáticamente</label>
        </p>
    </div>
    <div class="form-group">
<?= $this->Form->input('estados', ['class' => 'form-control', "options" => $estados, "label" => "Estado", "empty" => ["" => " -- selecione seu estado -- "]]) ?>
    </div>
    <div class="form-group">
<?= $this->Form->input('cidade_id', ['class' => 'form-control', "options" => [], "label" => "Cidade", "empty" => ["" => " -- selecione sua cidade -- "]]) ?>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</div>
<?= $this->Form->end() ?>

<script>

    var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };
    function success(pos) {
        var crd = pos.coords;
        console.log('Your current position is:');
        console.log(`Latitude : ${crd.latitude}`);
        console.log(`Longitude: ${crd.longitude}`);
        console.log(`More or less ${crd.accuracy} meters.`);
    }
    ;
    function error(err) {
        console.warn(`ERROR(${err.code}): ${err.message}`);
    }
    ;
    navigator.geolocation.getCurrentPosition(success, error, options);

    $("#__checkSetLocation").click(function () {

        var objEstados = $("#estados");
        var objCity = $("#cidade-id");

        if (!$(this).prop("checked")) {

            return;
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                    function (pos) {

                        showLoading();

                        var la = pos.coords.latitude;
                        var lo = pos.coords.longitude;

                        $.ajax({
                            url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng=-23.5527868,-46.6402781&key=AIzaSyAGuIyNZkn5cUlYyUJXSXRvk9UONWdYFd4',
                            cache: true,
                            global: false,
                            success: function (results, textStatus, jqXHR) {

                                if (results.results.length > 0) {

                                    var address = results.results[0].address_components;
                                    var uf = '';
                                    var city = '';

                                    for (i in address) {

                                        if ($.inArray('administrative_area_level_2', address[i].types) !== -1) {
                                            city = address[i].long_name.toLowerCase();
                                        }

                                        if ($.inArray('administrative_area_level_1', address[i].types) !== -1) {
                                            uf = address[i].short_name.toLowerCase();
                                        }

                                    }

                                    objEstados.find("option").each(function (i, element) {

                                        var ufCursor = $(element).attr("sigla");

                                        if (ufCursor) {

                                            if (ufCursor.toLowerCase() == uf) {

                                                $(element).attr("selected", "selected");

                                                objEstados.trigger("change");

                                                reqCid.done(function () {

                                                    objCity.find("option").each(function (i, element) {

                                                        var cidade = $(element).text();

                                                        if (cidade.toLowerCase() == city) {
                                                            $(element).attr("selected", "selected");
                                                        }

                                                    });

                                                });
                                            }
                                        }

                                    });
                                    console.log(uf);
                                    console.log(city);
                                }

                            }
                        }).always(function () {
                            hideLoading();
                        });
                    },
                    function (err) {
                        console.log(err);
                    },
                    {enableHighAccuracy: true, timeout: 10000, maximumAge: 0}
            );
        } else {
            console.log("Geolocation is not supported by this browser.");
        }

    });
    $("#frmSignup").submit(function (e) {

        e.preventDefault();
        var data = $(this).serialize();
        reqSign = $.ajax({
            url: '<?= $this->Url->build(["controller" => "Login", "action" => "signup"]) ?>',
            type: 'POST',
            data: data,
            cache: false,
            global: false,
            beforeSend: function (xhr) {
                showLoading();
            },
            success: function (data, textStatus, jqXHR) {

                $("#__content-form-signup").html(data);
                hideLoading();
            }
        });
        reqSign.fail(function (jqXHR, textStatus, errorThrown) {
            $.toast({
                text: errorThrown,
                heading: textStatus,
                icon: 'error'
            });
        });
        reqSign.always(function () {
            hideLoading();
        });
    });

    $("#estados").change(function (e) {

        var estado_selected = $(this).val();
        if (estado_selected == '')
            return;
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

                    var cidade_id_selected = '<?= @$this->request->data['cidade_id'] ?>';
                    $("#cidade-id").val(cidade_id_selected);
                });
            }
        });
    }).trigger("change");

</script>
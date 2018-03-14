<div class="row" style="margin-top: 40px">
    <div class="col-md-12">

        <h2>Comentários (<span id="total_comments">0</span>)</h2>

        <div class="area-form-comments">
            <form onsubmit="return false">
                <?= $this->Form->hidden("_csrfToken", ["value" => $this->request->Param('_csrfToken')]) ?>
                <textarea name="mensagem" class="form-control" maxlength="400"></textarea>
                <?php if($this->Auth->isLogged()): ?>
                    <input style="margin-top: 10px" type="submit" class="btn btn-primary" value="Enviar comentario">
                <?php else: ?>
                    <p class="text-warning"><i class="fa fa-warning"></i> Voce precisa estar logado para comentar</p>
                <?php endif; ?>
            </form>
        </div>

    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div id="__list-comments">

            <!-- Load commnents -->

        </div>
    </div>
</div>

<script type="text/javascript">

    objCom = $("#__list-comments");

    function __load_comments(order) {

        order = (order) ? order : 'mar';

        objCom.html(get_spinner_loading());

        if (typeof (reqCom) == 'object') {
            if (reqCom.readyState != 4) {
                return;
            }
        }

        reqCom = $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Comments', 'action' => "load", encrypt($artigo_id, CRYPT_KEY_FOR_ID)]) ?>?order=' + order,
            data: {},
            type: 'GET',
            cache: false,
            global: false,
            beforeSend: function (xhr) {

            },
            success: function (comentarios, textStatus, jqXHR) {
                objCom.html(comentarios);
            }
        });

    }

    $(function () {

        __load_comments();

        var form = $(".area-form-comments form");

        form.submit(function (e) {

            e.preventDefault();

            var btnSubmit = $(form).find("input[type='submit']");

            var msg = $(form).find("[name='mensagem']");

            if ($.trim(msg.val()) == '') {

                msg.val("");
                msg.focus();

                return false;
            }

            btnSubmit.prop("disabled", true);
            btnSubmit.val("Enviando...");

            var data = form.serializeArray();

            data.push({'name': 'local', 'value': window.location.host});
            data.push({'name': '__', 'value': '<?= encrypt($artigo_id, CRYPT_KEY_FOR_ID) ?>'});

            reqSend = $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Comments', 'action' => "save"]) ?>',
                global: false,
                cache: false,
                async: true,
                data: data,
                type: 'POST',
                beforeSend: function (xhr) {

                },
                success: function (data, textStatus, jqXHR) {

                    try {

                        if (data == '') {
                            return;
                        }

                        $.toast({
                            text: data.message,
                            icon: data.message_icon,
                        });

                        __load_comments();

                    } catch (err) {

                        alert(err.message);
                    }
                }
            });

            reqSend.always(function () {
                msg.val("");
                btnSubmit.prop("disabled", false);
                btnSubmit.val("Enviar comentário");
            });

            reqSend.fail(function (jqXHR) {
                console.log();
            });
        });

        $(document).on("click", "#btn-load-more-comments", function () {

            showLoading();

            var next = $(this).data('next');
            var order = $(this).data('order');

            reqLoadMore = $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Comments', 'action' => "load", encrypt($artigo_id, CRYPT_KEY_FOR_ID)]) ?>/' + next + '/?order=' + order,
                data: {},
                type: 'GET',
                cache: false,
                global: false,
                beforeSend: function (xhr) {

                },
                success: function (comentarios, textStatus, jqXHR) {
                    objCom.find(".block-comments-list").append(comentarios);
                    url: '<?= $this->Url->build(['controller' => 'Comments', 'action' => "load", encrypt($artigo_id, CRYPT_KEY_FOR_ID)]) ?>/' + next + '/?order=' + order,
                            hideLoading();
                }
            });

        });

        $(document).on("click", ".order-comments", function (e) {

            var order = $(this).data("order");

            __load_comments(order);

        });

        $(document).on("click", ".rating-block a", function () {

            $this = $(this);

            var parent = $(this).parents(".rating-comments");

            if (parent.find('a[class^="ratecommentcomputed"]').length === 0) {

                var rate = $(this).data("rate");
                var commentset = parent.data("commentset");

                if (typeof (reqRateSet) == 'object') {
                    if (reqRateSet.readyState != 4) {
                        return;
                    }
                }

                reqRateSet = $.ajax({
                    url: '<?= $this->Url->build(['controller' => 'Comments', 'action' => "setRatingInComment", encrypt($artigo_id, CRYPT_KEY_FOR_ID)]) ?>',
                    data: {'rate': rate, 'commentset': commentset},
                    type: 'POST',
                    cache: false,
                    global: false,
                    beforeSend: function (xhr) {

                    },
                    success: function (data, textStatus, jqXHR) {

                        console.log(data);

                        var total = $this.find("span").text();

                        $this.find("span").html(parseInt(total) + 1);

                        $this.addClass("ratecommentcomputed" + rate);
                    }
                });

            }
        });
    });
</script>
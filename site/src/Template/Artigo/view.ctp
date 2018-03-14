<?php $this->assign('title', "Enquetes.info - {$artigo->titulo}"); ?>

<?= $this->Html->meta('title', "Enquetes.info - " . $seo['title'], ['block' => true]); ?>
<?= $this->Html->meta('keywords', $seo['keywords'], ['block' => true]); ?>
<?= $this->Html->meta('description', $seo['description'], ['block' => true]); ?>

<div class="topo-inner">
    <div class="logo-site">
        <a href="../">Enquetes.info</a>
    </div>
    <div class="info-topo">

        <?php if($this->Auth->isLogged()): ?>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="dropdownMenu1"> 
                        <?= $this->Auth->getUserData("nome") ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                        <li><a href="<?= $this->Url->build(['controller' => 'Usuario', 'action' => 'MeusDados']) ?>">Meus dados</a></li>
                        <li><a href="<?= $this->Url->build(["controller" => "Usuario", "action" => "alterarSenha"]) ?>">Alterar Senha</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Login', 'action' => 'logout']) ?>">Sair</a></li>
                    </ul>
                </li>
            </ul>

        <?php else: ?>
            <a href="javascript:void(0)" class="not-connected MyModalLoginOpen">Você não está conectado no site</a>
        <?php endif; ?>

    </div>
</div>
<div class="content-view">

    <h1 class="title-article"><?= $artigo->titulo ?></h1>

    <div class="bar-status-article">
        <ul>
            <li>
                Data de publicaçao da fonte: <?= $artigo->data_de_publicacao ?>
            </li>
            <li>
                |
                Data de criação: <?= $artigo->data_de_publicacao ?>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-6">

            <?php if(count($artigo->newsortopic_imagens)): ?>

                <div class="container-imagem-view">
                    <ul class="pgw-imagens-slide">
                        <?php foreach($artigo->newsortopic_imagens as $imagem): ?>
                            <li>
                                <?= $this->Html->image("articles/alta/$imagem->filename", ["alt" => $imagem->legenda]) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>    

            <?php endif; ?>

            <?= strip_tags($artigo->texto_full, '<a><p><em><i><b><strong><sup><strike><hr>') ?>

            <?php if($artigo->fonte && $artigo->fonte_link): ?>

                <p>
                    <span>Fonte:</span>
                    <a href="<?= $artigo->fonte_link ?>"><?= $artigo->fonte ?></a>
                </p>

            <?php endif; ?>
        </div>
        <div class="col-md-6">

            <h2>Enquete</h2>

            <p class="titulo-poll"><?= h($artigo->poll->titulo) ?></p>

            <form id="frmVotePoll" onsubmit="return false">

                <?= $this->Form->hidden("_csrfToken", ["value" => $this->request->Param('_csrfToken')]) ?>
                <?= $this->Form->hidden("_poid", ["value" => encrypt($artigo->poll_id, CRYPT_KEY_FOR_ID)]) ?>

                <ul class="poll-xyz">

                    <?php foreach($artigo->pollOptions as $poll_option): ?>

                        <?php $checkedOpt = ($opcao_da_enquete_votada == $poll_option['id']); ?>

                        <li id="liopt-<?= encrypt($poll_option['id'], CRYPT_KEY_FOR_ID) ?>" class="<?= ($checkedOpt) ? "rd-option-selected" : "" ?>">
                            <input value="<?= encrypt($poll_option['id'], CRYPT_KEY_FOR_ID) ?>" <?= ($checkedOpt) ? "checked" : "" ?> class="rd-polloptionclass" type="radio" id="optionpoll-<?= md5($poll_option['id']) ?>" name="optionVote">
                            <label for="optionpoll-<?= md5($poll_option['id']) ?>">
                                <span class="_optionpoll"><?= $poll_option['label_text'] ?></span>
                                <span class="_votescomp"><?= $this->article->get_option_poll_round($poll_option['porcentagem']) ?>% - <?= $this->article->get_option_poll_votes($poll_option['votos']) ?></span>
                                <div class="bar-poll-options" style="width:<?= $this->article->get_option_poll_round($poll_option['porcentagem']) ?>%">
                                </div>
                            </label>
                            <div class="check"></div>
                        </li>

                    <?php endforeach; ?>
                </ul>

                <div class="total-votes-poll">
                    <b>Total de votos:</b>
                    <span><?= $artigo->pollOptions[0]['total_votos'] ?></span>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="poll-btns">
                            <?php if($this->Auth->isLogged()): ?>

                                <?php if(!$opcao_da_enquete_votada): ?>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check-square-o"></i> Votar
                                    </button>
                                <?php else: ?>
                                    <p>Você já votou nesta enquete</p>    
                                <?php endif; ?>

                            <?php else: ?>
                                <button type="button" class="btn btn-primary MyModalLoginOpen">
                                    <i class="fa fa-sign-in"></i> Entrar para votar
                                </button>
                            <?php endif; ?>

                            <input type="button" value="Visualizar detalhes" class="btn btn-secondary" id="btn-modalPollDetails" data-target="#ModalDetailsPoll" data-pollid="<?= encrypt($artigo->poll_id, CRYPT_KEY_FOR_ID) ?>">


                        </div>
                    </div>
                </div>

            </form>

            <?= $this->element("comentarios", ['artigo_id' => $artigo->id]) ?>

        </div>

    </div><!--row-->



</div>

<?php echo $this->element("popup-signup") ?>
<?php echo $this->element("popup-login") ?>

<!-- Modal -->
<div class="modal fade" id="ModalDetailsPoll" tabindex="-1" role="dialog" aria-labelledby="ModalDetailsPollLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ModalDetailsPollLabel">Detalhes do total de votos da enquete</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<?php if($opcao_da_enquete_votada): ?>

    <script>
        $(function () {
            pollAlreadyVoted();
        });
    </script>

<?php endif; ?>

<script>

    function pollAlreadyVoted() {

        var obj = $(".poll-xyz li");

        obj.find('[name=optionVote]').prop('disabled', true);

        obj.find('.check').fadeOut(200, function () {
            obj.find('label').css('padding-left', '20px');
        });
    }

    function refreshPoll() {

        if (typeof ($refresh) == 'object') {

            if ($refresh.readyState != 4) {

                return false;

            }

        }

        $refresh = $.ajax({
            url: '<?= $this->Url->build(['controller' => '_Artigo', 'action' => 'refreshPoll', encrypt($artigo->poll_id, CRYPT_KEY_FOR_ID)]) ?>',
            global: true,
            cache: false,
            success: function (data, textStatus, jqXHR) {

                if (typeof (timeRefresh) == 'number') {
                    clearTimeout(timeRefresh);
                }

                if ($.trim(data) == '') {

                    return false;

                }

                try {

                    if (data.options.length) {

                        $(data.options).each(function (i, o) {
                            var item = $("#liopt-" + o.__);

                            item.find("label ._votescomp").html(o.votos_perc + "% - " + o.votos + ((o.votos > 1) ? ' votos' : " voto"));
                            item.find("label .bar-poll-options").animate({width: o.votos_perc + "%"}, 1000);

                        });

                        $(".total-votes-poll span").html(data.total_de_votos);
                    }

                    timeRefresh = setTimeout("refreshPoll()", 60000);

                } catch (err) {
                    console.log(err);
                }


            }
        });
    }

    $(document).ready(function () {

        refreshPoll();

        $('.pgw-imagens-slide').pgwSlideshow({
            autoSlide: false,
            displayList: false,
            intervalDuration: 4000
        });

        $(document).on("click", ".rd-polloptionclass", function (e) {

            $("ul.poll-xyz li").removeClass("rd-option-selected");

            $(this).parent("li").addClass("rd-option-selected");

        });

        $("#frmVotePoll").submit(function (e) {

            e.preventDefault();

            var $this = $(this);

            var voteSelected = $this.find("[name='optionVote']:checked");

            if (voteSelected.length == 0) {

                $.toast({
                    text: "Selecione um opção abaixo",
                    icon: 'info',
                    stack: 1
                });

                $this.find(".check").stop(true, true).fadeOut(100).fadeIn(200).fadeOut(100).fadeIn(200).fadeOut(100).fadeIn(200);

                return false;

            }


            showLoading();

            $req = $.ajax({
                url: '<?= $this->Url->build(['controller' => '_artigo', 'action' => 'vote']) ?>',
                data: $this.serialize(),
                type: 'POST',
                cache: false,
                global: false,
                beforeSend: function (xhr) {

                },
                success: function (data, textStatus, jqXHR) {

                    try {

                        pollAlreadyVoted();

                        $.toast({
                            text: data.message,
                            icon: data.message_icon,
                        });

                        refreshPoll();

                        $this.find("button[type='submit']").fadeOut(500, function () {
                            $(this).remove();
                        });

                    } catch (err) {

                        alert(err.message);
                    }

                }
            });

            $req.always(function (e) {
                hideLoading();
            });

            $req.fail(function (jqXHR) {

                var message = jqXHR.status + " - " + jqXHR.statusText;

                $.toast({
                    text: message,
                    icon: 'error',
                });

            });

        });

        $("#btn-modalPollDetails").click(function () {

            var button = $(this);
            var pollid = button.data('pollid');

            var modal = $('#ModalDetailsPoll');
            var __csrf = '<?= $this->request->Param('_csrfToken') ?>';

            modal.find('.modal-body').html(get_spinner_loading());

            reqPollDetails = $.ajax({
                url: '<?= $this->Url->build(['controller' => '_Artigo', 'action' => 'getPollDetails']) ?>',
                type: 'POST',
                data: {'_csrfToken': __csrf, 'pollid': pollid},
                beforeSend: function (xhr) {

                },
                success: function (table, textStatus, jqXHR) {

                    modal.find('.modal-body').html(table);

                }
            });

            modal.modal('show');

        });

        $('.dropdown-toggle').dropdown()

    });
</script>
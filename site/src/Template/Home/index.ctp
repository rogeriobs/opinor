<?php $this->assign('title', "Enquetes.info - O site com as melhores enquetes do Brasil"); ?>

<?= $this->Html->meta('title', "Enquetes.info - O site com as melhores enquetes do Brasil", ['block' => true]); ?>
<?= $this->Html->meta('keywords', "enquetes, pesquisas, noticias, pesquisa, estatísticas, brasil, enquete, enquetes online, comentários, opnião, opniões", ['block' => true]); ?>
<?= $this->Html->meta('description', "O site com a melhores enquetes do Brasil, enquetes das principais notícias, filmes, Séries e TV, lugares, aplicativos, pessoas e etc,,,", ['block' => true]); ?>

<div class="layout-grid">

    <div class="grid-sizer"></div>

    <?php include_once 'articles.list.ctp'; ?>

</div>

<?php if(count($articles) >= \App\Controller\HomeController::limit_por_page): ?> 

    <div class="wrapper-btn-pagination">
        <button id="btn-load-more" class="btn btn-pagination" data-offset="<?= $offset ?>">
            Carregar mais...
        </button>
    </div>

<?php endif; ?>

<?php echo $this->element("popup-signup") ?>
<?php echo $this->element("popup-login") ?>

<script type="text/javascript">
    $(function () {

        $grid = $('.layout-grid').masonry({
            // options
            itemSelector: '.item-nestorpic',
            columnWidth: '.grid-sizer',
            percentPosition: true,
            resize: true,
            transitionDuration: '0.2s',
            //gutter: 30
        });

        // layout Masonry after each image loads
        $grid.imagesLoaded().progress(function () {
            $grid.masonry('layout');
        });

        $(document).on("click", "a.get-link", function () {
            $("#loading").fadeIn();
        });

        $("#loading").fadeOut();

        $("#input-search").focus();

        $('#input-search').autocomplete({
            minChars: 4,
            autoSelectFirst: false,
            triggerSelectOnValidInput: false,
            forceFixPosition: false,
            lookup: function (query, done) {

                var result = {
                    "suggestions": []
                };

                if (typeof (idTimeAutoComplete) == 'number') {
                    clearTimeout(idTimeAutoComplete);
                }

                idTimeAutoComplete = setTimeout(function () {

                    reqAutoComplete = $.ajax({
                        url: '<?= $this->Url->build(['controller' => 'Home', 'action' => 'suggestions']) ?>/' + query,
                        cache: false,
                        global: false,
                        beforeSend: function (xhr) {

                        },
                        success: function (data, textStatus, jqXHR) {

                            result.suggestions = data;

                            done(result);
                        }
                    });

                }, 150);


            },
            onSelect: function (suggestion) {

                $("#frmSearchHome").submit();

            }
        });

    });
</script>
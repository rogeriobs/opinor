<?php foreach($articles as $article): ?>

    <article class="item-nestorpic <?= $article['article_format'] ?>">
        <a class="get-link" href="<?= $this->Url->build(['controller' => 'artigo', 'action' => "/", $article['article_alias']]) ?>">

            <div class="container-imagem">

                <?= $this->article->picture($article); ?>

            </div>

            <section>
                <div class="sec-intro">
                    <h1 class="title-article">
                        <?= $article['article_titulo'] ?>
                    </h1>
                    <p>
                        <?= $article['article_resumo'] ?>

                        <?php if($article['fonte']): ?>
                            <br><span class="art-src"><?= $article['fonte'] ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="sec-poll">
                    <p class="title-poll">Enquete</p>
                    <h2 class="question-poll"><?= $article['enquete_titulo'] ?></h2>
                    <?php if(count($article['enquente_options'])): ?>
                        <ul class="ul-poll">
                            <?php foreach($article['enquente_options'] as $poll_option): ?>

                                <?= $this->article->get_option_poll($poll_option); ?>

                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </section>
            <footer>
                <ul>
                    <li>
                        <i class="fa fa-user"></i> <?= $this->article->get_count_comentarios($article['total_de_comentarios']); ?>
                    </li>
                </ul>
            </footer>
        </a>
    </article>

<?php endforeach; ?>

<script>
    $(function () {
        $(document).off('click', "#btn-load-more");

        $(document).on('click', "#btn-load-more", function () {

            showLoading();

            reqPag = $.ajax({
                url: '<?= $this->Url->build(['controller' => '_home', 'action' => '_index', $offset]) ?>',
                cache: false,
                beforeSend: function (xhr) {

                },
                success: function (articles, textStatus, jqXHR) {

                    var $content = $(articles);

                    $grid.imagesLoaded(function () {
                        
                        // init Masonry
                        $grid.masonry({
                            // options...
                        });

                        setTimeout(function () {

                            $grid.masonry('reloadItems');

                            // Masonry has been initialized, okay to call methods
                            $grid.append($content).masonry('appended', $content);

                        }, 200);

                    });

                }
            });

            reqPag.fail(function () {

            });

            reqPag.always(function (jqXHR, textStatus) {
                hideLoading();
            });

        });
    });
</script>
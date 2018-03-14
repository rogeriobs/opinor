<?php foreach($comentarios as $comentario): ?>

    <div class="comments-user">
        <div class="header-comment">
            <span class="heacom-user"><?= $comentario['nome'] ?></span>
            <span class="headcom-divisor">•</span>
            <span class="headcom-date"><?= strftime("%d de %B de %Y - %H:%M", strtotime($comentario['data_e_hora'])) ?>hs</span>
        </div>                          
        <div class="text-comments">
            <?= h($comentario['comentario']) ?>
        </div>
        <div class="rating-comments" data-commentset="<?=encrypt($comentario['id'], CRYPT_KEY_FOR_ID)?>">
            <div class="rating-block">
                <a class="<?=$this->article->setMarkRating_in_comentario($markratings, $comentario['id'], 1) ?>" data-rate="1" href="javascript:void(0)" title="Muito ótimo">
                    <i class="fa fa-arrow-up"></i>
                    <span><?= $comentario['positivo'] ?></span>
                </a>
            </div>
            <div class="rating-block">
                <a class="<?=$this->article->setMarkRating_in_comentario($markratings, $comentario['id'], 3) ?>" data-rate="3" href="javascript:void(0)" title="Não concordo e nem discordo">
                    <i class="fa fa-arrows-h"></i>
                    <span><?= $comentario['meio'] ?></span>
                </a>
            </div>
            <div class="rating-block">
                <a class="<?=$this->article->setMarkRating_in_comentario($markratings, $comentario['id'], 2) ?>" data-rate="2" href="javascript:void(0)" title="Péssimo comentário">
                    <i class="fa fa-arrow-down"></i>
                    <span><?= $comentario['negativo'] ?></span>
                </a>
            </div>
        </div>
    </div><!--[comments-user]-->

<?php endforeach; ?>

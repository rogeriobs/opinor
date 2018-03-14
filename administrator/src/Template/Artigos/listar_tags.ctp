<div class="artigos-tags-list">
    <?php if(count($tags)): ?>
        <?php foreach($tags as $tag): ?>
            <a href="javascript:void(0)"><span><?=$tag->tag?></span><i class="fa fa-remove btn-remove-tag" data-tag="<?=$tag->tag?>"></i></a>
        <?php endforeach; ?>
    <?php else: ?>
            <i>Nenhuma tag cadastrada...</i>
    <?php endif; ?>
</div>

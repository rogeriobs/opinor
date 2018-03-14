<?php if(count($articles)): ?>

    <?php include_once 'articles.list.ctp'; ?>

    <script type="text/javascript">
        $("#btn-load-more").attr('data-offset', '<?= $offset ?>');
    </script>

<?php else: ?>

    <script type="text/javascript">
        $("#btn-load-more").replaceWith("<p>Todos os artigos já foram carregados...</p>");
    </script>

<?php endif; ?>

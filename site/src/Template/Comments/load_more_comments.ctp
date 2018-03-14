<?php require_once 'comments.list.ctp'; ?>


<?php if(!$show_btn_load_more): ?>
    <script type="text/javascript">
        $("#btn-load-more-comments").replaceWith("<p class=\"text-primary\">Todos os comentários já foram carregados...</p>");
    </script>
<?php endif; ?>

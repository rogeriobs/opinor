<?php if(count($comentarios)): ?>
    
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-12">
            <div class="btn-group" role="group" aria-label="...">
                <button <?=($this->request->query("order") == "mar") ? "disabled" : "" ?> data-order="mar" type="button" class="btn btn-default order-comments">
                   <?=($this->request->query("order") == "mar") ? "<i class=\"fa fa-arrow-right\"></i>" : "" ?>  
                   Mais recentes
                </button>
                <button <?=($this->request->query("order") == "map") ? "disabled" : "" ?> data-order="map" type="button" class="btn btn-default order-comments">
                    <?=($this->request->query("order") == "map") ? "<i class=\"fa fa-arrow-right\"></i>" : "" ?>
                    Mais populares
                </button>
                <button <?=($this->request->query("order") == "mao") ? "disabled" : "" ?> data-order="mao" type="button" class="btn btn-default order-comments">
                    <?=($this->request->query("order") == "mao") ? "<i class=\"fa fa-arrow-right\"></i>" : "" ?>
                    Mais positivados
                </button>
                <button <?=($this->request->query("order") == "man") ? "disabled" : "" ?> data-order="man" type="button" class="btn btn-default order-comments">
                    <?=($this->request->query("order") == "man") ? "<i class=\"fa fa-arrow-right\"></i>" : "" ?>
                    Mais negativados
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="block-comments-list">

                <?php require_once 'comments.list.ctp'; ?>

            </div>

            <?php if($show_btn_load_more): ?>

                <a id="btn-load-more-comments" data-next="<?=$next?>" data-order="<?=$this->request->query("order")?>" class="btn btn-block" href="javascript:void(0)">Mostrar Mais</a>
                
            <?php else: ?>
                
                <p class="text-primary">Todos os comentários já foram carregados...</p>
                
            <?php endif; ?>
        </div>
    </div>

<?php else: ?>    

    <p> -- Artigo ainda não possui nenhum comentário...</p>

<?php endif; ?>

<script type="text/javascript">

    $("#total_comments").html('<?= $total_de_comentarios ?>');

</script>
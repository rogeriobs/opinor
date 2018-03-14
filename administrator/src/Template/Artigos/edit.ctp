<?php echo $this->Html->css(['trumbowyg', 'jquery.dataTables', 'jquery.fileuploader']) ?>
<?php echo $this->Html->script(['trumbowyg', 'jquery.dataTables.min', 'jquery.fileuploader.min']) ?>

<h2 class="tit-page">Artigos                     
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Voltar</a>
</h2>

<?= $this->Form->create($newsortopic) ?>

<div class="row">
    <div class="col-lg-9 padR">     

        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->control('titulo', ['class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->control('alias', ['class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->control('texto_resumo', ['type' => 'textarea', 'class' => 'form-control']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php echo $this->Form->control('texto_full'); ?>
            </div>
        </div>

        <h2 class="subtit-page">
            Gerenciar conteúdo artigo 
        </h2>

        <div class="row">
            <div class="col-md-12">
                <ul id="nav-complCad" class="nav nav-pills">
                    <li role="presentation"><a id="btn-aba-imagens" data-url="<?= $this->Url->build(['controller' => 'artigos', 'action' => 'listImages', $newsortopic->id]) ?>" href="javascript:void(0)">Imagens</a></li>
                    <li role="presentation"><a id="btn-aba-poll" data-url="<?= $this->Url->build(['controller' => 'artigos', 'action' => 'listPoll', $newsortopic->id, $newsortopic->poll_id]) ?>" href="javascript:void(0)">Enquete</a></li>
                    <li role="presentation"><a id="btn-aba-comments" data-url="<?= $this->Url->build(['controller' => 'artigos', 'action' => 'listComments', $newsortopic->id]) ?>" href="javascript:void(0)">Comentários</a></li>
                </ul>

                <div id="__content-article-sec">
                    
                </div>
            </div>
        </div>

    </div> <!-- coluna left -->

    <div class="col-lg-3 padL">

        <div class="side-nav-edit">
            <?php include 'sidebars/side_botao_salvar.ctp'; ?>
        </div>

        <br>

        <div class="side-nav-edit">
            <?php include 'sidebars/side_edit.ctp'; ?>
        </div>

        <h3 class="subtit-page">
            Enquete
        </h3>   

        <div class="side-nav-edit">
            <?php include 'sidebars/side_enquete.ctp'; ?>
        </div>

        <h3 class="subtit-page">
            SEO
        </h3>        
        <div class="side-nav-edit">
            <?php include 'sidebars/side_seo.ctp'; ?>
        </div>

        <h3 class="subtit-page">
            Tags
        </h3>   

        <div class="side-nav-edit">
            <?php include 'sidebars/side_tags.ctp'; ?>
        </div>
        
        <h3 class="subtit-page">
            Fonte
        </h3>   

        <div class="side-nav-edit">
            <?php include 'sidebars/side_fonte.ctp'; ?>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(function () {
        $("#texto-full").trumbowyg();

        $("#nav-complCad li a").click(function (e) {

            $("#nav-complCad li").each(function (a, li) {
                $(li).removeClass("active");
            });

            var objContent = $("#__content-article-sec");
            var url = $(this).data("url");

            $.ajax({
                url: url,
                beforeSend: function (xhr) {

                    objContent.html(get_loading_inner_html());
                },
                success: function (data, textStatus, jqXHR) {
                    objContent.html(data);

                    if (typeof (featherEditor) === 'object') {
                        $(".btn-edit-image").fadeIn();
                    }

                }
            });

        });
    });
</script>


<?= $this->Form->end() ?>

<style type="text/css">
    #__content-article-sec{
        background-color: #fff;
        padding: 10px;
        margin: 20px 0 0 0;
        border-radius: 3px;
        border: 1px #CCC solid;
    }
    .side-nav-edit{
        border: 1px #CCC solid;
        padding: 10px;
        background-color: #f0f0f0;
    }

</style>

<script type="text/javascript" src="https://cdn-creativesdk.adobe.io/v1/csdk.js"></script>

<script type="text/javascript">
    /* 1) Initialize the AdobeCreativeSDK object */
    AdobeCreativeSDK.init({
        /* 2) Add your Client ID (API Key) */
        clientID: '0137a1cadf0a421aa8bd657fb3b0350b',
        onError: function (error) {
            /* 3) Handle any global or config errors */
            if (error.type === AdobeCreativeSDK.ErrorTypes.AUTHENTICATION) {
                /* 
                 Note: this error will occur when you try 
                 to launch a component without checking if 
                 the user has authorized your app. 
                 
                 From here, you can trigger 
                 AdobeCreativeSDK.loginWithRedirect().
                 */
                console.log('You must be logged in to use the Creative SDK');
            } else if (error.type === AdobeCreativeSDK.ErrorTypes.GLOBAL_CONFIGURATION) {
                console.log('Please check your configuration');
            } else if (error.type === AdobeCreativeSDK.ErrorTypes.SERVER_ERROR) {
                console.log('Oops, something went wrong');
            }
        }
    });

</script>

<!-- Load widget code -->
<script type="text/javascript" src="https://dme0ih8comzn4.cloudfront.net/imaging/v3/editor.js"></script>

<?php echo str_repeat("<br>", 5); ?>
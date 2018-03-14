<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
    <head>
        <meta charset="UTF-8">
        <title>Confirmação de email</title>
        <style type="text/css">
            .body{
                background-color: #f0f0f0 !important;
                padding: 5%;
                font-family: sans-serif;
                color: #666;
                font-size: 14px;
            }
            .faixa-verde{
                width: 90%;
                margin: 0 auto;
                height: 10px;
                background-color:#7eaa40;
                display: block;
                color: #7eaa40;
                line-height: 10px;
            }
            .content{
                display: block;
                border: 1px #FFF solid;
                background-color: #FFF;
                width: 92%;
                padding: 4%;
            }
            a.btn-link{
                border: 1px #014c8c solid;
                padding:10px 20px;
                margin-bottom: 20px;
                color: #FFF;
                background-color: #014c8c;
                border-radius: 4px;
                font-size: 13px;
                text-decoration: none;
                display: inline-block;
            }
            footer{
                font-size: 11px;
            }
        </style>
    </head>
    <body class="body">
        <div class="faixa-verde">
            .
        </div>
        <div class="content">
            <?= $this->fetch('content') ?>
        </div>
        <div class="faixa-verde">
            .
        </div>
    </body>
</html>



<?php

define("CRYPT_KEY_FOR_ID", "DsQw22@231(7*3&&1231");

if(PHP_SAPI === 'cli'){
    $_SERVER['HTTP_HOST'] = "localhost";
}

switch(true):
    case preg_match("/local.opinor.br|localhost/i", $_SERVER['HTTP_HOST']):

        define("AMBIENTE", "LOCAL");

        define("RECAPTCHA_SRC_API", "https://www.google.com/recaptcha/api.js?hl=pt-BR");
        define("RECAPTCHA_SITE_KEY", "6Lf_4yoUAAAAAP20w8zXXXXXXXXXXXXXXXXXXXXXXXXXXx");
        define("RECAPTCHA_SECRET_KEY", "6Lf_4yoUAAAAAJYzibAT4XXXXXXXXXXXXXXXXXXXXXXXXXXX");

        return include_once('apps/AppLocalhost.php');
        break;
    case preg_match("/dominio.homol.in/i", $_SERVER['HTTP_HOST']):

        define("AMBIENTE", "HOMOL");

        return include_once('apps/AppHomologacao.php');
        break;
    case preg_match("/enquetes.info/i", $_SERVER['HTTP_HOST']):

        define("AMBIENTE", "PRODUCAO");
        
        define("RECAPTCHA_SRC_API", "https://www.google.com/recaptcha/api.js?hl=pt-BR");
        define("RECAPTCHA_SITE_KEY", "6Lf_4yoUAAAAAP20w8zXXXXXXXXXXXXXXXXXXXXXXXXXXx");
        define("RECAPTCHA_SECRET_KEY", "6Lf_4yoUAAAAAJYzibAT4XXXXXXXXXXXXXXXXXXXXXXXXXXX");

        define("SCRIPT_GOOOGLE_ANALYTICS", '');

        return include_once('apps/AppProducao.php');
        break;
endswitch;

<?php

define("CRYPT_KEY_FOR_ID", "ADMIN@KEY999000");

if(PHP_SAPI === 'cli'){
    $_SERVER['HTTP_HOST'] = "local.opinor.br";
}

switch(true):
    case preg_match("/local.opinor.br/i", $_SERVER['HTTP_HOST']):

        define("AMBIENTE", "LOCAL");
        define("URL_FRONT", "https://local.opinor.br/opinor/site/");
        define("DIR_FRONT", "/var/www/opinor/site/");

        return include_once('apps/AppLocalhost.php');
        break;
    case preg_match("/dominio.homol.in/i", $_SERVER['HTTP_HOST']):

        define("AMBIENTE", "HOMOL");

        return include_once('apps/AppHomologacao.php');
        break;
    case preg_match("/enquetes.info/i", $_SERVER['HTTP_HOST']):

        define("AMBIENTE", "PRODUCAO");
        define("URL_FRONT", "https://enquetes.info/");
        define("DIR_FRONT", "/var/www/vhosts/front/");
        
        return include_once('apps/AppProducao.php');
        break;
endswitch;

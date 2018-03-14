<?php

function encrypt($string, $secret_key = 'default')
{
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_iv      = 'BRASIL';

    //hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;

}

function decrypt($string, $secret_key = 'default')
{
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_iv      = 'BRASIL';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

    return $output;

}

function getIP()
{
    if(getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;

}

/**
 * Adiciona duas aspas simples a cada aspas simples encontrada.
 * 
 * @param String $string
 * 
 * @return String
 */
function escape_quote_pgsql($string)
{

    return preg_replace("/'{1}/", "''", $string);

}

function remove_newlines($string)
{
    return trim(preg_replace('/\s\s+/', ' ', $string));

}

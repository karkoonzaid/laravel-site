<?php

function getLocale()
{
    return App::getLocale();
}

function getClientIP()
{
    if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

/**
 * Float Div Right or Left as per locale
 */
function floatDiv()
{
    return App::getLocale() == 'en' ? 'pull-right' : 'pull-left';
}
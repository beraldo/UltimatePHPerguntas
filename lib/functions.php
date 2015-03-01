<?php

function isDevEnv()
{
    return ENV == 'dev';
}

function viewsPath()
{
    return APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
}

function logsPath()
{
    return APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR;
}


function getBaseURL()
{
    return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['SERVER_PORT'] == 80 ? '' : ':' . $_SERVER['SERVER_PORT']
    );
}

function getCurrentURL()
{
    return getBaseURL() . $_SERVER['REQUEST_URI'];
}

/*
function make_url( $page, array $extraParams = array() )
{
    return getBaseURL() . '?page=' . $page . ( count( $extraParams ) > 0 ? '&' . http_build_query( $extraParams ) : '' );
}
*/


function redirect( $url )
{
    header( 'Location: ' . $url );
    exit;
}
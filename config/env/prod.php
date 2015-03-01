<?php

/*
 * Configurações para ambiente de produção
 */

if ( function_exists( 'ini_set' ) )
{
    // desabilita exibição de erros para o usuário
    ini_set( 'display_errors', false );

    // habilita a escrita dos erros em arquivo de log
    ini_set( 'log_errors', true );

    // define o nome do arquivo de log (nesse caso, errors.log)
    ini_set( 'error_log', APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'php_errors.log' );
}


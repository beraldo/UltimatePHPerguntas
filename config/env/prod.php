<?php
/**
 * Ultimate PHPerguntas
 * 
 * Este script faz parte do Projeto Prático do curso Ultimate PHP.
 * O Ultimate PHP é um curso voltado para iniciantes e intermediários em PHP.
 * Conheça o curso Ultimate PHP acessando http://www.ultimatephp.com.br
 *
 * O projeto completo está disponível no Github: https://github.com/beraldo/UltimatePHPerguntas
 *
 * @author: Roberto Beraldo Chaiben
 * @package Ultimate PHPerguntas
 * @link http://www.ultimatephp.com.br
 */


/*
 * Configurações para ambiente de produção
 */

if ( function_exists( 'ini_set' ) )
{
    // desabilita exibição de erros para o usuário
    ini_set( 'display_errors', false );

    // habilita a escrita dos erros em arquivo de log
    ini_set( 'log_errors', true );

    // define o nome do arquivo de log (nesse caso, app.log)
    ini_set( 'error_log', APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'app.log' );
}


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
 * Configurações do PHP
 */

/*
 * Lista com os hostnames (nome do computador) dos ambientes de
 * desenvolvimento. Sempre que o sistema for executado em uma máquina
 * de desenvolvimento, as devidas configurações do PHP (como exibição de
 * erros e logs) serão usadas. Caso contrário, serão usadas configurações de
 * ambiente de produção
 *
 * Esse recurso foi inspirado nas configurações de ambiente do framework Laravel. 
 * Veja mais aqui: http://laravel.com/docs/4.2/configuration#environment-configuration
 */
$devHostnames = [
    'piemonte.local',
    'bordeaux.local',
];


// Fuso-Horário (Timzone)
// Lista de timezones suportador pelo PHP: http://php.net/manual/pt_BR/timezones.php
date_default_timezone_set( 'America/Sao_Paulo' );


// Habilite todos os níveis de exibição de erros.
// essa configuração é geral, tanto para produção quanto
// para desenvolvimento, pois desejamos exibir todos os níveis
// de erro, seja na tela ou no arquivo de log.
// O que muda conforme o ambiente é a diretiva display_errors
error_reporting( E_ALL | E_STRICT );

// pega o hostname da máquina em que a aplicação está rodando
$hostname = gethostname();

if ( in_array( $hostname, $devHostnames ) )
{
    // ambiente de desenvolvimento
    
    define( "ENV", 'dev' );
    require_once APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'dev.php';
}
else
{
    // ambiente de produção

    define( 'ENV', 'prod' );
    require_once APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'prod.php';
}

<?php

/*
 * Configurações do PHP
 */

/*
 * Lista com os hostnames (nome do computador) dos ambientes de
 * desenvolvimento. Sempre que o sistema for executado em uma máquina
 * de desenvolvimento, as devidas configurações do PHP (como exibição de
 * erros e logs) serão usadas. Caso contrário, serão usadas configurações de
 * ambiente de produção
 */
$devHostnames = [
    'aphrodite.local',
    'venus.local',
];


// Fuso-Horário (Timzone)
// Lista de timezones suportador pelo PHP: http://php.net/manual/pt_BR/timezones.php
date_default_timezone_set( 'America/Sao_Paulo' );

// Habilite todos os níveis de exibição de erros
error_reporting( E_ALL | E_STRICT );

$hostname = gethostname();
if ( in_array( $hostname, $devHostnames ) )
{
    define( "ENV", 'dev' );
    require_once APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'dev.php';
}
else
{
    define( 'END', 'prod' );
    require_once APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . 'prod.php';
}

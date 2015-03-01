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
 * Script de inicialização (Bootstrapping)
 *
 * Leia mais sobre Bootstrapping e Arquivos de Inicialização no link abaixo
 * http://rberaldo.com.br/bootstrapping-php-arquivo-inicializacao/
 */

// mantém a sessão sempre ativa
session_start();

// define o diretório base da aplicação
define( 'APP_ROOT_PATH', dirname( __FILE__ ) );

// busca todos os arquivos de configuração no diretório "config"
$configFiles = glob( APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '*.php' );

// inclui todos os arquivos de configuração
foreach ( $configFiles as $configFile )
{
    require_once $configFile;
}


// adiciona o diretório 'lib' no include_path, para que o
// autoload encontre as classes
set_include_path( get_include_path() . PATH_SEPARATOR . APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'lib' );
spl_autoload_extensions( ".php" );
spl_autoload_register();

// inclui o arquivo de funções
// como o diretório "lib" está no include path, não é necessário usar lib/functions.php no require_once
require_once 'functions.php';


// inclui o autoloader do Composer
require_once 'vendor/autoload.php';

// verifica o cookie do usuário logado, caso exista
\Auth::checkUser();
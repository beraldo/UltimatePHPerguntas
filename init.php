<?php

session_start();

define( 'APP_ROOT_PATH', dirname( __FILE__ ) );

$configFiles = glob( APP_ROOT_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . '*.php' );


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


\Auth::checkUser();
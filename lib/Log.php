<?php

class Log
{
    const LEVEL_INFO = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_ERROR = 3;


    protected static $logFileName = 'app.log';


    public static function info( $msg )
    {
        self::writeLog( $msg, self::LEVEL_INFO );
    }

    public static function warning( $msg )
    {
        self::writeLog( $msg, self::LEVEL_WARNING );
    }

    public static function error( $msg )
    {
        self::writeLog( $msg, self::LEVEL_ERROR );
    }


    protected static function writeLog( $msg, $level )
    {
        // caminho ao arquivo de logs
        $file = self::getLogsFileFullPath();

        // data atual
        $date = date( 'Y-m-d H:is' );
        
        // mensagem de log completa
        // padrão: [data_hora] nível: mensagem quebra_de_linha
        $fullMsg = sprintf( '[%s] %s: %s%s', $date, self::getLevelAsString( $level ), $msg, PHP_EOL );
     
     
        file_put_contents( $file, $fullMsg, FILE_APPEND );
    }

    public static function getLevelAsString( $level )
    {
        $str = '';
        switch ( $level )
        {
            case self::LEVEL_INFO:
                $str = 'INFO';
                break;

            case self::LEVEL_WARNING:
                $str = 'WARNING';
                break;

            case self::LEVEL_ERROR:
                $str = 'ERROR';
                break;
        }

        return $str;
    }


    public static function getLogsFileFullPath()
    {
        return logsPath() . self::$logFileName;
    }
}
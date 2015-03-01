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



/**
 * Classe para escrita de logs
 */
class Log
{
    const LEVEL_INFO = 1;
    const LEVEL_WARNING = 2;
    const LEVEL_ERROR = 3;

    /**
     * Nome do arquivo de logs da aplicação
     * @var string
     */
    protected static $logFileName = 'app.log';


    /**
     * Escreve um log do nível de informação
     * @param  string $msg Mensagem de log
     */
    public static function info( $msg )
    {
        self::writeLog( $msg, self::LEVEL_INFO );
    }


    /**
     * Escreve um log do nível de aviso (warning)
     * @param  string $msg Mensagem de log
     */
    public static function warning( $msg )
    {
        self::writeLog( $msg, self::LEVEL_WARNING );
    }


    /**
     * Escreve um log do nível de erro
     * @param  string $msg Mensagem de log
     */
    public static function error( $msg )
    {
        self::writeLog( $msg, self::LEVEL_ERROR );
    }


    /**
     * Escreve uma mensagem de log no arquivo de log
     * @param  string $msg   Mensagem do log
     * @param  int $level Nível do log
     */
    protected static function writeLog( $msg, $level )
    {
        // caminho ao arquivo de logs
        $file = self::getLogsFileFullPath();

        // data atual
        $date = date( 'Y-m-d H:is' );
        
        // mensagem de log completa
        // padrão: [data_hora] nível: mensagem quebra_de_linha
        $fullMsg = sprintf( '[%s] %s: %s%s', $date, self::getLevelAsString( $level ), $msg, PHP_EOL );
     
        // escreve no arquivo, fazendo "append", para não sobrescrever o conteúdo antigo
        file_put_contents( $file, $fullMsg, FILE_APPEND );
    }


    /**
     * Retorna a string relativa a um nível de log
     * @param  int $level Nível do log
     * @return string   Representação textual do nível de log
     */
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


    /**
     * Retorna o caminho completo ao arquivo de log
     * @return string Caminho completo ao arquivo de log
     */
    public static function getLogsFileFullPath()
    {
        return logsPath() . self::$logFileName;
    }
}
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
 * Class para proteção contra XSS
 */
class XSS
{   
    /**
     * Filtra uma string para evitar XSS
     * @param  string $data String a ser filtrada
     * @return string  String filtrada
     */
    public static function filter( $data )
    {
        return htmlspecialchars( $data );
    }
}
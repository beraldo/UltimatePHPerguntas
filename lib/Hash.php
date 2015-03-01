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
 * Classe para geração de hashes
 */
class Hash
{

    /**
     * Algoritmo para geração do hash de senhas
     * Veja mais em http://php.net/manual/pt_BR/function.hash-algos.php
     *
     * @link http://php.net/manual/pt_BR/function.hash-algos.php Função hash_algos, com a lista de algoritmos de hash
     * @var string
     */
    protected static $passwordHashAlg = 'sha512';




    /**
     * Gera o hash de uma string para ser usada na senha do usuário.
     *
     * @link http://php.net/manual/pt_BR/function.hash.php Função hash do PHP
     * @param  string $str String original
     * @return string    Hash gerado da string junto ao salt
     */
    public static function password( $str )
    {
        // concatena o salt à string original
        $str .= PASSWORD_SALT;

        return hash( static::$passwordHashAlg, $str );
    }
}
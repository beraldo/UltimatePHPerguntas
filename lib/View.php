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
 * Classe para gerar uma view da aplicação.
 * É responsável por carregar o template geral e adicionar a view que deve ser exibida
 */
class View
{
    /**
     * Exibe uma view.
     * Função inspirada na usada pelo Laravel 4. Veja: http://laravel.com/docs/4.2/responses#views
     *
     * @link http://laravel.com/docs/4.2/responses#views
     * @param  string $viewName   Nome da view, que é o nome do arquivo em lib/views, sem o ".php"
     * @param  array  $customVars (opcional) Array com variáveis que serão usadas na view
     */
    public static function make( $viewName, array $customVars = array() )
    {
        // cria as variáveis do array $customVars
        extract( $customVars );

        // inclui o template, que vai processar a view na variável $viewName
        require_once viewsPath() . 'template.php';
    }
}

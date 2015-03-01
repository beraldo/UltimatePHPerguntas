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


namespace Controllers;

/**
 * Controller para páginas gerais da aplicação
 */
class PagesController
{
    /**
     * Exibe a página inicial
     * @return [type] [description]
     */
    public static function home()
    {
        // busca o usuário logado (ou null se não estiver logado)
        $user = \Auth::user();

        // busca lista de perguntas
        $questions = \Models\Question::all();


        \View::make( 'home', compact( 'user', 'questions' ) );
    }


}

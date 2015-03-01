<?php

namespace Controllers;

class PagesController
{
    /**
     * Exibe a página inicial
     * @return [type] [description]
     */
    public static function home()
    {
        $user = \Auth::user();

        $questions = \Models\Question::all();

        \View::make( 'home', compact( 'user', 'questions' ) );
    }


}

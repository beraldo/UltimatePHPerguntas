<?php

namespace Controllers;

class QuestionsController
{
    public static function create()
    {
        \Auth::denyNotLoggedInUsers();

        \View::make( 'question.create' );
    }


    public static function show( $id )
    {
        $question = new \Models\Question;
        $question->find( $id );

        $answers = $question->getAnswers();

        $user = \Auth::user();

        \View::make( 'question.show', compact( 'question', 'user', 'answers' ) );
    }

    public static function store()
    {
        \Auth::denyNotLoggedInUsers();

        \CSRF::Check();

        $title = isset( $_POST['title'] ) ? $_POST['title'] : null;
        $description = isset( $_POST['description'] ) ? $_POST['description'] : null;

        $errors = [];

        if ( empty( $title ) )
        {
            $errors[] = 'Informe o título da pergunta';
        }

        if ( empty( $description ) )
        {
            $errors[] = 'Informe a descrição da pergunta';
        }

        if ( count( $errors ) > 0 )
        {
            return \View::make( 'question.create', compact( 'errors' ) );
        }

        $user = \Auth::user();
        $user_id = $user->getId();
        $now = date( 'Y-m-d H:i:s' );

        $DB = new \DB;
        $sql = "INSERT INTO questions(user_id, title, description, created_at, updated_at) VALUES(:user_id, :title, :description, :created_at, :updated_at)";
        $stmt = $DB->prepare( $sql );
        $stmt->bindParam( ':title', $title );
        $stmt->bindParam( ':description', $description );
        $stmt->bindParam( ':user_id', $user_id, \PDO::PARAM_INT );
        $stmt->bindParam( ':created_at', $now );
        $stmt->bindParam( ':updated_at', $now );

        if ( $stmt->execute() )
        {
            $id = $DB->lastInsertId();

            redirect( getBaseURL() . '/pergunta/' . $id );
        }
        else
        {
            echo "Erro ao criar pergunta";

            \Log::error( "Erro ao criar pergunta: " .print_r( $stmt->errorInfo(), true ) );
        }
    }


    /**
     * Remove uma pergunta
     * @param  int $id ID da pergunta
     */
    public static function delete( $id )
    {
        // impede acesso por não administradores
        \Auth::denyNonAdminUser();

        if ( \Models\Question::delete( (int) $id ) )
        {
            redirect( getBaseURL() );
        }
        else
        {
            echo "Erro ao remover pergunta";
        }
    }
}

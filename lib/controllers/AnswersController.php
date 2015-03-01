<?php

namespace Controllers;

class AnswersController
{
    public static function create( $question_id )
    {
        \Auth::denyNotLoggedInUsers();

        $question = new \Models\Question;
        $question->find( $question_id );

        \View::make( 'answer.create', compact( 'question' ) );
    }


    public static function store()
    {
        \Auth::denyNotLoggedInUsers();

        \CSRF::Check();

        $questionID = isset( $_POST['question_id'] ) ? (int) $_POST['question_id'] : null;
        $description = isset( $_POST['description'] ) ? $_POST['description'] : null;

        $errors = [];

        if ( empty( $questionID ) )
        {
            $errors[] = 'ID da pergunta inválido';
        }

        if ( empty( $description ) )
        {
            $errors[] = 'Informe a resposta';
        }

        if ( count( $errors ) > 0 )
        {
            return \View::make( 'answer.create', compact( 'errors' ) );
        }

        $user = \Auth::user();
        $user_id = $user->getId();
        $now = date( 'Y-m-d H:i:s' );

        $DB = new \DB;
        $sql = "INSERT INTO answers(user_id, question_id, description, created_at, updated_at) VALUES(:user_id, :question_id, :description, :created_at, :updated_at)";
        $stmt = $DB->prepare( $sql );
        $stmt->bindParam( ':question_id', $questionID, \PDO::PARAM_INT );
        $stmt->bindParam( ':description', $description );
        $stmt->bindParam( ':user_id', $user_id, \PDO::PARAM_INT );
        $stmt->bindParam( ':created_at', $now );
        $stmt->bindParam( ':updated_at', $now );

        if ( $stmt->execute() )
        {
            redirect( getBaseURL() . '/pergunta/' . $questionID );
        }
        else
        {
            echo "Erro ao criar resposta";

            \Log::error( "Erro ao criar resposta: " .print_r( $stmt->errorInfo(), true ) );
        }
    }



    /**
     * Remove uma resposta
     * @param  int $id ID da resposta
     */
    public static function delete( $id, $question_id )
    {
        // impede acesso por não administradores
        \Auth::denyNonAdminUser();

        if ( \Models\Answer::delete( (int) $id ) )
        {
            redirect( getBaseURL() . '/pergunta/'. $question_id );
        }
        else
        {
            echo "Erro ao remover resposta";
        }
    }
}

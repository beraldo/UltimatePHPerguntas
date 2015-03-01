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
 * Controller de respostas
 */
class AnswersController
{
    /**
     * Formulário de resposta a ma pergunta
     * @param  int $question_id Pergunta à qual será dada uma resposta
     */
    public static function create( $question_id )
    {
        // impede acesso a usuário não logado
        \Auth::denyNotLoggedInUsers();

        // busca os dados da pergunta
        $question = new \Models\Question;
        $question->find( $question_id );


        \View::make( 'answer.create', compact( 'question' ) );
    }


    /**
     * Salva a resposta
     */
    public static function store()
    {
        // impede acesso a usuário não logado
        \Auth::denyNotLoggedInUsers();

        // impede ataque por CSRF
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
            // se ocorrer erro, exibe-os e encerra a execução deste método, usando o return
            return \View::make( 'answer.create', compact( 'errors' ) );
        }

        // busca o usuário logado
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
            // redireciona para a pergunta, já com a resposta criada
            redirect( getBaseURL() . '/pergunta/' . $questionID );
        }
        else
        {
            // exibe erro e gera um log com os detalhes do problema
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

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
 * Controller de perguntas
 */
class QuestionsController
{
    /**
     * Formulário de criação de pergunta
     */
    public static function create()
    {
        // impede acesso a usuário não logado
        \Auth::denyNotLoggedInUsers();

        \View::make( 'question.create' );
    }


    /**
     * Exibe uma pergunta, juntamente com suas respostas
     * @param  int $id ID da pergunta
     */
    public static function show( $id )
    {
        // busca os dados da pergunta
        $question = new \Models\Question;
        $question->find( $id );

        // busca as respostas
        $answers = $question->getAnswers();

        // busca o usuário logado (ou null se não estiver logado)
        $user = \Auth::user();

        \View::make( 'question.show', compact( 'question', 'user', 'answers' ) );
    }



    /**
     * Processa o formulário de criação de pergunta
     */
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
            // se ocorrer erro, exibe-os e encerra o método usando return
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
            // busca o ID gerado na inserção
            $id = $DB->lastInsertId();

            // redireciona para a páginca com o pergunta criada
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

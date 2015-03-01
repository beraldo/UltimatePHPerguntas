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


namespace Models;

/**
 * Model que representa uma pergunta
 */
class Question extends BaseModel
{

    protected $tableName = 'questions';
    
    protected $id;
    protected $user_id;
    public $user; // \Models\User object
    protected $title;
    protected $description;
    protected $created_at;
    protected $updated_at;



    /**
     * Sobrescreve o método find da BaseModel, para definir a propriedade "user", com o objeto \Models\User correspondente
     */
    public function find( $value, $field = 'id', $fieldType = \PDO::PARAM_STR )
    {
        parent::find( $value, $field, $fieldType );

        $this->user = new \Models\User;
        $this->user->find( $this->user_id );
    }

    /**
     * Busca todas as perguntas
     * @return array Array com todas as perguntas
     */
    public static function all()
    {
        $DB = new \DB;
        $sql = "SELECT u.nickname, q.id, q.title, q.description, q.created_at FROM users u INNER JOIN questions q ON q.user_id = u.id ORDER BY q.created_at DESC";
        $stmt = $DB->prepare( $sql );
        $stmt->execute();

        /*
         * Neste trecho, $rows será um array de objetos. Porém são objetos genéricos, instâncias da classe stdClass
         * Por isso teremos de usar o operador flecha (->) em vez dos getters e setters, que só poderiam ser usados se fossem objetos da classe \Models\Question
         *
         * Veja mais em: http://php.net/manual/pt_BR/reserved.classes.php
         */
        $rows = $stmt->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $rows as & $row )
        {
            $row->user = new \Models\User;
            $row->user->setNickname( $row->nickname ); 
        }

        return $rows;
    }


    /**
     * Busca as respostas para a pergunta deste objeto
     * @return array Array com as respostas
     */
    public function getAnswers()
    {
        $DB = new \DB;
        $sql = "SELECT u.nickname, a.id, a.description, a.created_at FROM users u INNER JOIN answers a ON a.user_id = u.id WHERE a.question_id = :question_id ORDER BY a.created_at DESC";
        $stmt = $DB->prepare( $sql );
        $stmt->bindParam( ':question_id', $this->id, \PDO::PARAM_INT );
        $stmt->execute();

        /*
         * Neste trecho, $rows será um array de objetos. Porém são objetos genéricos, instâncias da classe stdClass
         * Por isso teremos de usar o operador flecha (->) em vez dos getters e setters, que só poderiam ser usados se fossem objetos da classe \Models\Answer
         *
         * Veja mais em: http://php.net/manual/pt_BR/reserved.classes.php
         */
        $rows = $stmt->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $rows as & $row )
        {
            $row->user = new \Models\User;
            $row->user->setNickname( $row->nickname ); 

            $row->question = $this;
        }

        return $rows;
    }


    /**
     * Remove uma pergunta do banco de dados.
     * Como existe uma chave estrangeira entre a pergunta e suas respostas, ao apagar uma pergunta, todas as respostas são automaticamente apagadas também
     * 
     * @param  int $id ID da pergunta
     * @return bool   TRUE em caso de sucesso, FALSE em caso de falha
     */
    public static function delete( $id )
    {
        $DB = new \DB;
        $sql = "DELETE FROM questions WHERE id = :question_id";
        $stmt = $DB->prepare( $sql );
        $stmt->bindParam( ':question_id', $id, \PDO::PARAM_INT );
        
        return $stmt->execute();
    }



    /**
     * Gets the value of id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param int $id the id
     */
    protected function setId( $id )
    {
        $this->id = $id;
    }

    /**
     * Gets the value of user_id.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Sets the value of user_id.
     *
     * @param int $user_id the user id
     */
    protected function setUserId( $user_id )
    {
        $this->user_id = $user_id;
    }


    /**
     * Gets the value of title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param string $title the title
     */
    protected function setTitle( $title )
    {
        $this->title = $title;
    }

    /**
     * Gets the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param string $description the description
     */
    protected function setDescription($description)
    {
        $this->description = $description;
    }

    
}

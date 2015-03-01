<?php

namespace Models;

class Answer extends BaseModel
{

    protected $tableName = 'answers';
    
    protected $id;
    protected $user_id;
    public $user; // \Models\User object
    protected $question_id;
    public $question; // \Models\Question object
    protected $description;
    // protected $created_at;
    // protected $updated_at;



    /**
     * Sobrescreve o método find da BaseModel, para definir as propriedades "user" e "question", com os objetos \Models\User e \Models\Question correspondentes
     */
    public function find( $value, $field = 'id', $fieldType = \PDO::PARAM_STR )
    {
        parent::find( $value, $field, $fieldType );

        $this->user = new \Models\User;
        $this->user->find( $this->user_id );

        $this->question = new \Models\Question;
        $this->question->find( $this->question_id );
    }


    /**
     * Remove uma resposta
     * @param  int $id ID da resposta
     * @return bool   TRUE em caso de sucesso, FALSE em falhas
     */
    public static function delete( $id )
    {
        $DB = new \DB;
        $sql = "DELETE FROM answers WHERE id = :id";
        $stmt = $DB->prepare( $sql );
        $stmt->bindParam( ':id', $id, \PDO::PARAM_INT );
        
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



    /**
     * Gets the value of question_id.
     *
     * @return int
     */
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * Sets the value of question_id.
     *
     * @param int $question_id the question id
     */
    protected function setQuestionId($question_id)
    {
        $this->question_id = $question_id;
    }


}

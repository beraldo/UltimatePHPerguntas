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
 * Model base para todas as outras models da aplicação
 */
class BaseModel
{
    // Nome da tabela relativa à model
    // Esse valor deve ser sobrescrito pelas classes filhas
    protected $tableName = null;


    /**
     * Busca um registro na tabela relativa à model
     * @param  mixed $value   Valor a ser usado no filtro da busca
     * @param  string $field  Nome do campo a ser usado na filtragem (padrão: campo id)
     * @param  int $fieldType Tipo do campo usado no filtro (padrão PDO::PARAM_STR)
     * @return mixed    O próprio objeto, com suas propriedades preenchidas com os valores do banco de daods
     */
    public function find( $value, $field = 'id', $fieldType = \PDO::PARAM_STR )
    {
        if ( ! isset( $this->tableName ) || empty( $this->tableName ) )
        {
            return null;
        }

        $DB = new \DB;
        $sql = sprintf( "SELECT * FROM %s WHERE %s = :value", $this->tableName, $field );
        $stmt = $DB->prepare( $sql );
        $stmt->bindParam( ':value', $value, $fieldType );
        $stmt->execute();

        $rows = $stmt->fetchAll( \PDO::FETCH_ASSOC );

        if ( count( $rows ) <= 0 )
        {
            return null;
        }

        $model = $rows[0];

        foreach ( $model as $modelField => $modelValue )
        {
            $this->{$modelField} = $modelValue;
        }

        return $this;
    }



    /**
     * Gets the value of created_at.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        if ( ! $this->created_at instanceof \DateTime )
        {
            $this->created_at = new \DateTime( $this->created_at );
        }

        return $this->created_at;
    }

    /**
     * Sets the value of created_at.
     *
     * @param DateTime $created_at the created at
     */
    protected function setCreatedAt( \DateTime $created_at )
    {
        $this->created_at = $created_at;
    }


    /**
     * Gets the value of updated_at.
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        if ( ! $this->updated_at instanceof \DateTime )
        {
            $this->updated_at = new \DateTime( $this->updated_at );
        }
        
        return $this->updated_at;
    }

    /**
     * Sets the value of updated_at.
     *
     * @param DateTime $updated_at the updated at
     */
    protected function setUpdatedAt( \DateTime $updated_at )
    {
        $this->updated_at = $updated_at;
    }


}

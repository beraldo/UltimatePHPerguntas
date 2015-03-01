<?php

namespace Models;

class BaseModel
{
    // Nome da tabela relativa à model
    // Esse valor deve ser sobrescrito pelas classes filhas
    protected $tableName = null;

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

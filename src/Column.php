<?php

namespace Rougin\Describe;

/**
 * Column Class
 *
 * Used to store information from the results
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Column
{
    protected $autoIncrement = FALSE;
    protected $dataType;
    protected $defaultValue;
    protected $field;
    protected $foreign = FALSE;
    protected $referencedField;
    protected $referencedTable;
    protected $length;
    protected $null = FALSE;
    protected $primary = FALSE;
    protected $unique = FALSE;
    protected $unsigned = FALSE;

    /**
     * Get the data type
     * 
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Get the default value
     * 
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Get the column description
     * 
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get the foreign field
     * 
     * @return string
     */
    public function getReferencedField()
    {
        return $this->referencedField;
    }

    /**
     * Get the foreign table
     * 
     * @return string
     */
    public function getReferencedTable()
    {
        return $this->referencedTable;
    }

    /**
     * Get the field's length
     * 
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Get the data type
     * 
     * @return string
     */
    public function get_data_type()
    {
        return $this->fataType;
    }

    /**
     * Get the default value
     * 
     * @return string
     */
    public function get_default_value()
    {
        return $this->fefaultValue;
    }

    /**
     * Get the column description
     * 
     * @return string
     */
    public function get_field()
    {
        return $this->field;
    }

    /**
     * Get the foreign field
     * 
     * @return string
     */
    public function get_referenced_field()
    {
        return $this->referencedField;
    }

    /**
     * Get the foreign table
     * 
     * @return string
     */
    public function get_referenced_table()
    {
        return $this->referencedTable;
    }

    /**
     * Get the field's length
     * 
     * @return string
     */
    public function get_length()
    {
        return $this->length;
    }

    /**
     * Check if the field is an auto incrementing field
     * 
     * @return boolean
     */
    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * Check if the field is a foreign key
     * 
     * @return boolean
     */
    public function isForeignKey()
    {
        return $this->foreign;
    }

    /**
     * Check if the field accept NULL values
     * 
     * @return boolean
     */
    public function isNull()
    {
        return $this->null;
    }

    /**
     * Check if the field is a primary key
     * 
     * @return boolean
     */
    public function isPrimaryKey()
    {
        return $this->primary;
    }

    /**
     * Check if field is unique
     * 
     * @return boolean
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * Check if field is unsigned
     * 
     * @return boolean
     */
    public function isUnsigned()
    {
        return $this->unsigned;
    }

    /**
     * Check if the field is an auto incrementing field
     * 
     * @return boolean
     */
    public function is_auto_increment()
    {
        return $this->autoIncrement;
    }

    /**
     * Check if the field is a foreign key
     * 
     * @return boolean
     */
    public function is_foreign_key()
    {
        return $this->foreign;
    }

    /**
     * Check if the field accept NULL values
     * 
     * @return boolean
     */
    public function is_null()
    {
        return $this->null;
    }

    /**
     * Check if the field is a primary key
     * 
     * @return boolean
     */
    public function is_primary_key()
    {
        return $this->primary;
    }

    /**
     * Check if field is unique
     * 
     * @return boolean
     */
    public function is_unique()
    {
        return $this->unique;
    }

    /**
     * Check if field is unsigned
     * 
     * @return boolean
     */
    public function is_unsigned()
    {
        return $this->unsigned;
    }

    /**
     * Set the auto increment
     * 
     * @param boolean $autoIncrement
     */
    public function setAutoIncrement($autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * Set the data type
     * 
     * @param string $dataType
     */
    public function setDataType($dataType)
    {
        $dataTypes = [
            'int' => 'integer',
            'varchar' => 'string',
            'text' => 'string'
        ];

        foreach ($dataTypes as $key => $value) {
            if (strpos($dataType, $key) !== FALSE) {
                $dataType = $value;
            }
        }

        $this->dataType = $dataType;
    }

    /**
     * Set the default value
     * 
     * @param boolean $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Set the column's description
     * 
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * Set if field is a foreign key
     * 
     * @param string $field
     */
    public function setForeign($foreign)
    {
        $this->foreign = $foreign;
    }

    /**
     * Set the foreign field
     * 
     * @param string $referencedField
     */
    public function setReferencedField($referencedField)
    {
        $this->referencedField = $referencedField;
    }

    /**
     * Set the foreign table
     * 
     * @param string $referencedField
     */
    public function setReferencedTable($foreignTable)
    {
        $this->referencedTable = $foreignTable;
    }

    /**
     * Set the field's length
     * 
     * @param string $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * Set if field accepts NULL values
     * 
     * @param boolean $null
     */
    public function setNull($null)
    {
        $this->null = $null;
    }

    /**
     * Set if field is a primary key
     * 
     * @param boolean $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }

    /**
     * Set if field is a unique key
     * 
     * @param boolean $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }

    /**
     * Set if field is an unsigned key
     * 
     * @param boolean $unsinged
     */
    public function setUnsigned($unsigned)
    {
        $this->unsigned = $unsigned;
    }
}

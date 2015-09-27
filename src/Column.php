<?php

namespace Rougin\Describe;

/**
 * Column Class
 *
 * Stores a column information from the results given.
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
     * Gets the data type.
     * 
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Gets the default value.
     * 
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Gets the column description.
     * 
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Gets the foreign field.
     * 
     * @return string
     */
    public function getReferencedField()
    {
        return $this->referencedField;
    }

    /**
     * Gets the foreign table.
     * 
     * @return string
     */
    public function getReferencedTable()
    {
        return $this->referencedTable;
    }

    /**
     * Gets the field's length.
     * 
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Gets the data type.
     * 
     * @return string
     */
    public function get_data_type()
    {
        return $this->fataType;
    }

    /**
     * Gets the default value.
     * 
     * @return string
     */
    public function get_default_value()
    {
        return $this->fefaultValue;
    }

    /**
     * Gets the column description.
     * 
     * @return string
     */
    public function get_field()
    {
        return $this->field;
    }

    /**
     * Gets the foreign field.
     * 
     * @return string
     */
    public function get_referenced_field()
    {
        return $this->referencedField;
    }

    /**
     * Gets the foreign table.
     * 
     * @return string
     */
    public function get_referenced_table()
    {
        return $this->referencedTable;
    }

    /**
     * Gets the field's length.
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
     * Sets the auto increment.
     * 
     * @param boolean $autoIncrement
     */
    public function setAutoIncrement($autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * Sets the data type.
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
     * Sets the default value.
     * 
     * @param boolean $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * Sets the column's description.
     * 
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * Sets if field is a foreign key.
     * 
     * @param string $field
     */
    public function setForeign($foreign)
    {
        $this->foreign = $foreign;
    }

    /**
     * Sets the foreign field.
     * 
     * @param string $referencedField
     */
    public function setReferencedField($referencedField)
    {
        $this->referencedField = $referencedField;
    }

    /**
     * Sets the foreign table.
     * 
     * @param string $referencedField
     */
    public function setReferencedTable($foreignTable)
    {
        $this->referencedTable = $foreignTable;
    }

    /**
     * Sets the field's length.
     * 
     * @param string $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * Sets if field accepts NULL values.
     * 
     * @param boolean $null
     */
    public function setNull($null)
    {
        $this->null = $null;
    }

    /**
     * Sets if field is a primary key.
     * 
     * @param boolean $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }

    /**
     * Sets if field is a unique key.
     * 
     * @param boolean $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }

    /**
     * Sets if field is an unsigned key.
     * 
     * @param boolean $unsinged
     */
    public function setUnsigned($unsigned)
    {
        $this->unsigned = $unsigned;
    }
}

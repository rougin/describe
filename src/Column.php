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
    /**
     * @var boolean
     */
    protected $autoIncrement = false;

    /**
     * @var string
     */
    protected $dataType = '';

    /**
     * @var string
     */
    protected $defaultValue = '';

    /**
     * @var string
     */
    protected $field = '';

    /**
     * @var boolean
     */
    protected $foreign = false;

    /**
     * @var integer
     */
    protected $length = 0;

    /**
     * @var boolean
     */
    protected $null = false;

    /**
     * @var boolean
     */
    protected $primary = false;

    /**
     * @var string
     */
    protected $referencedField = '';

    /**
     * @var string
     */
    protected $referencedTable = '';

    /**
     * @var boolean
     */
    protected $unique = false;

    /**
     * @var boolean
     */
    protected $unsigned = false;

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
     * Check if the field is an auto incrementing field.
     *
     * @return boolean
     */
    public function isAutoIncrement()
    {
        return $this->autoIncrement;
    }

    /**
     * Check if the field is a foreign key.
     *
     * @return boolean
     */
    public function isForeignKey()
    {
        return $this->foreign;
    }

    /**
     * Check if the field accept NULL values.
     *
     * @return boolean
     */
    public function isNull()
    {
        return $this->null;
    }

    /**
     * Check if the field is a primary key.
     *
     * @return boolean
     */
    public function isPrimaryKey()
    {
        return $this->primary;
    }

    /**
     * Check if field is unique.
     *
     * @return boolean
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * Check if field is unsigned.
     *
     * @return boolean
     */
    public function isUnsigned()
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

        return $this;
    }

    /**
     * Sets the data type.
     *
     * @param string $dataType
     */
    public function setDataType($dataType)
    {
        $dataTypes = [ 'integer', 'string', 'string' ];
        $shortHand = [ 'int', 'varchar', 'text' ];

        $index = array_search($dataType, $shortHand);

        $this->dataType = ($index === false) ? $dataType : $dataTypes[$index];
    }

    /**
     * Sets the default value.
     *
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * Sets the column's description.
     *
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Sets the field as a foreign key.
     *
     * @param boolean $foreign
     */
    public function setForeign($foreign)
    {
        $this->foreign = $foreign;

        return $this;
    }

    /**
     * Sets the foreign field.
     *
     * @param string $referencedField
     */
    public function setReferencedField($referencedField)
    {
        $this->referencedField = $referencedField;

        return $this;
    }

    /**
     * Sets the foreign table.
     *
     * @param string $foreignTable
     */
    public function setReferencedTable($foreignTable)
    {
        $this->referencedTable = $foreignTable;

        return $this;
    }

    /**
     * Sets the field's length.
     *
     * @param integer $length
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Sets if field accepts NULL values.
     *
     * @param boolean $null
     */
    public function setNull($null = true)
    {
        $this->null = $null;

        return $this;
    }

    /**
     * Sets if field is a primary key.
     *
     * @param boolean $primary
     */
    public function setPrimary($primary = true)
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * Sets if field is a unique key.
     *
     * @param boolean $unique
     */
    public function setUnique($unique = true)
    {
        $this->unique = $unique;

        return $this;
    }

    /**
     * Sets if field is an unsigned key.
     *
     * @param boolean $unsigned
     */
    public function setUnsigned($unsigned = true)
    {
        $this->unsigned = $unsigned;

        return $this;
    }

    /**
     * Calls methods from this class in underscore case.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $method = \Doctrine\Common\Inflector\Inflector::camelize($method);
        $result = null;

        if (method_exists($this, $method)) {
            $result = call_user_func_array([ $this, $method ], $parameters);
        }

        return (is_null($result)) ? $this : $result;
    }
}

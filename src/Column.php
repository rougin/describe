<?php

namespace Rougin\Describe;

use Doctrine\Common\Inflector\Inflector;

/**
 * Column Class
 *
 * Stores a column information from the results given.
 *
 * @package Describe
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Column
{
    /**
     * @var boolean
     */
    protected $increment = false;

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var string
     */
    protected $default = '';

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
     * @var array
     */
    protected $reference = array('field' => '', 'table' => '');

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
        return $this->type;
    }

    /**
     * Gets the default value.
     *
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->default;
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
        return $this->reference['field'];
    }

    /**
     * Gets the foreign table.
     *
     * @return string
     */
    public function getReferencedTable()
    {
        return $this->reference['table'];
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
        return $this->increment;
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
     * @param boolean $increment
     */
    public function setAutoIncrement($increment)
    {
        $this->increment = $increment;

        return $this;
    }

    /**
     * Sets the data type.
     *
     * @param  string $type
     * @return self
     */
    public function setDataType($type)
    {
        $types = array('integer', 'string', 'string');

        $shorthand = array('int', 'varchar', 'text');

        $index = array_search($type, $shorthand);

        $this->type = $index === false ? $type : $types[$index];

        return $this;
    }

    /**
     * Sets the default value.
     *
     * @param string $default
     */
    public function setDefaultValue($default)
    {
        $this->default = $default;

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
     * @param string $field
     */
    public function setReferencedField($field)
    {
        $this->reference['field'] = $field;

        return $this;
    }

    /**
     * Sets the foreign table.
     *
     * @param string $table
     */
    public function setReferencedTable($table)
    {
        $this->reference['table'] = $table;

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
     * NOTE: To be removed in v2.0.0. All new methods are now in one word.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $method = Inflector::camelize($method);

        if (method_exists($this, $method) === true) {
            $instance = array($this, $method);

            $result = call_user_func_array($instance, $parameters);
        }

        return isset($result) ? $result : $this;
    }
}

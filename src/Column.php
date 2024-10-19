<?php

namespace Rougin\Describe;

/**
 * @package Describe
 *
 * @method string                  get_data_type()
 * @method string                  get_default_value()
 * @method string                  get_field()
 * @method string                  get_referenced_field()
 * @method string                  get_referenced_table()
 * @method integer                 get_length()
 * @method boolean                 is_auto_increment()
 * @method boolean                 is_foreign_key()
 * @method boolean                 is_null()
 * @method boolean                 is_primary_key()
 * @method boolean                 is_unique()
 * @method boolean                 is_unsigned()
 * @method \Rougin\Describe\Column set_auto_increment(boolean $increment)
 * @method \Rougin\Describe\Column set_data_type(string $type)
 * @method \Rougin\Describe\Column set_default_value(string $default)
 * @method \Rougin\Describe\Column set_field(string $field)
 * @method \Rougin\Describe\Column set_foreign(string $field)
 * @method \Rougin\Describe\Column set_referenced_field(string $field)
 * @method \Rougin\Describe\Column set_referenced_table(string $table)
 * @method \Rougin\Describe\Column set_length(integer $length)
 * @method \Rougin\Describe\Column set_null(boolean $null = true)
 * @method \Rougin\Describe\Column set_primary(boolean $primary = true)
 * @method \Rougin\Describe\Column set_unique(boolean $unique = true)
 * @method \Rougin\Describe\Column set_unsigned(boolean $unsigned = true)
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
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
     * @var array<string, string>
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
     *
     * @return self
     */
    public function setAutoIncrement($increment)
    {
        $this->increment = $increment;

        return $this;
    }

    /**
     * Sets the data type.
     *
     * @param string $type
     *
     * @return self
     */
    public function setDataType($type)
    {
        $type = str_replace('int', 'integer', $type);
        $type = str_replace('varchar', 'string', $type);
        $type = str_replace('text', 'string', $type);
        $type = str_replace('tinyint', 'boolean', $type);
        $type = str_replace('nvarchar', 'string', $type);
        $type = str_replace('ntext', 'string', $type);

        $this->type = $type;

        return $this;
    }

    /**
     * Sets the default value.
     *
     * @param string $default
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
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
     *
     * @return self
     */
    public function setUnsigned($unsigned = true)
    {
        $this->unsigned = $unsigned;

        return $this;
    }

    /**
     * @deprecated since ~1.6, all methods are now in one word.
     *
     * Calls methods from this class in underscore case.
     *
     * @param string  $method
     * @param mixed[] $params
     *
     * @return mixed
     */
    public function __call($method, $params)
    {
        // Camelize the method name -----------------
        $words = ucwords(strtr($method, '_-', '  '));

        $search = array(' ', '_', '-');

        $method = str_replace($search, '', $words);

        $method = lcfirst($method);
        // ------------------------------------------

        if (method_exists($this, $method) === true)
        {
            /** @var callable */
            $class = array($this, $method);

            $result = call_user_func_array($class, $params);
        }

        return isset($result) ? $result : $this;
    }
}

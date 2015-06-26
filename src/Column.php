<?php namespace Rougin\Describe;

class Column
{

	private $_autoIncrement = FALSE;
	private $_dataType;
	private $_defaultValue;
	private $_field;
	private $_foreign = FALSE;
	private $_referencedField;
	private $_referencedTable;
	private $_length;
	private $_null = FALSE;
	private $_primary = FALSE;
	private $_unique = FALSE;
	private $_unsigned = FALSE;

	/**
	 * Get the data type
	 * 
	 * @return string
	 */
	public function getDataType()
	{
		return $this->_dataType;
	}

	/**
	 * Get the default value
	 * 
	 * @return string
	 */
	public function getDefaultValue()
	{
		return $this->_defaultValue;
	}

	/**
	 * Get the column description
	 * 
	 * @return string
	 */
	public function getField()
	{
		return $this->_field;
	}

	/**
	 * Get the foreign field
	 * 
	 * @return string
	 */
	public function getReferencedField()
	{
		return $this->_referencedField;
	}

	/**
	 * Get the foreign table
	 * 
	 * @return string
	 */
	public function getReferencedTable()
	{
		return $this->_referencedTable;
	}

	/**
	 * Get the field's length
	 * 
	 * @return integer
	 */
	public function getLength()
	{
		return $this->_length;
	}

	/**
	 * Get the data type
	 * 
	 * @return string
	 */
	public function get_data_type()
	{
		return $this->_fataType;
	}

	/**
	 * Get the default value
	 * 
	 * @return string
	 */
	public function get_default_value()
	{
		return $this->_fefaultValue;
	}

	/**
	 * Get the column description
	 * 
	 * @return string
	 */
	public function get_field()
	{
		return $this->_field;
	}

	/**
	 * Get the foreign field
	 * 
	 * @return string
	 */
	public function get_foreign_field()
	{
		return $this->_referencedField;
	}

	/**
	 * Get the foreign table
	 * 
	 * @return string
	 */
	public function get_foreign_table()
	{
		return $this->_referencedTable;
	}

	/**
	 * Get the field's length
	 * 
	 * @return string
	 */
	public function get_length()
	{
		return $this->_length;
	}

	/**
	 * Check if the field is an auto incrementing field
	 * 
	 * @return boolean
	 */
	public function isAutoIncrement()
	{
		return $this->_autoIncrement;
	}

	/**
	 * Check if the field is a foreign key
	 * 
	 * @return boolean
	 */
	public function isForeignKey()
	{
		return $this->_foreign;
	}

	/**
	 * Check if the field accept NULL values
	 * 
	 * @return boolean
	 */
	public function isNull()
	{
		return $this->_null;
	}

	/**
	 * Check if the field is a primary key
	 * 
	 * @return boolean
	 */
	public function isPrimaryKey()
	{
		return $this->_primary;
	}

	/**
	 * Check if field is unique
	 * 
	 * @return boolean
	 */
	public function isUnique()
	{
		return $this->_unique;
	}

	/**
	 * Check if field is unsigned
	 * 
	 * @return boolean
	 */
	public function isUnsigned()
	{
		return $this->_unsigned;
	}

	/**
	 * Check if the field is an auto incrementing field
	 * 
	 * @return boolean
	 */
	public function is_auto_increment()
	{
		return $this->_autoIncrement;
	}

	/**
	 * Check if the field is a foreign key
	 * 
	 * @return boolean
	 */
	public function is_foreign_key()
	{
		return $this->_foreign;
	}

	/**
	 * Check if the field accept NULL values
	 * 
	 * @return boolean
	 */
	public function is_null()
	{
		return $this->_null;
	}

	/**
	 * Check if the field is a primary key
	 * 
	 * @return boolean
	 */
	public function is_primary_key()
	{
		return $this->_primary;
	}

	/**
	 * Check if field is unique
	 * 
	 * @return boolean
	 */
	public function is_unique()
	{
		return $this->_unique;
	}

	/**
	 * Check if field is unsigned
	 * 
	 * @return boolean
	 */
	public function is_unsigned()
	{
		return $this->_unsigned;
	}

	/**
	 * Set the auto increment
	 * 
	 * @param boolean $autoIncrement
	 */
	public function setAutoIncrement($autoIncrement)
	{
		$this->_autoIncrement = $autoIncrement;
	}

	/**
	 * Set the data type
	 * 
	 * @param string $dataType
	 */
	public function setDataType($dataType)
	{
		if (strpos($dataType, 'int') !== FALSE) {
			$dataType = 'integer';
		}

		if (strpos($dataType, 'varchar') !== FALSE || strpos($dataType, 'text') !== FALSE) {
			$dataType = 'string';
		}

		$this->_dataType = $dataType;
	}

	/**
	 * Set the default value
	 * 
	 * @param boolean $defaultValue
	 */
	public function setDefaultValue($defaultValue)
	{
		$this->_defaultValue = $defaultValue;
	}

	/**
	 * Set the column's description
	 * 
	 * @param string $field
	 */
	public function setField($field)
	{
		$this->_field = $field;
	}

	/**
	 * Set the foreign field
	 * 
	 * @param string $referencedField
	 */
	public function setReferencedField($referencedField)
	{
		$this->_referencedField = $referencedField;
	}

	/**
	 * Set the foreign table
	 * 
	 * @param string $referencedField
	 */
	public function setReferencedTable($foreignTable)
	{
		$this->_referencedTable = $foreignTable;
	}

	/**
	 * Set the field's length
	 * 
	 * @param string $length
	 */
	public function setLength($length)
	{
		$this->_length = $length;
	}

	/**
	 * Set if field accepts NULL values
	 * 
	 * @param boolean $null
	 */
	public function setNull($null)
	{
		$this->_null = $null;
	}

	/**
	 * Set if field is a primary key
	 * 
	 * @param boolean $primary
	 */
	public function setPrimary($primary)
	{
		$this->_primary = $primary;
	}

	/**
	 * Set if field is a unique key
	 * 
	 * @param boolean $unique
	 */
	public function setUnique($unique)
	{
		$this->_unique = $unique;
	}

	/**
	 * Set if field is an unsigned key
	 * 
	 * @param boolean $unsinged
	 */
	public function setUnsigned($unsigned)
	{
		$this->_unsigned = $unsigned;
	}

}
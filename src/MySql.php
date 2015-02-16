<?php namespace Describe;

use Describe\DescribeInterface;

class MySql implements DescribeInterface {

	private $_columns        = array();
	private $_databaseHandle = NULL;

	/**
	 * Get the properties and attributes of the specified table
	 * 
	 * @param string $hostname
	 * @param string $database
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($hostname, $database, $username, $password)
	{
		if (is_array($hostname)) {
			$hostname = $hostname['hostname'];
			$database = $hostname['database'];
			$username = $hostname['username'];
			$password = $hostname['password'];
		}

		/**
		 * Connect to the database
		 */

		try {
			$this->_databaseHandle = new \PDO(
				'mysql:host=' . $hostname . 
				';dbname=' . $database,
				$username,
				$password
			);

			$this->_databaseHandle->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
		catch (\PDOException $error) {
			exit($error->getMessage());
		}
	}

	/**
	 * Return the result
	 * 
	 * @return array
	 */
	public function getInformationFromTable($table)
	{
		$tableInformation = $this->_databaseHandle->prepare('DESCRIBE ' . $table);
		$tableInformation->execute();
		$tableInformation->setFetchMode(\PDO::FETCH_OBJ);

		while ($row = $tableInformation->fetch()) {
			$column = array(
				'defaultValue'     => $row->Default,
				'extra'            => $row->Extra,
				'field'            => $row->Field,
				'isNull'           => $row->Null,
				'key'              => $row->Key,
				'referencedColumn' => NULL,
				'referencedTable'  => NULL,
				'type'             => $row->Type
			);

			$foreignTableInformation = $this->_databaseHandle->prepare('
				SELECT
					COLUMN_NAME as "column",
					REFERENCED_TABLE_NAME as "referenced_table",
					REFERENCED_COLUMN_NAME as "referenced_column"
				FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
				WHERE TABLE_NAME = "' . $table . '";
			');
			$foreignTableInformation->execute();
			$foreignTableInformation->setFetchMode(\PDO::FETCH_OBJ);

			while ($foreignRow = $foreignTableInformation->fetch()) {
				if ($foreignRow->column == $row->Field) {
					$column['referencedColumn'] = $foreignRow->referenced_column;
					$column['referencedTable']  = $foreignRow->referenced_table;
				}
			}

			$this->_columns[] = (object) $column;
		}

		$this->_databaseHandle = NULL;

		return $this->_columns;
	}

	/**
	 * Get the primary key in the specified table
	 * 
	 * @param  string $table
	 * @return string
	 */
	public function getPrimaryKey($table)
	{
		$columns = (empty($this->_columns)) ? $this->getInformationFromTable($table) : $this->_columns;

		foreach ($columns as $column) {
			if ($column->key == 'PRI') {
				return $column->field;
			}
		}
	}

}
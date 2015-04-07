<?php namespace Describe;

use Describe\MySql;

/**
 * Describe Class
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Describe {

	private $_columns        = array();
	private $_databaseHandle = NULL;
	private $_databaseDriver = NULL;

	/**
	 * Get the properties and attributes of the specified table
	 * 
	 * @param string $hostname
	 * @param string $database
	 * @param string $username
	 * @param string $password
	 * @param string $driver
	 */
	public function __construct($hostname, $database = NULL, $username = NULL, $password = NULL, $driver = NULL)
	{
		if (is_array($hostname)) {
			$database = $hostname['database'];
			$driver   = $hostname['driver'];
			$password = $hostname['password'];
			$username = $hostname['username'];

			$hostname = $hostname['hostname'];
		}

		/**
		 * Change to "mysql" if the driver specified is "mysqli"
		 */

		$driver = ($driver == 'mysqli') ? 'mysql' : $driver;

		/**
		 * Set as the currently selected driver
		 */

		$this->_databaseDriver = $driver;

		/**
		 * Connect to the database
		 */

		try {
			$this->_databaseHandle = new \PDO(
				$driver .
				':host=' . $hostname .
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
	 * Returns the table information
	 *
	 * @param  string $table
	 * @return array
	 */
	public function getInformationFromTable($table)
	{
		$driver = NULL;

		switch ($this->_databaseDriver) {
			case 'mysql':
				$driver = new MySql($this->_databaseHandle);
				break;
			default:
				break;
		}

		return ($driver != NULL) ? $driver->getInformationFromTable($table) : array();
	}

	/**
	 * Get the primary key in the specified table
	 * 
	 * @param  string $table
	 * @return string
	 */
	public function getPrimaryKey($table)
	{
		$columns = $this->_columns;

		if (empty($columns)) {
			$columns = $this->getInformationFromTable($table);
		}

		foreach ($columns as $column) {
			if ($column->key == 'PRI') {
				return $column->field;
			}
		}
	}

	/**
	 * Returns the table information
	 * 
	 * @param  string $table
	 * @return array
	 */
	public function get_information_from_table($table)
	{
		return $this->getInformationFromTable($table);
	}

	/**
	 * Get the primary key in the specified table
	 * 
	 * @param  string $table
	 * @return string
	 */
	public function get_primary_key($table)
	{
		return $this->getPrimaryKey($table);
	}

}
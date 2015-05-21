<?php namespace Rougin\Describe;

use Rougin\Describe\DescribeInterface;

/**
 * MsSql Class
 *
 * @package  Describe
 * @category MSSQL
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MsSql implements DescribeInterface {

	private $_databaseHandle = NULL;

	/**
	 * Inject the database handle
	 * 
	 * @param \PDO $databaseHandle
	 */
	public function __construct($databaseHandle)
	{
		$this->_databaseHandle = $databaseHandle;
	}

	/**
	 * Return the result
	 * 
	 * @return array
	 */
	public function getInformationFromTable($table)
	{
		$columns = array();

		return $columns;
	}

	/**
	 * Show the list of tables
	 * 
	 * @return array
	 */
	public function showTables()
	{
		$tables = array();

		return $tables;
	}

}
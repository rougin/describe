<?php namespace Rougin\Describe;

use Rougin\Describe\DescribeInterface;
use Rougin\Describe\Column;

/**
 * Sqlite Class
 *
 * @package  Describe
 * @category Sqlite
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Sqlite implements DescribeInterface {

	private $_handle = NULL;

	/**
	 * Inject the database handle
	 * 
	 * @param \PDO $handle
	 */
	public function __construct($handle)
	{
		$this->_handle = $handle;
	}

	/**
	 * Return the result
	 * 
	 * @return array
	 */
	public function getInformationFromTable($table)
	{
		$columns = array();
		$query = 'PRAGMA table_info("' . $table . '");';

		$tableInformation = $this->_handle->prepare($query);
		$tableInformation->execute();
		$tableInformation->setFetchMode(\PDO::FETCH_OBJ);

		if (strpos($table, '.')) {
			$table = substr($table, strpos($table, '.') + 1);
		}

		while ($row = $tableInformation->fetch()) {
			$column = new Column();

			if ( ! $row->notnull) {
				$column->setNull(TRUE);
			}

			if ($row->pk) {
				$column->setPrimary(TRUE);
				$column->setAutoIncrement(TRUE);
			}

			$column->setDefaultValue($row->dflt_value);
			$column->setField($row->name);
			$column->setDataType(strtolower($row->type));

			$columns[] = $column;
		}

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
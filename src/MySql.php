<?php namespace Rougin\Describe;

use Rougin\Describe\DescribeInterface;
use Rougin\Describe\Column;

/**
 * MySql Class
 *
 * @package  Describe
 * @category MySQL
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MySql implements DescribeInterface {

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
		$query = 'DESCRIBE ' . $table;

		$tableInformation = $this->_handle->prepare($query);
		$tableInformation->execute();
		$tableInformation->setFetchMode(\PDO::FETCH_OBJ);

		if (strpos($table, '.')) {
			$table = substr($table, strpos($table, '.') + 1);
		}

		while ($row = $tableInformation->fetch()) {
			preg_match('/(.*?)\((.*?)\)/', $row->Type, $match);
			$column = new Column();

			if ($row->Extra == 'auto_increment') {
				$column->setAutoIncrement(TRUE);
			}

			if ($row->Null == 'YES') {
				$column->setNull(TRUE);
			}

			if ($row->Key == 'PRI') {
				$column->setPrimary(TRUE);
			} else if ($row->Key == 'MUL') {
				$column->setForeign(TRUE);
			} else if ($row->Key == 'UNI') {
				$column->setUnique(TRUE);
			}

			$column->setDataType($match[1]);
			$column->setDefaultValue($row->Default);
			$column->setField($row->Field);
			$column->setLength($match[2]);

			$query = 'SELECT COLUMN_NAME as "column", REFERENCED_COLUMN_NAME as "referenced_column",
			CONCAT(REFERENCED_TABLE_SCHEMA, ".", REFERENCED_TABLE_NAME) as "referenced_table"
			FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = "' . $table . '";';

			$foreignTableInformation = $this->_handle->prepare($query);
			$foreignTableInformation->execute();
			$foreignTableInformation->setFetchMode(\PDO::FETCH_OBJ);

			while ($foreignRow = $foreignTableInformation->fetch()) {
				if ($foreignRow->column == $row->Field) {
					$column->setReferencedField($foreignRow->referenced_column);
					$column->setReferencedTable($foreignRow->referenced_table);
				}
			}

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
		$query = 'SHOW TABLES';

		$showTables = $this->_handle->prepare($query);
		$showTables->execute();

		while ($row = $showTables->fetch()) {
			$tables[] = $row[0];
		}

		return $tables;
	}

}
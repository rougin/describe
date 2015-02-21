<?php namespace Describe;

use Describe\Describe;
use Describe\DescribeInterface;

class MySql implements DescribeInterface {

	private $_databaseHandle = NULL;

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
		$tableInformation = $this->_databaseHandle->prepare('DESCRIBE ' . $table);
		$tableInformation->execute();
		$tableInformation->setFetchMode(\PDO::FETCH_OBJ);

		while ($row = $tableInformation->fetch()) {
			$column = array(
				'defaultValue'     => $row->Default,
				'extra'            => $row->Extra,
				'field'            => $row->Field,
				'isNull'           => NULL,
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

			$column['isNull'] = ($row->Null == 'YES') ? TRUE : FALSE;

			$columns[] = (object) $column;
		}

		return $columns;
	}

}
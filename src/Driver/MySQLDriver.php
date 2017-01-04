<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;

/**
 * MySQL Driver
 *
 * A database driver extension for MySQL.
 *
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MySQLDriver extends AbstractDriver implements DriverInterface
{
    /**
     * @var string
     */
    protected $database;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param PDO    $pdo
     * @param string $database
     */
    public function __construct(\PDO $pdo, $database)
    {
        $this->database = $database;
        $this->pdo = $pdo;
    }

    /**
     * Returns a listing of columns from the specified table.
     *
     * @param  string $tableName
     * @return array
     * @throws \Rougin\Describe\Exceptions\TableNameNotFoundException
     */
    public function getColumns($tableName)
    {
        return $this->getColumnsFromQuery($tableName, 'DESCRIBE ' . $tableName);
    }

    /**
     * Returns a listing of columns from the specified table.
     * NOTE: To be removed in v2.0.0.
     *
     * @param  string $tableName
     * @return array
     * @throws \Rougin\Describe\Exceptions\TableNameNotFoundException
     */
    public function getTable($tableName)
    {
        return $this->getColumns($tableName);
    }

    /**
     * Returns a listing of tables from the specified database.
     *
     * @return array
     */
    public function getTableNames()
    {
        return $this->showTables();
    }

    /**
     * Shows the list of tables.
     * NOTE: To be removed in v2.0.0.
     *
     * @return array
     */
    public function showTables()
    {
        $tables = [];

        $information = $this->pdo->prepare('SHOW TABLES');
        $information->execute();

        while ($row = $information->fetch()) {
            array_push($tables, $row[0]);
        }

        return $tables;
    }

    /**
     * Prepares the defined columns.
     *
     * @param  string $tableName
     * @param  mixed  $row
     * @return \Rougin\Describe\Column
     */
    protected function setColumn($tableName, $row)
    {
        preg_match('/(.*?)\((.*?)\)/', $row->Type, $match);

        $column = new Column;


        $column->setDataType($row->Type);
        $column->setDefaultValue($row->Default);
        $column->setField($row->Field);

        if (isset($match[1])) {
            $column->setDataType($match[1]);
            $column->setLength($match[2]);
        }

        $column = $this->setProperties($row, $column);
        $column = $this->setKey($row, $column);
        $column = $this->setForeignColumn($tableName, $row, $column);

        return $column;
    }

    /**
     * Sets the key of the specified column.
     *
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function setKey($row, Column $column)
    {
        switch ($row->Key) {
            case 'PRI':
                $column->setPrimary(true);

                break;
            
            case 'MUL':
                $column->setForeign(true);

                break;

            case 'UNI':
                $column->setUnique(true);

                break;
        }

        return $column;
    }

    /**
     * Sets the properties of the specified column if it does exists.
     *
     * @param  string                  $tableName
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function setForeignColumn($tableName, $row, Column $column)
    {
        $query = 'SELECT COLUMN_NAME as "column", REFERENCED_COLUMN_NAME as "referenced_column",' .
            'CONCAT(REFERENCED_TABLE_SCHEMA, ".", REFERENCED_TABLE_NAME) as "referenced_table"' .
            'FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE ' .
            'WHERE CONSTRAINT_SCHEMA = "' . $this->database . '" AND TABLE_NAME = "' . $tableName . '";';

        $foreignTable = $this->pdo->prepare($query);

        $foreignTable->execute();
        $foreignTable->setFetchMode(\PDO::FETCH_OBJ);

        while ($foreignRow = $foreignTable->fetch()) {
            if ($foreignRow->column == $row->Field) {
                $referencedTable = $this->stripTableSchema($foreignRow->referenced_table);

                $column->setReferencedField($foreignRow->referenced_column);
                $column->setReferencedTable($referencedTable);
            }
        }

        return $column;
    }

    /**
     * Sets the properties of the specified column.
     *
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function setProperties($row, Column $column)
    {
        $null = 'Null';

        if ($row->Extra == 'auto_increment') {
            $column->setAutoIncrement(true);
        }

        if ($row->$null == 'YES') {
            $column->setNull(true);
        }

        return $column;
    }

    /**
     * Strips the table schema from the table name.
     *
     * @param  string $table
     * @return string
     */
    protected function stripTableSchema($table)
    {
        return (strpos($table, '.') !== false) ? substr($table, strpos($table, '.') + 1) : $table;
    }
}

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
class MySQLDriver implements DriverInterface
{
    /**
     * @var array
     */
    protected $columns = [];

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
     * Returns the result.
     *
     * @return array
     */
    public function getTable($table)
    {
        $this->columns = [];

        try {
            $information = $this->pdo->prepare('DESCRIBE ' . $table);

            $information->execute();
            $information->setFetchMode(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {}

        while ($row = $information->fetch()) {
            preg_match('/(.*?)\((.*?)\)/', $row->Type, $match);

            $column = new Column;

            $this->setProperties($row, $column);
            $this->setKey($row, $column);

            $column->setDataType($row->Type);
            $column->setDefaultValue($row->Default);
            $column->setField($row->Field);

            if (isset($match[1])) {
                $column->setDataType($match[1]);
                $column->setLength($match[2]);
            }

            $query = 'SELECT COLUMN_NAME as "column",' .
                'REFERENCED_COLUMN_NAME as "referenced_column",' .
                'CONCAT(' .
                    'REFERENCED_TABLE_SCHEMA, ".",' .
                    'REFERENCED_TABLE_NAME' .
                ') as "referenced_table"' .
                'FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE ' .
                'WHERE CONSTRAINT_SCHEMA = "' . $this->database . '" ' .
                'AND TABLE_NAME = "' . $table . '";';

            $foreignTable = $this->pdo->prepare($query);

            $foreignTable->execute();
            $foreignTable->setFetchMode(\PDO::FETCH_OBJ);

            $this->setForeignColumns($foreignTable, $row, $column);

            array_push($this->columns, $column);
        }

        return $this->columns;
    }

    /**
     * Shows the list of tables.
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
     * Sets the key of the specified column.
     *
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column &$column
     * @return void
     */
    protected function setKey($row, Column &$column)
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
    }

    /**
     * Sets the properties of the specified column.
     *
     * @param  \PDOStatement           $foreignTable
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column &$column
     * @return void
     */
    protected function setForeignColumns($foreignTable, $row, Column &$column)
    {
        while ($foreignRow = $foreignTable->fetch()) {
            if ($foreignRow->column == $row->Field) {
                $referencedTable = $this->stripTableSchema($foreignRow->referenced_table);

                $column->setReferencedField($foreignRow->referenced_column);
                $column->setReferencedTable($referencedTable);
            }
        }
    }

    /**
     * Sets the properties of the specified column.
     *
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column &$column
     * @return void
     */
    protected function setProperties($row, Column &$column)
    {
        $null = 'Null';

        if ($row->Extra == 'auto_increment') {
            $column->setAutoIncrement(true);
        }

        if ($row->$null == 'YES') {
            $column->setNull(true);
        }
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

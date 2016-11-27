<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;

/**
 * SQLite Driver
 *
 * A database driver extension for SQLite.
 *
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SQLiteDriver implements DriverInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Returns the result.
     *
     * @return array
     */
    public function getTable($table)
    {
        $columns = [];

        try {
            $query = $this->pdo->prepare('PRAGMA table_info("' . $table . '");');

            $query->execute();
            $query->setFetchMode(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return [];
        }

        while ($row = $query->fetch()) {
            $column = new Column;

            $this->setProperties($row, $column);

            $column->setDefaultValue($row->dflt_value);
            $column->setField($row->name);
            $column->setDataType(strtolower($row->type));

            array_push($columns, $column);
        }

        return $this->prepareForeignColumns($columns, $table);
    }

    /**
     * Shows the list of tables.
     *
     * @return array
     */
    public function showTables()
    {
        $tables = [];

        $query = $this->pdo->prepare('SELECT name FROM sqlite_master WHERE type = "table";');

        $query->execute();
        $query->setFetchMode(\PDO::FETCH_OBJ);

        while ($row = $query->fetch()) {
            if ($row->name != 'sqlite_sequence') {
                array_push($tables, $row->name);
            }
        }

        return $tables;
    }

    /**
     * Prepares the columns that have foreign keys.
     *
     * @param array  &$columns
     * @param object $row
     */
    protected function setForeignColumn(array &$columns, $row)
    {
        foreach ($columns as $column) {
            if ($column->getField() == $row->from) {
                $column->setForeign(true);

                $column->setReferencedField($row->to);
                $column->setReferencedTable($row->table);
            }
        }

        return $columns;
    }

    /**
     * Prepares the query for getting the foreign columns.
     *
     * @param  array  $columns
     * @param  string $tableName
     * @return array
     */
    protected function prepareForeignColumns(array $columns, $tableName)
    {
        $query = $this->pdo->prepare('PRAGMA foreign_key_list("' . $tableName . '");');

        $query->execute();
        $query->setFetchMode(\PDO::FETCH_OBJ);

        while ($row = $query->fetch()) {
            $this->setForeignColumn($columns, $row);
        }

        return $columns;
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
        if (! $row->notnull) {
            $column->setNull(true);
        }

        if ($row->pk) {
            $column->setPrimary(true);
            $column->setAutoIncrement(true);
        }
    }
}

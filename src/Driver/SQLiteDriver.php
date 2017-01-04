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
class SQLiteDriver extends AbstractDriver implements DriverInterface
{
    /**
     * @var array
     */
    protected $columns = [];

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
     * Returns a listing of columns from the specified table.
     *
     * @param  string $tableName
     * @return array
     * @throws \Rougin\Describe\Exceptions\TableNameNotFoundException
     */
    public function getColumns($tableName)
    {
        return $this->getColumnsFromQuery($tableName, 'PRAGMA table_info("' . $tableName . '");');
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
     * Prepares the defined columns.
     *
     * @param  string $tableName
     * @param  mixed  $row
     * @return \Rougin\Describe\Column
     */
    protected function setColumn($tableName, $row)
    {
        $column = new Column;

        $column->setDefaultValue($row->dflt_value);
        $column->setField($row->name);
        $column->setDataType(strtolower($row->type));

        $column = $this->setProperties($row, $column);
        $column = $this->setForeignColumn($tableName, $column);

        return $column;
    }

    /**
     * Sets the properties of the specified column if it does exists.
     *
     * @param  string                  $tableName
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function setForeignColumn($tableName, Column $column)
    {
        $query = $this->pdo->prepare('PRAGMA foreign_key_list("' . $tableName . '");');

        $query->execute();
        $query->setFetchMode(\PDO::FETCH_OBJ);

        while ($row = $query->fetch()) {
            if ($column->getField() == $row->from) {
                $column->setForeign(true);

                $column->setReferencedField($row->to);
                $column->setReferencedTable($row->table);
            }
        }

        return $column;
    }

    /**
     * Sets the properties of the specified column.
     *
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column $column
     * @return void
     */
    protected function setProperties($row, Column $column)
    {
        if (! $row->notnull) {
            $column->setNull(true);
        }

        if ($row->pk) {
            $column->setPrimary(true);
            $column->setAutoIncrement(true);
        }

        return $column;
    }
}

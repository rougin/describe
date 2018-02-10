<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Table;

/**
 * SQLite Driver
 *
 * A database driver extension for SQLite.
 * NOTE: Should be renamed to "SqliteDriver" in v2.0.0.
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SQLiteDriver extends MySQLDriver
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Initializes the driver instance.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    /**
     * Returns an array of Column instances from a table.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table)
    {
        return $this->query($table, 'PRAGMA table_info("' . $table . '");');
    }

    /**
     * Returns an array of Column instances from a table.
     * NOTE: To be removed in v2.0.0. Use columns() instead.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function getColumns($table)
    {
        return $this->columns($table);
    }

    /**
     * Returns an array of Column instances from a table.
     * NOTE: To be removed in v2.0.0. Use getColumns() instead.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function getTable($table)
    {
        return $this->getColumns($table);
    }

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use tables() instead.
     *
     * @return array
     */
    public function getTableNames()
    {
        return $this->items(false);
    }

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use getTableNames() instead.
     *
     * @return array
     */
    public function showTables()
    {
        return $this->getTableNames();
    }

    /**
     * Returns an array of Table instances.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        return $this->items(true);
    }

    /**
     * Prepares the defined columns.
     *
     * @param  \Rougin\Describe\Column $column
     * @param  string                  $table
     * @param  mixed                   $row
     * @return \Rougin\Describe\Column
     */
    protected function column(Column $column, $table, $row)
    {
        $column->setDefaultValue($row->dflt_value);

        $column->setField($row->name);

        $column->setDataType(strtolower($row->type));

        $column = $this->reference($table, $column);

        $column->setNull(! $row->notnull);

        $row->pk && $column->setAutoIncrement(true);

        $row->pk && $column->setPrimary(true);

        return $column;
    }

    /**
     * Returns an array of table names or Table instances.
     * NOTE: To be removed in v2.0.0. Move to tables() instead.
     *
     * @param  boolean $instance
     * @param  array   $tables
     * @return array|\Rougin\Describe\Table[]
     */
    protected function items($instance = false, $tables = array())
    {
        $query = 'SELECT name FROM sqlite_master WHERE type = "table";';

        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_OBJ);

        while ($row = $result->fetch()) {
            if ($row->name !== 'sqlite_sequence') {
                $name = $row->name;

                $tables[] = new Table($name, $this);
            }
        }

        return $tables;
    }

    /**
     * Sets the properties of a column if it does exists.
     *
     * @param  string                  $table
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function reference($table, Column $column)
    {
        $query = 'PRAGMA foreign_key_list("' . $table . '");';

        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_OBJ);

        while ($row = $result->fetch()) {
            if ($column->getField() === $row->from) {
                $column->setReferencedTable($row->table);

                $column->setForeign(true);

                $column->setReferencedField($row->to);
            }
        }

        return $column;
    }
}

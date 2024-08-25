<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Table;

/**
 * NOTE: Should be renamed to "SqliteDriver" in v2.0.0.
 *
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SQLiteDriver extends MySQLDriver
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    /**
     * Returns an array of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table)
    {
        return $this->query($table, 'PRAGMA table_info("' . $table . '");');
    }

    /**
     * @deprecated since ~1.7, use "columns" instead.
     *
     * Returns an array of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function getColumns($table)
    {
        return $this->columns($table);
    }

    /**
     * @deprecated since ~1.7, use "columns" instead.
     *
     * Returns an array of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function getTable($table)
    {
        return $this->getColumns($table);
    }

    /**
     * @deprecated since ~1.6, use "tables" instead.
     *
     * Returns an array of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function getTableNames()
    {
        return $this->items(false);
    }

    /**
     * @deprecated since ~1.4, use "getTableNames" instead.
     *
     * Returns an array of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function showTables()
    {
        return $this->getTableNames();
    }

    /**
     * Returns an array of tables.
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
     * @param \Rougin\Describe\Column $column
     * @param string                  $table
     * @param array<string, string>   $row
     *
     * @return \Rougin\Describe\Column
     */
    protected function column(Column $column, $table, $row)
    {
        $column->setDefaultValue($row['dflt_value']);

        $column->setField($row['name']);

        $column->setDataType(strtolower($row['type']));

        $column = $this->reference($table, $column);

        $column->setNull(! $row['notnull']);

        if ($row['pk'])
        {
            $column->setAutoIncrement(true);

            $column->setPrimary(true);
        }

        return $column;
    }

    /**
     * @deprecated since ~1.7, move to "tables" instead.
     *
     * Returns an array of table names or tables.
     *
     * @param boolean  $instance
     * @param string[] $tables
     *
     * @return \Rougin\Describe\Table[]|array
     */
    protected function items($instance = false, $tables = array())
    {
        $query = 'SELECT name FROM sqlite_master WHERE type = "table";';

        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_ASSOC);

        while ($row = $result->fetch())
        {
            if ($row['name'] !== 'sqlite_sequence')
            {
                $name = $row['name'];

                $tables[] = new Table($name, $this);
            }
        }

        return $tables;
    }

    /**
     * Sets the properties of a column if it does exists.
     *
     * @param string                  $table
     * @param \Rougin\Describe\Column $column
     *
     * @return \Rougin\Describe\Column
     */
    protected function reference($table, Column $column)
    {
        $query = 'PRAGMA foreign_key_list("' . $table . '");';

        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_ASSOC);

        while ($row = $result->fetch())
        {
            if ($column->getField() === $row['from'])
            {
                $column->setReferencedTable($row['table']);

                $column->setForeign(true);

                $column->setReferencedField($row['to']);
            }
        }

        return $column;
    }
}

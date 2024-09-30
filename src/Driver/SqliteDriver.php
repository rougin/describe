<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Table;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SqliteDriver extends MysqlDriver
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
     * Returns a list of columns from a table.
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
     * @codeCoverageIgnore
     *
     * Returns a list of columns from a table.
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
     * @codeCoverageIgnore
     *
     * Returns a list of columns from a table.
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
     * @codeCoverageIgnore
     *
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function getTableNames()
    {
        return $this->tables();
    }

    /**
     * @deprecated since ~1.4, use "getTableNames" instead.
     * @codeCoverageIgnore
     *
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function showTables()
    {
        return $this->getTableNames();
    }

    /**
     * Returns a list of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        $query = 'SELECT name FROM sqlite_master WHERE type = "table";';

        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_ASSOC);

        $tables = array();

        while ($row = $result->fetch())
        {
            /** @var array<string, string> $item */
            $item = $row;

            if ($item['name'] === 'sqlite_sequence')
            {
                continue;
            }

            $tables[] = new Table($item['name'], $this);
        }

        return $tables;
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

        // Return the data type and its length --------------
        preg_match('/(.*?)\((.*?)\)/', $row['type'], $match);

        if (isset($match[1]))
        {
            $column->setDataType(strtolower($match[1]));

            $column->setLength((int) $match[2]);
        }
        else
        {
            $column->setDataType($row['type']);
        }
        // --------------------------------------------------

        $column = $this->getForeign($table, $column);

        if ($row['pk'])
        {
            $column->setAutoIncrement(true);

            $column->setPrimary(true);
        }

        return $column->setNull(! $row['notnull']);

    }

    /**
     * Sets the properties of a column if it does exists.
     *
     * @param string                  $table
     * @param \Rougin\Describe\Column $column
     *
     * @return \Rougin\Describe\Column
     */
    protected function getForeign($table, Column $column)
    {
        $query = 'PRAGMA foreign_key_list("' . $table . '");';

        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_ASSOC);

        while ($row = $result->fetch())
        {
            /** @var array<string, string> */
            $item = $row;

            if ($column->getField() !== $item['from'])
            {
                continue;
            }

            $column->setReferencedTable($item['table']);

            $column->setForeign(true);

            $column->setReferencedField($item['to']);
        }

        return $column;
    }
}

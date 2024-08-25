<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Exceptions\TableNotFoundException;
use Rougin\Describe\Table;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MysqlDriver implements DriverInterface
{
    /**
     * @var string
     */
    protected $db;

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @param \PDO   $pdo
     * @param string $db
     */
    public function __construct(\PDO $pdo, $db)
    {
        $this->db = $db;

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
        return $this->query($table, 'DESCRIBE ' . $table);
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
        return $this->tables();
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
        $tables = array();

        $result = $this->pdo->prepare('SHOW TABLES');

        $result->execute();

        /** @var string[] $row */
        while ($row = $result->fetch())
        {
            $tables[] = new Table($row[0], $this);
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
        $column->setDataType($row['Type']);

        $column->setDefaultValue($row['Default']);

        $column->setField($row['Field']);

        // Return the data type and its length --------------
        preg_match('/(.*?)\((.*?)\)/', $row['Type'], $match);

        if (isset($match[1]))
        {
            $column->setDataType($match[1]);

            $column->setLength($match[2]);
        }
        // --------------------------------------------------

        // In MySQL ~8.0, integer does not show its length ---
        if ($column->getDataType() === 'integer')
        {
            if (! isset($match[1]))
            {
                $column->setLength(10);
            }
        }
        // --------------------------------------------------

        if ($row['Null'] === 'YES')
        {
            $column->setNull(true);
        }

        if ($row['Extra'] === 'auto_increment')
        {
            $column->setAutoIncrement(true);
        }

        if ($row['Key'] === 'PRI')
        {
            $column->setPrimary(true);
        }

        if ($row['Key'] === 'MUL')
        {
            $column->setForeign(true);
        }

        if ($row['Key'] === 'UNI')
        {
            $column->setUnique(true);
        }

        return $this->setForeign($table, $row, $column);
    }

    /**
     * Returns the list of columns based on a query.
     *
     * @param string $table
     * @param string $query
     *
     * @return \Rougin\Describe\Column[]
     * @throws \Rougin\Describe\Exceptions\TableNotFoundException
     */
    protected function query($table, $query)
    {
        $columns = array();

        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_ASSOC);

        while ($row = $result->fetch())
        {
            $columns[] = $this->column(new Column, $table, $row);
        }

        if (count($columns) > 0)
        {
            return $columns;
        }

        $message = 'Table "' . $table . '" does not exists!';

        throw new TableNotFoundException($message);
    }

    /**
     * Sets the properties of a column if it does exists.
     *
     * @param string                  $name
     * @param array<string, string>   $row
     * @param \Rougin\Describe\Column $column
     *
     * @return \Rougin\Describe\Column
     */
    protected function setForeign($name, $row, Column $column)
    {
        $script = 'SELECT COLUMN_NAME as "column", REFERENCED_COLUMN_NAME as ' .
            '"referenced_column", CONCAT(REFERENCED_TABLE_SCHEMA, ".", ' .
            'REFERENCED_TABLE_NAME) as "referenced_table" FROM INFORMATION_SCHEMA' .
            '.KEY_COLUMN_USAGE WHERE CONSTRAINT_SCHEMA = "%s" AND TABLE_NAME = "%s";';

        $query = sprintf($script, $this->db, $name);

        $table = $this->pdo->prepare($query);

        $table->execute();

        $table->setFetchMode(\PDO::FETCH_ASSOC);

        /** @var array<string, string> $item */
        while ($item = $table->fetch())
        {
            if ($item['column'] !== $row['Field'])
            {
                continue;
            }

            $refTable = $item['referenced_table'];

            $refTable = $this->strip($refTable);

            $column->setReferencedField($item['referenced_column']);

            $column->setReferencedTable($refTable);
        }

        return $column;
    }

    /**
     * Strips the table schema from the table name.
     *
     * @param string $table
     *
     * @return string
     */
    protected function strip($table)
    {
        $exists = strpos($table, '.') !== false;

        $updated = substr($table, strpos($table, '.') + 1);

        return $exists ? $updated : $table;
    }
}

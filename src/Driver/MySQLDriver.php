<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Column;
use Rougin\Describe\Exceptions\TableNotFoundException;
use Rougin\Describe\Table;

/**
 * MySQL Driver
 *
 * A database driver extension for MySQL.
 * NOTE: Should be renamed to "MySqlDriver" in v2.0.0.
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MySQLDriver implements DriverInterface
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
     * @var string
     */
    protected $script = '';

    /**
     * Initializes the driver instance.
     *
     * @param \PDO   $pdo
     * @param string $database
     */
    public function __construct(\PDO $pdo, $database)
    {
        $this->database = $database;

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;

        $this->script = 'SELECT COLUMN_NAME as "column", REFERENCED_COLUMN_NAME as ' .
            '"referenced_column", CONCAT(REFERENCED_TABLE_SCHEMA, ".", ' .
            'REFERENCED_TABLE_NAME) as "referenced_table" FROM INFORMATION_SCHEMA' .
            '.KEY_COLUMN_USAGE WHERE CONSTRAINT_SCHEMA = "%s" AND TABLE_NAME = "%s";';
    }

    /**
     * Returns an array of Column instances from a table.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table)
    {
        return $this->query($table, 'DESCRIBE ' . $table);
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
        preg_match('/(.*?)\((.*?)\)/', $row->Type, $match);

        $column->setDataType($row->Type);

        $column->setDefaultValue($row->Default);

        $column->setField($row->Field);

        if (isset($match[1]) === true) {
            $column->setDataType($match[1]);

            $column->setLength($match[2]);
        }

        $column = $this->properties($row, $column);

        $column = $this->keys($row, $column);

        return $this->foreign($table, $row, $column);
    }

    /**
     * Sets the properties of a column if it does exists.
     *
     * @param  string                  $name
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function foreign($name, $row, Column $column)
    {
        $query = sprintf($this->script, $this->database, $name);

        $table = $this->pdo->prepare($query);

        $table->execute();

        $table->setFetchMode(\PDO::FETCH_OBJ);

        while ($item = $table->fetch()) {
            if ($item->column === $row->Field) {
                $referenced = $this->strip($item->referenced_table);

                $column->setReferencedField($item->referenced_column);

                $column->setReferencedTable($referenced);
            }
        }

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
        $information = $this->pdo->prepare('SHOW TABLES');

        $information->execute();

        while ($row = $information->fetch()) {
            // NOTE: To be removed in v2.0.0. Always return Table instance.
            $instance && $row[0] = new Table($row[0], $this);

            array_push($tables, $row[0]);
        }

        return $tables;
    }

    /**
     * Sets the key of a column.
     *
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function keys($row, Column $column)
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
     * Returns the list of columns based on a query.
     *
     * @param  string $table
     * @param  string $query
     * @param  array  $columns
     * @return \Rougin\Describe\Column[]
     */
    protected function query($table, $query, $columns = array())
    {
        $result = $this->pdo->prepare($query);

        $result->execute();

        $result->setFetchMode(\PDO::FETCH_OBJ);

        while ($row = $result->fetch()) {
            $column = $this->column(new Column, $table, $row);

            array_push($columns, $column);
        }

        if (empty($columns) === true) {
            $message = 'Table "' . $table . '" does not exists!';

            throw new TableNotFoundException($message);
        }

        return $columns;
    }

    /**
     * Sets the properties of a column.
     *
     * @param  mixed                   $row
     * @param  \Rougin\Describe\Column $column
     * @return \Rougin\Describe\Column
     */
    protected function properties($row, Column $column)
    {
        $increment = $row->Extra === 'auto_increment';

        $column->setAutoIncrement($increment);

        $column->setNull($row->Null === 'YES');

        return $column;
    }

    /**
     * Strips the table schema from the table name.
     *
     * @param  string $table
     * @return string
     */
    protected function strip($table)
    {
        $exists = strpos($table, '.') !== false;

        $updated = substr($table, strpos($table, '.') + 1);

        return $exists ? $updated : $table;
    }
}

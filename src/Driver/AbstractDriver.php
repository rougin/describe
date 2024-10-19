<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Exceptions\TableNotFoundException;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractDriver implements DriverInterface
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
     * Returns the list of columns based on a query.
     *
     * @param string $table
     * @param string $query
     *
     * @return \Rougin\Describe\Column[]
     * @throws \Rougin\Describe\Exceptions\TableNotFoundException
     */
    protected function setColumns($table, $query)
    {
        $columns = array();

        $result = $this->pdo->prepare($query);

        $result->execute();

        /** @var array<string, string>[] */
        $items = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($items as $item)
        {
            $columns[] = $this->newColumn($table, $item);
        }

        if (count($columns) > 0)
        {
            return $columns;
        }

        $message = 'Table "' . $table . '" does not exists!';

        throw new TableNotFoundException($message);
    }

    /**
     * Prepares the defined columns.
     *
     * @param string                $table
     * @param array<string, string> $row
     *
     * @return \Rougin\Describe\Column
     */
    abstract protected function newColumn($table, $row);
}

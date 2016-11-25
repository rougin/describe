<?php

namespace Rougin\Describe;

/**
 * Describe
 *
 * Gets information of a table schema from a database.
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Describe
{
    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var \Rougin\Describe\Driver\DriverInterface
     */
    protected $driver;

    /**
     * @param \Rougin\Describe\Driver\DriverInterface $driver
     */
    public function __construct(\Rougin\Describe\Driver\DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Gets the primary key in the specified table.
     *
     * @param  string $table
     * @return string
     */
    public function getPrimaryKey($table)
    {
        $result = '';

        if (empty($this->columns)) {
            $this->columns = $this->driver->getTable($table);
        }

        foreach ($this->columns as $column) {
            if ($column->isPrimaryKey()) {
                $result = $column->getField();
            }
        }

        return $result;
    }

    /**
     * Returns the result.
     *
     * @param  string $table
     * @return array
     * @throws \Rougin\Describe\Exceptions\TableNameNotFoundException
     */
    public function getTable($tableName)
    {
        $table = $this->driver->getTable($tableName);

        if (empty($table) || is_null($table)) {
            $message = '"' . $tableName . '" table not found in database!';

            throw new Exceptions\TableNameNotFoundException($message);
        }

        return $table;
    }

    /**
     * Shows the list of tables.
     *
     * @return array
     */
    public function showTables()
    {
        return $this->driver->showTables();
    }

    /**
     * Calls methods from this class in underscore case.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return MagicMethodHelper::call($this, $method, $parameters);
    }
}

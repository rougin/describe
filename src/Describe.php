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
     * @var \Rougin\Describe\Driver\DriverInterface
     */
    protected $driver;

    /**
     * @param \Rougin\Describe\Driver\DriverInterface $driver
     */
    public function __construct(Driver\DriverInterface $driver)
    {
        $this->driver = $driver;
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
        $table = $this->driver->getTable($tableName);

        if (empty($table) || is_null($table)) {
            throw new Exceptions\TableNameNotFoundException;
        }

        return $table;
    }

    /**
     * Gets the primary key in the specified table.
     *
     * @param  string  $tableName
     * @param  boolean $object
     * @return string
     */
    public function getPrimaryKey($tableName, $object = false)
    {
        $columns = $this->getColumns($tableName);
        $result  = '';

        foreach ($columns as $column) {
            if ($column->isPrimaryKey()) {
                $result = $column;
            }
        }

        return ($object === true) ? $result : $result->getField();
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
        return $this->driver->showTables();
    }

    /**
     * Shows the list of tables.
     * NOTE: To be removed in v2.0.0.
     *
     * @return array
     */
    public function showTables()
    {
        return $this->getTableNames();
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
        $method = \Doctrine\Common\Inflector\Inflector::camelize($method);
        $result = $this;

        if (method_exists($this, $method)) {
            $result = call_user_func_array([ $this, $method ], $parameters);
        }

        return $result;
    }
}

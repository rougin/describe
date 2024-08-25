<?php

namespace Rougin\Describe;

use Doctrine\Common\Inflector\Inflector;
use Rougin\Describe\Exceptions\TableNotFoundException;

/**
 * @deprecated since ~1.7, use "Table" instead.
 *
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
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
     * Returns an array of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     * @throws \Rougin\Describe\Exceptions\TableNotFoundException
     */
    public function columns($table)
    {
        try
        {
            return $this->driver->columns($table);
        }
        catch (\PDOException $error)
        {
            throw new TableNotFoundException($error->getMessage());
        }
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
        return $this->driver->columns($table);
    }

    /**
     * @deprecated since ~1.7, use "primary" instead.
     *
     * Returns the primary key of a table.
     *
     * @param string $table
     *
     * @return string|null
     */
    public function getPrimaryKey($table)
    {
        return $this->primary($table);
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
        return $this->driver->columns($table);
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
        return $this->driver->tables();
    }

    /**
     * Returns the primary key of a table.
     *
     * @param string  $table
     * @param boolean $object
     *
     * @return string|null
     */
    public function primary($table)
    {
        $table = new Table($table, $this->driver);

        return $table->primary();
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
        return $this->driver->tables();
    }

    /**
     * Returns an array of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        return $this->driver->tables();
    }

    /**
     * @deprecated since ~1.6, all methods are now in one word.
     *
     * Calls methods from this class in underscore case.
     *
     * @param string $method
     * @param mixed  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // Camelize the method name ---------------
        $words = ucwords($method, ' _-');

        $search = array(' ', '_', '-');

        $method = str_replace($search, '', $words);

        $method = lcfirst((string) $method);
        // ----------------------------------------

        $instance = array($this, $method);

        return call_user_func_array($instance, $parameters);
    }
}

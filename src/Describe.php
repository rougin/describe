<?php

namespace Rougin\Describe;

use Doctrine\Common\Inflector\Inflector;
use Rougin\Describe\Exceptions\TableNotFoundException;

/**
 * Describe
 *
 * Gets information of a table schema from a database.
 * NOTE: To be removed in v2.0.0. Use Table class instead.
 *
 * @package Describe
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
     * Returns an array of Column instances from a table.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     *
     * @throws \Rougin\Describe\Exceptions\TableNotFoundException
     */
    public function columns($table)
    {
        try {
            $columns = $this->driver->columns($table);

            return $columns;
        } catch (\PDOException $error) {
            $text = (string) $error->getMessage();

            throw new TableNotFoundException($text);
        }
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
        return $this->driver->getColumns($table);
    }

    /**
     * Returns the primary key of a table.
     * NOTE: To be removed in v2.0.0. Use primary() instead.
     *
     * @param  string  $table
     * @param  boolean $object
     * @return \Rougin\Describe\Column|string
     */
    public function getPrimaryKey($table, $object = false)
    {
        return $this->primary($table, $object);
    }

    /**
     * Returns an array of columns from a table.
     * NOTE: To be removed in v2.0.0. Use getColumns() instead.
     *
     * @param  string $table
     * @return array
     */
    public function getTable($table)
    {
        return $this->driver->getTable($table);
    }

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use tables() instead.
     *
     * @return array
     */
    public function getTableNames()
    {
        return $this->driver->getTableNames();
    }

    /**
     * Returns the primary key of a table.
     *
     * @param  string  $table
     * @param  boolean $object
     * @return \Rougin\Describe\Column|string
     */
    public function primary($table, $object = false)
    {
        $table = new Table($table, $this->driver);

        ($result = $table->primary()) === null && $result = '';

        return $object ? $result : $result->getField();
    }

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use getTableNames() instead.
     *
     * @return array
     */
    public function showTables()
    {
        return $this->driver->showTables();
    }

    /**
     * Returns an array of Table instances.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        return $this->driver->tables();
    }

    /**
     * Calls methods from this class in underscore case.
     * NOTE: To be removed in v2.0.0. All new methods are now in one word.
     *
     * @param  string $method
     * @param  mixed  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $method = (string) Inflector::camelize($method);

        $instance = array($this, $method);

        return call_user_func_array($instance, $parameters);
    }
}

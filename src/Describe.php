<?php

namespace Rougin\Describe;

use Rougin\Describe\Drivers\DriverInterface;

/**
 * Describe Class
 *
 * Gets information of a table schema from a database.
 * 
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Describe
{
    protected $driver;

    /**
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Returns the result.
     *
     * @param  string $table
     * @return array
     */
    public function getTable($table)
    {
        return $this->driver->getTable($table);
    }

    /**
     * Gets the primary key in the specified table.
     * 
     * @param  string $table
     * @return string
     */
    public function getPrimaryKey($table)
    {
        return $this->driver->getPrimaryKey($table);
    }

    /**
     * Returns the result.
     * 
     * @param  string $table
     * @return array
     */
    public function get_information_from_table($table)
    {
        return $this->driver->getTable($table);
    }

    /**
     * Gets the primary key in the specified table.
     * 
     * @param  string $table
     * @return string
     */
    public function get_primary_key($table)
    {
        return $this->driver->getPrimaryKey($table);
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
     * Shows the list of tables.
     * 
     * @return array
     */
    public function show_tables()
    {
        return $this->driver->showTables();
    }
}

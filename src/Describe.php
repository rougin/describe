<?php

namespace Rougin\Describe;

use Rougin\Describe\MySql;
use Rougin\Describe\MsSql;
use Rougin\Describe\Sqlite;

/**
 * Describe Class
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Describe
{
    protected $columns = [];
    protected $driver;

    /**
     * Get the properties and attributes of the specified table
     * 
     * @param string $hostname
     * @param string $database
     * @param string $username
     * @param string $password
     * @param string $driver
     */
    public function __construct($hostname, $database = NULL, $username = NULL, $password = NULL, $driver = NULL)
    {
        if (is_array($hostname)) {
            $database = $hostname['database'];
            $driver   = $hostname['driver'];
            $password = $hostname['password'];
            $username = $hostname['username'];

            $hostname = $hostname['hostname'];
        }

        /**
         * Change to "mysql" if the driver specified is "mysqli"
         */

        $driver = ($driver == 'mysqli') ? 'mysql' : $driver;

        /**
         * Set the current database
         */
        
        $this->database = $database;

        /**
         * Parse the given credentials into a string parameter
         */

        if ($database == NULL || $driver == 'pdo' || strpos($hostname, ':') !== FALSE) {
            $parameters = $hostname;

            $keys = explode(':', $hostname);
            $driver = $keys[0];
        }

        $parameters = $driver . ':' .'host=' . $hostname . ';dbname=' . $database;

        if ($driver != 'mysql') {
            $parameters = $parameters . ', ' . $username . ', ' . $password;
        }

        if ($driver == 'sqlite') {
            $parameters = $hostname;
        }

        /**
         * Connect to the database
         */

        try {
            if ($driver == 'mysql') {
                $handle = new \PDO($parameters, $username, $password);
            } else {
                $handle = new \PDO($parameters);
            }

            $handle->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            /**
             * Set as the currently selected driver
             */
            
            $this->driver = $this->getDatabaseDriver($driver, $handle, $database);
        }
        catch (\PDOException $error) {
            exit($error->getMessage());
        }
    }

    /**
     * Return the result
     *
     * @param  string $table
     * @return array
     */
    public function getInformationFromTable($table)
    {
        if ($this->driver != NULL) {
            $this->columns = $this->driver->getInformationFromTable($table);

            return $this->columns;
        }

        return [];
    }

    /**
     * Get the primary key in the specified table
     * 
     * @param  string $table
     * @return string
     */
    public function getPrimaryKey($table)
    {
        $columns = $this->columns;

        if (empty($columns)) {
            $columns = $this->getInformationFromTable($table);
        }

        foreach ($columns as $column) {
            if ($column->isPrimaryKey()) {
                return $column->get_field();
            }
        }
    }

    /**
     * Return the result
     * 
     * @param  string $table
     * @return array
     */
    public function get_information_from_table($table)
    {
        return $this->getInformationFromTable($table);
    }

    /**
     * Get the primary key in the specified table
     * 
     * @param  string $table
     * @return string
     */
    public function get_primary_key($table)
    {
        return $this->getPrimaryKey($table);
    }

    /**
     * Show the list of tables
     * 
     * @return array
     */
    public function showTables()
    {
        if ($this->driver != NULL) {
            return $this->driver->showTables();
        }

        return [];
    }

    /**
     * Show the list of tables
     * 
     * @return array
     */
    public function show_tables()
    {
        return $this->showTables();
    }

    /**
     * Return the specified database driver
     * 
     * @param  string $driver
     * @return object
     */
    private function getDatabaseDriver($driver, $handle, $database)
    {
        $selectedDriver = (object) [];

        switch ($driver) {
            case 'mysql':
                return new MySql($handle, $database);
            case 'mssql':
                return new MsSql($handle, $database);
            case 'sqlite':
                return new Sqlite($handle, $database);
        }

        return $selectedDriver;
    }
}

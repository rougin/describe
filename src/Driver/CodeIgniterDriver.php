<?php

namespace Rougin\Describe\Driver;

use PDO;
use Rougin\Describe\Driver\DriverInterface;
use Rougin\Describe\Column;
use Rougin\Describe\Driver\MySQLDriver;
use Rougin\Describe\Driver\SQLiteDriver;

/**
 * CodeIgniter Driver Class
 *
 * A database driver specifically used for CodeIgniter.
 * 
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CodeIgniterDriver implements DriverInterface
{
    protected $connection;
    protected $database;
    protected $driver;

    /**
     * @param array  $database
     * @param string $connection
     */
    public function __construct(array $database, $connection = 'default')
    {
        $this->database = $database;
        $this->connection = $connection;
    }

    /**
     * Gets the specified driver from the specified database connection
     * 
     * @param  array  $database
     * @param  string $connection
     * @return DriverInterface
     */
    public function getDriver(array $database, $connection)
    {
        switch ($database[$connection]['dbdriver']) {
            case 'mysql':
            case 'mysqli':
                return new MySQLDriver(
                    new PDO(
                        'mysql:host=' . $database[$connection]['hostname'] .
                        ';dbname=' . $database[$connection]['database'],
                        $database[$connection]['username'],
                        $database[$connection]['password']
                    ),
                    $database[$connection]['database']
                );
            case 'sqlite':
                return new SQLiteDriver(
                    new PDO($database[$connection]['hostname'])
                );
        }
    }

    /**
     * Returns the result.
     * 
     * @return array
     */
    public function getTable($table)
    {
        $driver = $this->getDriver($this->database, $this->connection);

        return $driver->getTable($table);
    }

    /**
     * Shows the list of tables.
     * 
     * @return array
     */
    public function showTables()
    {
        return [];
    }
}

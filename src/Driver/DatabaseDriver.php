<?php

namespace Rougin\Describe\Driver;

/**
 * Database Driver
 *
 * A database driver for using available database drivers.
 *
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DatabaseDriver implements DriverInterface
{
    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @var string
     */
    protected $driver = '';

    /**
     * @param string $driver
     * @param array  $configuration
     */
    public function __construct($driver, $configuration = [])
    {
        $this->driver = $driver;
        $this->configuration = $configuration;
    }

    /**
     * Gets the specified driver from the specified database connection.
     *
     * @param string $driverName
     * @param array  $configuration
     * @return \Rougin\Describe\Driver\DriverInterface|null
     */
    public function getDriver($driverName, $configuration = [])
    {
        $mysql  = [ 'mysql', 'mysqli' ];
        $sqlite = [ 'pdo', 'sqlite', 'sqlite3' ];

        list($database, $hostname, $username, $password) = $this->parseConfiguration($configuration);

        if (in_array($database['dbdriver'], $mysql)) {
            $dsn    = 'mysql:host=' . $hostname . ';dbname=' . $database;
            $pdo    = new \PDO($dsn, $username, $password);
            $driver = new MySQLDriver($pdo, $database);
        }

        if (in_array($database['dbdriver'], $sqlite)) {
            $pdo    = new \PDO($hostname);
            $driver = new SQLiteDriver($pdo);
        }

        return $driver;
    }

    /**
     * Returns the result.
     *
     * @return array
     */
    public function getTable($table)
    {
        $driver = $this->getDriver($this->driver, $this->configuration);

        return $driver->getTable($table);
    }

    /**
     * Shows the list of tables.
     *
     * @return array
     */
    public function showTables()
    {
        $driver = $this->getDriver($this->driver, $this->configuration);

        return $driver->showTables();
    }

    /**
     * Parses the configuration into separate variables.
     *
     * @param  array  $configuration
     * @return array
     */
    protected function parseConfiguration(array $configuration)
    {
        $driver   = null;
        $database = null;
        $hostname = null;
        $password = null;
        $username = null;

        if (isset($configuration['database'])) {
            $database = $configuration['database'];
        }

        if (isset($configuration['hostname'])) {
            $hostname = $configuration['hostname'];
        }

        if (isset($configuration['password'])) {
            $password = $configuration['password'];
        }

        if (isset($configuration['username'])) {
            $username = $configuration['username'];
        }

        return [ $database, $hostname, $username, $password ];
    }
}

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
     * @var \Rougin\Describe\Driver\DriverInterface
     */
    protected $driver;

    /**
     * @param string $driverName
     * @param array  $configuration
     */
    public function __construct($driverName, $configuration = [])
    {
        $this->configuration = $configuration;
        $this->driver        = $this->getDriver($driverName, $configuration);
    }

    /**
     * Gets the specified driver from the specified database connection.
     *
     * @param  string $driverName
     * @param  array  $configuration
     * @return \Rougin\Describe\Driver\DriverInterface
     * @throws \Rougin\Describe\Exceptions\DatabaseDriverNotFoundException
     */
    protected function getDriver($driverName, $configuration = [])
    {
        $mysql  = [ 'mysql', 'mysqli' ];
        $sqlite = [ 'pdo', 'sqlite', 'sqlite3' ];

        list($database, $hostname, $username, $password) = $this->parseConfiguration($configuration);

        if (in_array($driverName, $mysql)) {
            $dsn = 'mysql:host=' . $hostname . ';dbname=' . $database;
            $pdo = new \PDO($dsn, $username, $password);

            return new MySQLDriver($pdo, $database);
        }

        if (in_array($driverName, $sqlite)) {
            $pdo = new \PDO($hostname);

            return new SQLiteDriver($pdo);
        }

        $message = 'Specified database driver not found!';

        throw new \Rougin\Describe\Exceptions\DatabaseDriverNotFoundException($message);
    }

    /**
     * Returns the result.
     *
     * @return array
     */
    public function getTable($table)
    {
        return $this->driver->getTable($table);
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
     * Parses the configuration into separate variables.
     *
     * @param  array  $configuration
     * @return array
     */
    protected function parseConfiguration(array $configuration)
    {
        $database = null;
        $hostname = null;
        $password = null;
        $username = null;

        foreach ($configuration as $key => $value) {
            if (isset($configuration[$key])) {
                $$key = $configuration[$key];
            }
        }

        return [ $database, $hostname, $username, $password ];
    }
}

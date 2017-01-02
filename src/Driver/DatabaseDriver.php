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
        } elseif (in_array($driverName, $sqlite)) {
            $pdo = new \PDO($hostname);

            return new SQLiteDriver($pdo);
        }

        throw new \Rougin\Describe\Exceptions\DatabaseDriverNotFoundException;
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
        return $this->driver->getTable($tableName);
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
        return $this->driver->getTableNames();
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

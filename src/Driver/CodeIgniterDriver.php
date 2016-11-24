<?php

namespace Rougin\Describe\Driver;

/**
 * CodeIgniter Driver
 *
 * A database driver specifically used for CodeIgniter.
 *
 * @package  Describe
 * @category Driver
 * @author   Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CodeIgniterDriver implements DriverInterface
{
    /**
     * @var \Rougin\Describe\Driver\DriverInterface|null
     */
    protected $driver = null;

    /**
     * Gets the specified driver from the specified database connection.
     *
     * @param array $database
     */
    public function __construct(array $database)
    {
        // NOTE: To be removed in v1.0.0
        if (isset($database['default'])) {
            $database = $database['default'];
        }

        $this->driver = $this->getDriver($database);
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
     * Returns the driver to be used.
     *
     * @param  array  $database
     * @return \Rougin\Describe\Driver\DriverInterface|null
     */
    protected function getDriver(array $database)
    {
        $driver = null;
        $mysql  = [ 'mysql', 'mysqli' ];
        $sqlite = [ 'pdo', 'sqlite', 'sqlite3' ];

        if (in_array($database['dbdriver'], $mysql)) {
            $dsn = 'mysql:host=' . $database['hostname'] . ';dbname=' . $database['database'];
            $pdo = new \PDO($dsn, $database['username'], $database['password']);

            $driver = new MySQLDriver($pdo, $database['database']);
        }

        if (in_array($database['dbdriver'], $sqlite)) {
            $pdo = new \PDO($database['hostname']);

            $driver = new SQLiteDriver($pdo);
        }

        return $driver;
    }
}

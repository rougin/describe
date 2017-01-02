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
        // NOTE: To be removed in v2.0.0
        if (isset($database['default'])) {
            $database = $database['default'];
        }

        $this->driver = $this->getDriver($database);
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
     * @return array
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
     * Returns the driver to be used.
     *
     * @param  array  $database
     * @return \Rougin\Describe\Driver\DriverInterface|null
     * @throws \Rougin\Describe\Exceptions\DatabaseDriverNotFoundException
     */
    protected function getDriver(array $database)
    {
        $mysql  = [ 'mysql', 'mysqli' ];
        $sqlite = [ 'pdo', 'sqlite', 'sqlite3' ];

        if (in_array($database['dbdriver'], $mysql)) {
            $dsn = 'mysql:host=' . $database['hostname'] . ';dbname=' . $database['database'];
            $pdo = new \PDO($dsn, $database['username'], $database['password']);

            return new MySQLDriver($pdo, $database['database']);
        }

        if (in_array($database['dbdriver'], $sqlite)) {
            $pdo = new \PDO($database['hostname']);

            return new SQLiteDriver($pdo);
        }

        throw new \Rougin\Describe\Exceptions\DatabaseDriverNotFoundException;
    }
}

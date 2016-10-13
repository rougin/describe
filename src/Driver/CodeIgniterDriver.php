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

        switch ($database['dbdriver']) {
            case 'mysql':
            case 'mysqli':
                $dsn = 'mysql:host=' . $database['hostname'] . ';dbname=' . $database['database'];
                $pdo = new \PDO($dsn, $database['username'], $database['password']);

                $this->driver = new MySQLDriver($pdo, $database['database']);

                break;
            case 'pdo':
            case 'sqlite':
            case 'sqlite3':
                $pdo = new \PDO($database['hostname']);

                $this->driver = new SQLiteDriver($pdo);

                break;
        }
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
}

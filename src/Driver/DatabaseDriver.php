<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Exceptions\DriverNotFoundException;

/**
 * Database Driver
 *
 * A database driver for using available database drivers.
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DatabaseDriver implements DriverInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var \Rougin\Describe\Driver\DriverInterface
     */
    protected $driver;

    /**
     * @var array
     */
    protected $mysql = array('mysql', 'mysqli');

    /**
     * @var array
     */
    protected $sqlite = array('pdo', 'sqlite', 'sqlite3');

    /**
     * Initializes the driver instance.
     *
     * @param string $name
     * @param array  $data
     */
    public function __construct($name, $data = array())
    {
        $this->data = $data;

        $this->driver = $this->driver($name, $data);
    }

    /**
     * Returns an array of Column instances from a table.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table)
    {
        return $this->driver->columns($table);
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
        return $this->columns($table);
    }

    /**
     * Returns an array of Column instances from a table.
     * NOTE: To be removed in v2.0.0. Use getColumns() instead.
     *
     * @param  string $table
     * @return \Rougin\Describe\Column[]
     */
    public function getTable($table)
    {
        return $this->getColumns($table);
    }

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use tables() instead.
     *
     * @return array
     */
    public function getTableNames()
    {
        return $this->tables();
    }

    /**
     * Returns an array of table names.
     * NOTE: To be removed in v2.0.0. Use getTableNames() instead.
     *
     * @return array
     */
    public function showTables()
    {
        return $this->getTableNames();
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
     * Returns the Driver instance from the configuration.
     *
     * @param  string $name
     * @param  array  $data
     * @return \Rougin\Describe\Driver\DriverInterface
     *
     * @throws \Rougin\Describe\Exceptions\DriverNotFoundException
     */
    protected function driver($name, $data = array())
    {
        if (in_array($name, $this->mysql) === true) {
            $dsn = 'mysql:host=' . $data['hostname'];

            $dsn .= ';dbname=' . $data['database'];

            $pdo = new \PDO($dsn, $data['username'], $data['password']);

            return new MySQLDriver($pdo, $data['database']);
        }

        if (in_array($name, $this->sqlite)) {
            $pdo = new \PDO($data['hostname']);

            return new SQLiteDriver($pdo);
        }

        throw new DriverNotFoundException;
    }
}

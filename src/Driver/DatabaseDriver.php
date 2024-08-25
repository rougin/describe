<?php

namespace Rougin\Describe\Driver;

use Rougin\Describe\Exceptions\DriverNotFoundException;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DatabaseDriver implements DriverInterface
{
    /**
     * @var array<string, string>
     */
    protected $data = array();

    /**
     * @var \Rougin\Describe\Driver\DriverInterface
     */
    protected $driver;

    /**
     * @var string[]
     */
    protected $mysql = array('mysql', 'mysqli');

    /**
     * @var string[]
     */
    protected $sqlite = array('pdo', 'sqlite', 'sqlite3');

    /**
     * @param string                $name
     * @param array<string, string> $data
     */
    public function __construct($name, $data = array())
    {
        $this->data = $data;

        $this->driver = $this->driver($name, $data);
    }

    /**
     * Returns an array of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function columns($table)
    {
        return $this->driver->columns($table);
    }

    /**
     * @deprecated since ~1.7, use "columns" instead.
     *
     * Returns an array of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function getColumns($table)
    {
        return $this->columns($table);
    }

    /**
     * @deprecated since ~1.7, use "columns" instead.
     *
     * Returns an array of columns from a table.
     *
     * @param string $table
     *
     * @return \Rougin\Describe\Column[]
     */
    public function getTable($table)
    {
        return $this->getColumns($table);
    }

    /**
     * @deprecated since ~1.6, use "tables" instead.
     *
     * Returns an array of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function getTableNames()
    {
        return $this->tables();
    }

    /**
     * @deprecated since ~1.4, use "getTableNames" instead.
     *
     * Returns an array of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function showTables()
    {
        return $this->getTableNames();
    }

    /**
     * Returns an array of tables.
     *
     * @return \Rougin\Describe\Table[]
     */
    public function tables()
    {
        return $this->driver->tables();
    }

    /**
     * Returns the driver based on the configuration.
     *
     * @param string                $name
     * @param array<string, string> $data
     *
     * @return \Rougin\Describe\Driver\DriverInterface
     * @throws \Rougin\Describe\Exceptions\DriverNotFoundException
     */
    protected function driver($name, $data = array())
    {
        if (in_array($name, $this->mysql))
        {
            $dsn = (string) 'mysql:host=%s;dbname=%s';

            $dsn = sprintf($dsn, $data['hostname'], $data['database']);

            $pdo = new \PDO($dsn, $data['username'], $data['password']);

            return new MySQLDriver($pdo, (string) $data['database']);
        }

        if (in_array($name, $this->sqlite))
        {
            return new SQLiteDriver(new \PDO($data['hostname']));
        }

        $message = 'Database driver "%s" not found.';

        $message = sprintf($message, (string) $name);

        throw new DriverNotFoundException($message);
    }
}

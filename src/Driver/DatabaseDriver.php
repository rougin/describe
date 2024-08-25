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
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
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
        $isMysql = in_array($name, array('mysql', 'mysqli'));

        $isSqlite = in_array($name, array('pdo', 'sqlite', 'sqlite3'));

        if (! $isMysql && ! $isSqlite)
        {
            $message = 'Database driver "%s" not found.';

            $message = sprintf($message, (string) $name);

            throw new DriverNotFoundException($message);
        }

        if ($isSqlite)
        {
            return new SqliteDriver(new \PDO($data['hostname']));
        }

        $dsn = (string) 'mysql:host={HOST};dbname={NAME}';

        $dsn = str_replace('{HOST}', $data['hostname'], $dsn);

        $dsn = str_replace('{NAME}', $data['database'], $dsn);

        $pdo = new \PDO($dsn, $data['username'], $data['password']);

        return new MysqlDriver($pdo, $data['database']);
    }
}

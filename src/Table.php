<?php

namespace Rougin\Describe;

use Rougin\Describe\Driver\DriverInterface;

/**
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Table
{
    /**
     * @var \Rougin\Describe\Driver\DriverInterface
     */
    protected $driver;

    /**
     * @var string
     */
    protected $name;

    /**
     * Initializes the table instance.
     *
     * @param string                                  $name
     * @param \Rougin\Describe\Driver\DriverInterface $driver
     */
    public function __construct($name, DriverInterface $driver)
    {
        $this->driver = $driver;

        $this->name = $name;
    }

    /**
     * Returns a list of columns.
     *
     * @return \Rougin\Describe\Column[]
     */
    public function columns()
    {
        return $this->driver->columns($this->name);
    }

    /**
     * Returns the name of the table.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Returns the primary key of a table.
     *
     * @return string|null
     */
    public function primary()
    {
        $result = null;

        foreach ($this->columns() as $column)
        {
            if ($column->isPrimaryKey())
            {
                $result = $column->getField();
            }
        }

        return $result;
    }
}

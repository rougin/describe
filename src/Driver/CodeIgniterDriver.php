<?php

namespace Rougin\Describe\Driver;

/**
 * Codeigniter Driver
 *
 * A database driver specifically used for Codeigniter.
 * NOTE: To be removed in v2.0.0. Use "DatabaseDriver" instead.
 *
 * @package Describe
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CodeIgniterDriver extends DatabaseDriver
{
    /**
     * Initializes the driver instance.
     *
     * @param array $database
     */
    public function __construct(array $database)
    {
        // NOTE: To be removed in v2.0.0. Use $database['default'] outside.
        isset($database['default']) && $database = $database['default'];

        $this->driver = $this->driver($database['dbdriver'], $database);
    }
}

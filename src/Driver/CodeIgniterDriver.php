<?php

namespace Rougin\Describe\Driver;

/**
 * CodeIgniter Driver
 *
 * A database driver specifically used for CodeIgniter.
 * NOTE: Should be renamed to "CodeigniterDriver" in v2.0.0.
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
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
        // NOTE: To be removed in v2.0.0. Use $database['default'] as the
        // $database parameter in __construct(array $database).
        isset($database['default']) && $database = $database['default'];

        $this->driver = $this->driver($database['dbdriver'], $database);
    }
}

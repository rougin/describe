<?php

namespace Rougin\Describe\Driver;

/**
 * @deprecated since ~1.5, use "DatabaseDriver" instead.
 *
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CodeIgniterDriver extends DatabaseDriver
{
    /**
     * @param array<string, string> $database
     */
    public function __construct(array $database)
    {
        /** @deprecated since ~1.7, use $database['default'] outside. */
        if (array_key_exists('default', $database))
        {
            $database = $database['default'];
        }

        $this->driver = $this->driver($database['dbdriver'], $database);
    }
}

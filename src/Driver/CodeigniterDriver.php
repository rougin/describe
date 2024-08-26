<?php

namespace Rougin\Describe\Driver;

/**
 * @deprecated since ~1.5, use "DatabaseDriver" instead.
 *
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CodeigniterDriver extends DatabaseDriver
{
    /**
     * @param array<string, string> $config
     */
    public function __construct(array $config)
    {
        $this->driver = $this->driver($config['dbdriver'], $config);
    }
}

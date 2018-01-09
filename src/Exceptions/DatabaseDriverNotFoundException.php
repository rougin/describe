<?php

namespace Rougin\Describe\Exceptions;

/**
 * Database Driver Not Found Exception
 * NOTE: To be removed in v2.0.0. Use DriverNotFoundException instead.
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DatabaseDriverNotFoundException extends \UnexpectedValueException
{
    /**
     * @var string
     */
    protected $message = 'Database driver not found!';
}

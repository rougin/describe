<?php

namespace Rougin\Describe\Exceptions;

/**
 * Database Driver Not Found Exception
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

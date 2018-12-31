<?php

namespace Rougin\Describe\Exceptions;

/**
 * Driver Not Found Exception
 *
 * @package Describe
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class DriverNotFoundException extends \UnexpectedValueException
{
    /**
     * @var string
     */
    protected $message = 'Database driver not found!';
}

<?php

namespace Rougin\Describe;

/**
 * Magic Method Helper
 *
 * @package Describe
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class MagicMethodHelper
{
    /**
     * Calls methods from the specified object in underscore case.
     *
     * @param  object $object
     * @param  string $method
     * @param  mixed  parameters
     * @return mixed
     */
    public static function call($object, $method, $parameters)
    {
        $method = \Doctrine\Common\Inflector\Inflector::camelize($method);
        $result = $object;

        if (method_exists($object, $method)) {
            $result = call_user_func_array([ $object, $method ], $parameters);
        }

        return $result;
    }
}

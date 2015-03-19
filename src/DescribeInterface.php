<?php namespace Describe;

/**
 * Describe Interface
 *
 * @package     Describe
 * @category    Interface
 */
interface DescribeInterface {

	/**
	 * Return the result
	 * 
	 * @return array
	 */
	public function getInformationFromTable($table);

}
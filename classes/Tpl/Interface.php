<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Template engine interface.
 *
 * @package    Tpl
 * @category   Interface
 * @author     Kohana Team
 * @copyright  (c) 2008-2013 Kohana Team
 * @license    http://kohanaframework.org/license
 */
interface Tpl_Interface {

	/**
	 * Create driver for template engine.
	 * 
	 * @param   array  $config  Engine settings
	 * @return  void
	 */
	public function __construct(array $config);

	/**
	 * Renders the view object to a string.
	 * 
	 * @param   string  $file  Template file
	 * @param   array   $data  Template variables 
	 * @return  string
	 */
	public function render($file, array $data);

} // End Tpl_Engine
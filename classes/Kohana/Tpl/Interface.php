<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Interface for driver template engine.
 *
 * @package    Tpl
 * @category   Interface
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2013 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
interface Kohana_Tpl_Interface {

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

} // End Kohana_Tpl_Interface
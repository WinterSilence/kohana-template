<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Fenom template engine driver. 
 * For get more info visit (project home page)[https://github.com/bzick/fenom/].
 *
 * @package    Tpl
 * @category   Driver
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2013 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
abstract class Kohana_Tpl_Fenom implements Kohana_Tpl_Interface {

	/**
	 * @var  object  Instance of template engine 
	 */
	protected $_engine;

	/**
	 * Create instance of template engine.
	 * 
	 * @param   array  $config  Engine settings
	 * @return  void
	 */
	public function __construct(array $config)
	{
		// Create engine provider
		$provider = new Kohana_Tpl_Fenom_Provider($config['extension']);
		// Create engine instance
		$this->_engine = Fenom::factory($provider, $config['compile_dir'], $config['options']);
		// Add modifier default
		//require_once Kohana::find_file('fenom'.DIRECTORY_SEPARATOR.'modifiers', 'default');
		//$this->_engine->addModifier('default', 'fenom_modifier_default');
	}

	/**
	 * Renders the view object to a string.
	 * 
	 * @param   string  $file  Template file
	 * @param   array   $data  Template variables
	 * @return  string
	 */
	public function render($file, array $data)
	{
		return $this->_engine->fetch($file, $data);
	}

} // End Tpl_Fenom
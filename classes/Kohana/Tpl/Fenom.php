<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Tpl driver for [Fenom template engine](http://github.com/bzick/fenom). 
 *
 * @package    Tpl
 * @category   Driver
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2014 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
abstract class Kohana_Tpl_Fenom implements Kohana_Tpl_Interface {

	/**
	 * @var  object  instance of template engine 
	 */
	protected $_engine;

	/**
	 * Create instance of template engine.
	 * 
	 * @param   array  $config  engine settings
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
	 * @param   string  $file  template file
	 * @param   array   $data  template variables
	 * @return  string
	 */
	public function render($file, array $data)
	{
		return $this->_engine->fetch($file, $data);
	}

} // End Tpl_Fenom
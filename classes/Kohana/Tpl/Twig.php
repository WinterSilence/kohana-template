<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Twig template engine driver. 
 * For get more info visit (project home page)[http://twig.sensiolabs.org/documentation].
 *
 * @package    Tpl
 * @category   Driver
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2013 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
abstract class Kohana_Tpl_Twig implements Kohana_Tpl_Interface {

	/**
	 * @var  string  Extension of view file
	 */
	protected $_extension;

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
		$this->_extension = $config['extension'];
		$loader = new Twig_Loader_Filesystem($config['template_dir']);
		$this->_engine = new Twig_Environment($loader, $config['options']);
		//$this->_engine->addExtension(new Kohana_Twig_Extension);
		// Add global variables
		foreach ( (array) Arr::get($config, 'globals') as $name => $global)
		{
			$this->_engine->addGlobal($name, $global);
		}
		// Add filters
		foreach ( (array) Arr::get($config, 'filters') as $name => $filter)
		{
			$this->_engine->addFilter($name, new Twig_Filter_Function($filter));
		}
		// Add functions
		foreach ( (array) Arr::get($config, 'functions') as $name => $function)
		{
			if (Arr::is_array($function))
			{
				$this->_engine->addFunction($name, new Twig_Function_Method($function[0], $function[1]));
			}
			else
			{
				$this->_engine->addFunction($name, new Twig_Function_Function($function));
			}
		}
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
		return $this->_engine->render($file.'.'.$this->_extension, $data);
	}

} // End Tpl_Twig
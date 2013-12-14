<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Fenom template engine driver. 
 * For get more info visit (project home page)[https://github.com/bzick/fenom/].
 *
 * @package    Tpl
 * @category   Driver
 * @author     Kohana Team
 * @copyright  (c) 2008-2013 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Tpl_Fenom extends Tpl_Native {

	/**
	 * Create instance of template engine.
	 * 
	 * @param   array  $config  Engine settings
	 * @return  void
	 */
	public function __construct(array $config)
	{
		parent::__construct($config);
		// Create engine instance
		$template_dir = array_shift($config['template_dir']);
		$this->_engine = Fenom::factory($template_dir, $config['compile_dir']);
		// Set engine options
		$this->_engine->setOptions($config['options']);
		// Set template dirs
		foreach ($config['template_dir'] as $dir)
		{
			$provider = new Fenom\Provider($dir);
			$this->_engine->addProvider($dir, $provider);
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
		return $this->_engine->fetch($file.'.'.$this->_extension, $data);
	}

} // End Tpl_Fenom
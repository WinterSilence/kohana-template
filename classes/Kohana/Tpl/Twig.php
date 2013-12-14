<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Twig template engine driver. 
 * For get more info visit (project home page)[http://twig.sensiolabs.org/documentation].
 *
 * @package    Tpl
 * @category   Driver
 * @author     Kohana Team
 * @copyright  (c) 2008-2013 Kohana Team
 * @license    http://kohanaframework.org/license
 */
abstract class Kohana_Tpl_Twig extends Tpl_Native {

	/**
	 * Create instance of template engine.
	 * 
	 * @param   array  $config  Engine settings
	 * @return  void
	 */
	public function __construct(array $config)
	{
		parent::__construct($config);
		$loader = new Twig_Loader_Filesystem($config['template_dir']);
		$this->_engine = new Twig_Environment($loader, $config['options']);
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
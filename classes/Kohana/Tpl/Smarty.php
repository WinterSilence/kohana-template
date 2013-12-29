<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Tpl driver for [Smarty template engine](http://smarty.net/docs/en/).
 *
 * @package    Tpl
 * @category   Driver
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2013 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
abstract class Kohana_Tpl_Smarty implements Kohana_Tpl_Interface {

	/**
	 * @var  string  extension of view file
	 */
	protected $_extension;

	/**
	 * @var  object  instance of template engine 
	 */
	protected $_engine;

	/**
	 * Create template engine instance.
	 * 
	 * @param   array  $config  engine options
	 * @return  void
	 */
	public function __construct(array $config)
	{
		$this->_extension = $config['extension'];
		// Create engine instance
		$class = Arr::get($config, 'class_name', 'Smarty');
		$this->_engine = new $class;
		// Set engine properties
		$config['options']['template_dir'] = $config['template_dir'];
		foreach ($config['options'] as $option => $value)
		{
			$this->_engine->$option = $value;
		}
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
		// Deleta all assigned variables
		$this->_engine->clearAllAssign();
		// Assign new variables
		$this->_engine->assign($data);
		// Returns the template output instead of displaying it
		return $this->_engine->fetch($file.'.'.$this->_extension);
	}

} // End Tpl_Smarty
<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Tpl driver for native template engine.
 *
 * @package    Tpl
 * @category   Driver
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2013 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
abstract class Kohana_Tpl_Native implements Kohana_Tpl_Interface {

	/**
	 * @var  string  extension of view file
	 */
	protected $_extension;

	/**
	 * Create driver for template engine.
	 * 
	 * @param   array  $config  engine settings
	 * @return  void
	 */
	public function __construct(array $config)
	{
		$this->_extension = $config['extension'];
	}

	/**
	 * Renders the view object to a string.
	 * 
	 * @param   string  $kohana_tpl_file  template file
	 * @param   array   $kohana_tpl_data  template variables 
	 * @return  string
	 */
	private function _render($kohana_tpl_file, array $kohana_tpl_data)
	{
		// Import the view variables to local namespace
		extract($kohana_tpl_data, EXTR_SKIP);
		// Capture the view output
		ob_start();
		try
		{
			// Load the view within the current scope
			include $kohana_tpl_file;
		}
		catch (Exception $e)
		{
			// Delete the output buffer
			ob_end_clean();
			// Re-throw the exception
			throw $e;
		}
		// Get the captured output and close the buffer
		return ob_get_clean();
	}

	/**
	 * Renders the template object to a string.
	 * 
	 * @param   string  $file  template file
	 * @param   array   $data  template variables
	 * @return  string
	 */
	public function render($file, array $data)
	{
		// Find template
		$path = Kohana::find_file('views', $file, $this->_extension);
		if ($path === NULL)
		{
			throw new View_Exception('The requested template :file.:ext could not be found', array(
				':file' => $file,
				':ext'  => $this->_extension
			));
		}
		return $this->_render($path, $data);
	}

} // End Tpl_Native
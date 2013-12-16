<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Abstract controller class for automatic templating.
 *
 * @package    Tpl
 * @category   Controller
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2013 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
abstract class Kohana_Controller_Tpl extends Controller {

	/**
	 * @var  string|Tpl  Frame template
	 */
	public $tpl_frame = 'frame';

	/**
	 * @var  string|Tpl  Theme template
	 */
	public $tpl_theme = 'themes/default';

	/**
	 * @var  string|Tpl  Page template
	 */
	public $tpl_page = NULL;

	/**
	 * @var  boolean  Auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * Loads the template [Tpl] object.
	 */
	public function before()
	{
		parent::before();

		if ($this->auto_render === TRUE)
		{
			// Auto generate page name
			if ($this->tpl_page === NULL)
			{
				$this->tpl_page = implode(DIRECTORY_SEPARATOR, array(
					$this->request->directory(), 
					$this->request->controller(), 
					$this->request->action()
				));
				$this->tpl_page = trim($this->tpl_page, DIRECTORY_SEPARATOR);
			}

			// Load the templates
			$this->tpl_page  = Tpl::factory($this->tpl_page);
			$this->tpl_theme = Tpl::factory($this->tpl_theme);
			$this->tpl_frame = Tpl::factory($this->tpl_frame);

			// Set basic variables
			$this->tpl_theme->content = $this->tpl_page;
			$this->tpl_frame->content = $this->tpl_theme;
		}
	}

	/**
	 * Assigns the template [Tpl] as the request response.
	 */
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			$this->response->body($this->tpl_frame->render());
		}

		parent::after();
	}

} // End Controller_Tpl
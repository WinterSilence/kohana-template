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
	 * @var  mixed  page title
	 */
	public $title = NULL;

	/**
	 * @var  string|Tpl  frame template
	 */
	public $tpl_frame = 'frames/default';

	/**
	 * @var  string|Tpl  theme template
	 */
	public $tpl_theme = 'themes/default';

	/**
	 * @var  string|Tpl  page template
	 */
	public $tpl_page = NULL;

	/**
	 * @var  boolean  auto render template
	 **/
	public $auto_render = TRUE;

	/**
	 * @var  boolean auto check browser cache
	 **/
	public $auto_cache = FALSE;

	/**
	 * Automatically executed before the controller action.
	 * 
	 * -  Checks the browser cache.
	 * - Loads the template [Tpl] objects: frame, theme, page.
	 * 
	 * @return  void
	 */
	public function before()
	{
		if ($this->auto_cache === TRUE AND Kohana::$caching === TRUE)
		{
			// Checks the browser cache using [Controller::check_cache].
			$this->check_cache(sha1($this->request->uri()));
		}

		if ($this->auto_render === TRUE)
		{
			if ($this->tpl_page === NULL)
			{
				// Generates the path to template 'page' using controller info from [Request].
				$this->tpl_page = implode(DIRECTORY_SEPARATOR, array(
					$this->request->directory(), 
					$this->request->controller(), 
					$this->request->action()
				));
				$this->tpl_page = trim($this->tpl_page, DIRECTORY_SEPARATOR);
			}

			if ($this->title === NULL)
			{
				// Generates the 'title' using template 'page'.
				$this->title = str_replace(DIRECTORY_SEPARATOR, ' - ', $this->tpl_page);
			}

			// Loads the templates.
			$this->tpl_page  = Tpl::factory($this->tpl_page);
			$this->tpl_theme = Tpl::factory($this->tpl_theme);
			$this->tpl_frame = Tpl::factory($this->tpl_frame);

			// Global assigns a 'title' by reference.
			Tpl::bind_global('title', $this->title);
		}

		parent::before();
	}

	/**
	 * Automatically executed after the controller action.
	 * 
	 * - Assigns the template 'frame' as the request [Response].
	 * 
	 * @return  void
	 */
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			// Includes the 'page' content into template 'theme'.
			$this->tpl_theme->content = $this->tpl_page->render();
			// Includes the 'theme' content into template 'frame'.
			$this->tpl_frame->content = $this->tpl_theme->render();
			// Sends the content of template 'frame' as response.
			$this->response->body($this->tpl_frame->render());
		}

		parent::after();
	}

} // End Controller_Tpl
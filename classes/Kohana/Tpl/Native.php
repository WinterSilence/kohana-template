<?php
/**
 * Tpl driver for native template engine.
 *
 * @package    Kohana\Template
 * @category   View
 * @author     WinterSilence <info@ensostudio.ru>
 * @copyright  2013-2020 © Enso studio
 * @license    MIT
 */
abstract class Kohana_Tpl_Native implements Kohana_Tpl_Adapter
{
	/**
	 * @var string extension of view file
	 */
	protected $extension;

	/**
	 * @inheritDoc
	 */
	public function __construct(array $config)
	{
		$this->extension = $config['extension'];
	}

	/**
	 * Rendering.
	 * 
	 * @param string $kohana_tpl_file template file
	 * @param array $kohana_tpl_data template variables 
	 * @return string
	 */
	protected static function capture(string $kohana_tpl_file, array $kohana_tpl_data): string
	{
		// import the view variables to local namespace
		extract($kohana_tpl_data, EXTR_SKIP);
		unset($kohana_tpl_data);
		// capture the view output
		ob_start();
		try {
			// load the view within the current scope
			include $kohana_tpl_file;
		} catch (Throwable $e) {
			// delete the output buffer
			ob_end_clean();
			// re-throw the exception
			throw new View_Exception(
				'Error render template :tpl', 
				[':tpl' => Debug::path($kohana_tpl_file)], 
				0, 
				$e
			);
		}
		// get the captured output and close the buffer
		return ob_get_clean();
	}

	/**
	 * @inheritDoc
	 */
	public function render(string $template, array $data): string
	{
		$file = Kohana::find_file('views', $template, $this->extension);
		if (! $file) {
			throw new View_Exception(
				'Template file :tpl.:ext not found.',
				[':tpl' => $template, ':ext' => $this->extension]
			);
		}
		return static::capture($file, $data);
	}
}

<?php
/**
 * Adapter for [Fenom template engine](https://github.com/fenom-template). 
 *
 * @package    Kohana\Template
 * @category   View
 * @author     WinterSilence <info@ensostudio.ru>
 * @copyright  2013-2020 © Enso studio
 * @license    MIT
 */
abstract class Kohana_Tpl_Fenom implements Kohana_Tpl_Interface
{
	/**
	 * @var Fenom\Extra Fenom instance
	 */
	protected $fenom;

	/**
	 * Creates new adapter.
	 * 
	 * @param array $config Configuration
	 * @return void
	 */
	public function __construct(array $config)
	{
		$provider = new Kohana_Tpl_Fenom_Provider($config['extension']);
		Fenom\Extra::$charset = $config['charset'];
		$this->fenom = Fenom\Extra::factory($provider, $config['cache_dir'], $config['options']);
		if ($config['smarty_support']) {
			$this->fenom->setSmartySupport();
		}
		if ($config['allowed_functions']) {
			$this->fenom->addAllowedFunctions($config['allowed_functions']);
		}
		foreach ($config['functions'] as $name => $callback) {
			$this->fenom->addFunctionSmart($name, $callback);
		}
		foreach ($config['modifiers'] as $name => $callback) {
			$this->fenom->addModifier($name, $callback);
		}
	}

	/**
	 * Returns rendered template.
	 * 
	 * @param string $template Template name
	 * @param array $data Template variables
	 * @return string
	 */
	public function render(string $template, array $data): string
	{
		return $this->fenom->fetch($template, $data);
	}

}

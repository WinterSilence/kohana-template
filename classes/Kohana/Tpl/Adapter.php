<?php
/**
 * Adapter for template engines.
 *
 * @package    Kohana\Template
 * @category   View
 * @author     WinterSilence <info@ensostudio.ru>
 * @copyright  2013-2020 © Enso studio
 * @license    MIT
 */
interface Kohana_Tpl_Adapter
{
	/**
	 * Creates new adapter.
	 * 
	 * @param array $config adapter/engine configuration
	 * @return void
	 */
	public function __construct(array $config);

	/**
	 * Returns rendered template.
	 * 
	 * @param string $template template name
	 * @param array $data template variables 
	 * @return string
	 */
	public function render(string $template, array $data): string;
}

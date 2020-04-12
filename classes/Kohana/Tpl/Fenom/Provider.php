<?php

use Fenom\ProviderInterface;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

/**
 * Fenom template provider for Kohana's cascading filesystem.
 *
 * @package    Kohana\Template
 * @category   View
 * @author     WinterSilence <info@ensostudio.ru>
 * @copyright  2013-2020 © Enso studio
 * @license    MIT
 */
class Kohana_Tpl_Fenom_Provider implements ProviderInterface
{
	/**
	 * @var string Template extension.
	 */
	protected $extension;
	
	/**
	 * Creates new instance.
	 * 
	 * @param string $extension Template extension
	 * @return void
	 */
	public function __construct(string $extension = 'tpl')
	{
		$this->extension = $extension;
	}
	
	/**
	 * Get template path.
	 * 
	 * @param   string  $tpl Template name
	 * @param   bool $throws Throws exception if file not exist?
	 * @return  string|null
	 * @throws  View_Exception Template not found
	 */
	public function getTemplatePath(string $tpl, bool $throws = true): ?string
	{
		$path = Kohana::find_file('views', $tpl, $this->extension);
		if ($throws && ! $path) {
			throw new View_Exception('Template :tpl not found', [':tpl' => $tpl]);
		}
		return $path ?: null;
	}
	

	/**
	 * Get last modified of template by name.
	 * 
	 * @param string $tpl Template name or path
	 * @return int
	 */
	public function getLastModified(string $tpl): int
	{
		$path = is_file($tpl) ? $tpl : $this->getTemplatePath($tpl);
		if (! Kohana::$caching) {
			clearstatcache(TRUE, $path);
		}
		return filemtime($path);
	}

	/**
	 * Get source and mtime of template by name.
	 * 
	 * @param string $tpl Template name
	 * @param int $time Last modified time, set by reference
	 * @return string
	 */
	public function getSource(string $tpl, int &$time): string 
	{
		$path = $this->getTemplatePath($tpl);
		$time = $this->getLastModified($path);
		return file_get_contents($tpl);
	}

	/**
	 * Get all templates of provider.
	 * 
	 * @return array
	 */
	public function getList(): array
	{
		$list = [];
		foreach (Kohana::include_paths() as $path) {
			$path .= 'views';
			if (! is_dir($path)) {
				continue;
			}
			$pathLen = strlen($path) + 1;
			$iterator = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator(
					$path,
					RecursiveDirectoryIterator::CURRENT_AS_FILEINFO | RecursiveDirectoryIterator::SKIP_DOTS
				),
				RecursiveIteratorIterator::CHILD_FIRST
			);
			/* @var \SplFileInfo $info */
			foreach ($iterator as $info) {
				if ($info->isFile() && $info->getExtension() == $this->extension) {
					$list[] = substr($info->getRealPath(), $pathLen);
				}
			}
		}
		return array_unique($list);
	}

	/**
	 * @param  string $tpl Template name
	 * @return  bool
	 */
	public function templateExists(string $tpl): bool
	{
		return (bool) $this->getTemplatePath($tpl, false);
	}

	/**
	 * Verify templates, check update time.
	 *
	 * @param  array $templates `[template => modified, ...]` By conversation, you may trust the template's name
	 * @return bool
	 */
	public function verify(array $templates): bool
	{
		foreach ($templates as $template => $mtime) {
			$path = $this->getTemplatePath($template, false);
			if (! $path) {
				return false;
			}
			if ($this->getLastModified($path) != $mtime) {
				return false;
			}
		}
		return true;
	}
}

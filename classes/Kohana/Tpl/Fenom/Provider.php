<?php defined('SYSPATH') OR die('No direct script access.');

use Fenom\ProviderInterface;

/**
 * Fenom template provider.
 *
 * @package    Tpl
 * @category   Fenom
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  2013 © handy-soft.ru
 * @license    MIT
 * @link       http://github.com/WinterSilence/kohana-tpl
 */
class Kohana_Tpl_Fenom_Provider implements ProviderInterface {

	/**
	 * @var  string  template extension
	 */
	private $_extension;

	/**
	 * Clean directory from files
	 *
	 * @param  string  $path
	 * @return void
	 */
	public function clean($path)
	{
		if (is_file($path))
		{
			unlink($path);
		}
		elseif (is_dir($path))
		{
			$iterator = iterator_to_array(
				new \RecursiveIteratorIterator(
					new \RecursiveDirectoryIterator($path,
						\FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS),
					\RecursiveIteratorIterator::CHILD_FIRST
				)
			);
			foreach ($iterator as $file)
			{
				/* @var \splFileInfo $file */
				if ($file->isFile())
				{
					if (strpos($file->getBasename(), '.') !== 0)
					{
						unlink($file->getRealPath());
					}
				}
				elseif ($file->isDir())
				{
					rmdir($file->getRealPath());
				}
			}
		}
	}

	/**
	 * Recursive remove directory
	 *
	 * @param string $path
	 * @return void
	 */
	public static function rm($path)
	{
		$this->clean($path);
		if (is_dir($path))
		{
			rmdir($path);
		}
	}

	/**
	 * 
	 * 
	 * @param   string  $extension  Template extension
	 * @return  void
	 * @throws  \LogicException  if directory doesn't exists
	 */
	public function __construct($extension = 'tpl')
	{
		$this->_extension = $extension;
	}

	/**
	 * Get source and mtime of template by name
	 * 
	 * @param  string   $tpl
	 * @param  integer  $time  Load last modified time
	 * @return string
	 */
	public function getSource($tpl, &$time)
	{
		$tpl = $this->_getTemplatePath($tpl);
		clearstatcache(TRUE, $tpl);
		$time = filemtime($tpl);
		return file_get_contents($tpl);
	}

	/**
	 * Get last modified of template by name
	 * 
	 * @param   string   $tpl
	 * @return  integer
	 */
	public function getLastModified($tpl)
	{
		$tpl = $this->_getTemplatePath($tpl);
		clearstatcache(TRUE, $tpl);
		return filemtime($tpl);
	}

	/**
	 * Get all names of templates from provider.
	 * 
	 * @return array|\Iterator
	 */
	public function getList()
	{
		$list = array();
		foreach (Kohana::include_paths() as $path)
		{
			$path .= 'views';
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($path,
					\FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS),
				\RecursiveIteratorIterator::CHILD_FIRST
			);
			$path_len = strlen($path);
			foreach ($iterator as $file)
			{
				/* @var \SplFileInfo $file */
				if ($file->isFile() AND $file->getExtension() === $this->_extension)
				{
					$list[] = substr($file->getPathname(), $path_len + 1);
				}
			}
		}
		return $list;
	}

	/**
	 * Get template path
	 * 
	 * @param   string  $tpl
	 * @return  string
	 * @throws  \RuntimeException
	 */
	protected function _getTemplatePath($tpl)
	{
		$path = Kohana::find_file('views', $tpl, $this->_extension);
		if ($path === NULL)
		{
			throw new \RuntimeException('Template {$tpl} not found');
		}
		return $path;
	}

	/**
	 * @param   string  $tpl
	 * @return  bool
	 */
	public function templateExists($tpl)
	{
		return (bool) Kohana::find_file('views', $tpl, $this->_extension);
	}

	/**
	 * Verify templates (check change time)
	 *
	 * @param  array  $templates [template_name => modified, ...] By conversation, you may trust the template's name
	 * @return bool
	 */
	public function verify(array $templates)
	{
		foreach ($templates as $tpl => $mtime)
		{
			$tpl = $this->_getTemplatePath($tpl);
			clearstatcache(TRUE, $tpl);
			if ( @filemtime($tpl) !== $mtime)
			{
				return FALSE;
			}
		}
		return TRUE;
	}
}
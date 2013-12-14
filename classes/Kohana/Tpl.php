<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Acts as an object wrapper for HTML pages with embedded PHP, called "views".
 * Variables can be assigned with the view object and referenced locally within
 * the view.
 *
 * @package    Tpl
 * @category   Base
 * @author     WinterSilence <info@handy-soft.ru>
 * @copyright  (c) 2013 handy-soft.ru
 * @license    MIT
 */
abstract class Kohana_Tpl {

	/**
	 * @var  string  Default driver
	 */
	public static $default = 'default';

	/**
	 * @var  array  Driver instances
	 */
	protected static $_drivers = array();

	/**
	 * @var  string  Current driver name
	 */
	protected $_driver = NULL;

	/**
	 * @var  string  Template filename
	 */
	protected $_filename = NULL;

	/**
	 * @var  array  Global variables
	 */
	protected static $_global_data = array();

	/**
	 * @var  array  Local variables
	 */
	protected $_data = array();

	/**
	 * Returns a new Tpl object. If you do not define the "file" parameter,
	 * you must call [Tpl::filename].
	 *
	 *     $view = Tpl::factory($file, $vars, 'native');
	 *
	 * @param   string  $file   Template filename
	 * @param   array   $data   Array of values
	 * @param   string  $group  Config group
	 * @return  $this
	 */
	public static function factory($file = NULL, array $data = array(), $group = NULL)
	{
		$class = get_called_class();
		return new $class($file, $data, $group);
	}

	/**
	 * Sets the initial view filename and local data. 
	 * 
	 * [!!] This method cannot be accessed directly, you must use [Tpl::factory].
	 *
	 * @param   string  $file   Template filename
	 * @param   array   $data   Array of values
	 * @param   string  $group  Config group
	 * @return  void
	 * @uses    Tpl::file
	 * @uses    Tpl::driver
	 */
	protected function __construct($file, array $data, $group)
	{
		// If there is no group supplied
		if ($group === NULL)
		{
			// Use the default setting
			$group = self::$default;
		}
		// Set template driver driver
		$this->driver($group);

		if ($file !== NULL)
		{
			// Set template file
			$this->filename($file);
		}

		if ($data !== NULL)
		{
			// Add the values to the current data
			$this->_data = $data + $this->_data;
		}
	}

	/**
	 * Sets or gets template driver driver. 
	 * 
	 *     $view->driver($driver);
	 *     $ext = $view->driver()->get_extension();
	 * 
	 * @param   string  $group  Driver configuration group
	 * @return  mixed
	 * @throws  View_Exception
	 
	 */
	public function driver($group = NULL)
	{
		// Get current driver
		if ($group === NULL)
		{
			return self::$_drivers[$this->_driver];
		}

		// Ignore the re-assignment of the driver
		if ($group === $this->_driver)
		{
			return $this;
		}

		if ( ! isset(self::$_drivers[$group]))
		{
			$config = Kohana::$config->load('tpl')->get($group);
			if ($config === NULL)
			{
				throw new View_Exception('Failed to load :class group: :group', array(
					':class' => get_class($this),
					':group' => $group
				));
			}

			// Set template directories
			$config['template_dir'] = Kohana::include_paths();
			foreach ($config['template_dir'] as $key => $path)
			{
				$path = $path.'views'.DIRECTORY_SEPARATOR;
				if (is_dir($path))
				{
					$config['template_dir'][$key] = $path;
				}
			}

			// Create a new type instance
			$class = 'Tpl_'.ucfirst($config['driver']);
			self::$_drivers[$group] = new $class($config);
		}

		// Set current driver
		$this->_driver = $group;

		return $this;
	}

	/**
	 * Captures the output that is generated when a view is included.
	 * The view data will be extracted to make local variables. This method
	 * is static to prevent object scope resolution.
	 *
	 *     $output = Tpl::capture($file, $data, $driver);
	 *
	 * @param   string  $file    filename
	 * @param   array   $data    variables
	 * @param   object  $driver  Driver of template driver
	 * @return  string
	 */
	protected static function capture($file, array $data = array(), $driver)
	{
		$data = array_replace(self::$_global_data, $data);
		return $driver->render($file, $data);
	}

	/**
	 * Sets a global variable, similar to [Tpl::set], except that the
	 * variable will be accessible to all views.
	 *
	 *     Tpl::set_global($name, $value);
	 *
	 * @param   string  $key    variable name or an array of variables
	 * @param   mixed   $value  value
	 * @return  void
	 */
	public static function set_global($key, $value = NULL)
	{
		if (Arr::is_array($key))
		{
			foreach ($key as $key2 => $value)
			{
				self::$_global_data[$key2] = $value;
			}
		}
		else
		{
			self::$_global_data[$key] = $value;
		}
	}

	/**
	 * Assigns a global variable by reference, similar to [Tpl::bind], except
	 * that the variable will be accessible to all views.
	 *
	 *     Tpl::bind_global($key, $value);
	 *
	 * @param   string  $key    variable name
	 * @param   mixed   $value  referenced variable
	 * @return  void
	 */
	public static function bind_global($key, & $value)
	{
		self::$_global_data[$key] =& $value;
	}

	/**
	 * Magic method, searches for the given variable and returns its value.
	 * Local variables will be returned before global variables.
	 *
	 *     $value = $view->foo;
	 *
	 * [!!] If the variable has not yet been set, an exception will be thrown.
	 *
	 * @param   string  $key    variable name
	 * @return  mixed
	 * @throws  View_Exception
	 */
	public function & __get($key)
	{
		if (array_key_exists($key, $this->_data))
		{
			return $this->_data[$key];
		}
		elseif (array_key_exists($key, self::$_global_data))
		{
			return self::$_global_data[$key];
		}

		throw new View_Exception(':class variable is not set: :var', array(':var' => $key));
	}

	/**
	 * Magic method, calls [Tpl::set] with the same parameters.
	 *
	 *     $view->foo = 'something';
	 *
	 * @param   string  $key    variable name
	 * @param   mixed   $value  value
	 * @return  void
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Magic method, determines if a variable is set.
	 *
	 *     isset($view->foo);
	 *
	 * [!!] `NULL` variables are not considered to be set by [isset](http://php.net/isset).
	 *
	 * @param   string  $key    variable name
	 * @return  boolean
	 */
	public function _isset($key)
	{
		return (isset($this->_data[$key]) OR isset(self::$_global_data[$key]));
	}

	/**
	 * Magic method, unsets a given variable.
	 *
	 *     unset($view->foo);
	 *
	 * @param   string  $key    variable name
	 * @return  void
	 */
	public function __unset($key)
	{
		unset($this->_data[$key], self::$_global_data[$key]);
	}

	/**
	 * Magic method, returns the output of [Tpl::render].
	 *
	 * @return  string
	 * @uses    Tpl::render
	 */
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			/**
			 * Display the exception message.
			 *
			 * We use this method here because it's impossible to throw and
			 * exception from __toString().
			 */
			$error_response = View_Exception::_handler($e);
			return $error_response->body();
		}
	}

	/**
	 * Sets or gets the template filename.
	 * 
	 *     $Tpl->filename($path);
	 *     // Get filename
	 *     $filename = $Tpl->filename();
	 *
	 * @param   string  $file  Template filename
	 * @return  $this
	 * @throws  View_Exception
	 */
	public function filename($file = NULL)
	{
		if ($file === NULL)
		{
			// Gets view filename
			return $this->_filename;
		}

		// Store the file path locally
		$this->_filename = (string) $file;

		return $this;
	}

	/**
	 * Delete all local and [optional]global variables.
	 *
	 *     // Full clear
	 *     $view->clear(TRUE);
	 *
	 * @param  bool  $clear_globals  Delete global data?
	 * @return $this
	 */
	public function clear($clear_globals = FALSE)
	{
		// Delete local data
		$this->_data = array();

		if ($clear_globals)
		{
			// Delete global data
			self::$_global_data = array();
		}

		return $this;
	}

	/**
	 * Assigns a variable by name. Assigned values will be available as a
	 * variable within the view file:
	 *
	 *     // This value can be accessed as $foo within the view
	 *     $view->set('foo', 'my value');
	 *
	 * You can also use an array to set several values at once:
	 *
	 *     // Create the values $food and $beverage in the view
	 *     $view->set(array('food' => 'bread', 'beverage' => 'water'));
	 *
	 * @param   string  $key    variable name or an array of variables
	 * @param   mixed   $value  value
	 * @return  $this
	 * @uses    Arr::is_array
	 */
	public function set($key, $value = NULL)
	{
		if (Arr::is_array($key))
		{
			foreach ($key as $name => $value)
			{
				$this->_data[$name] = $value;
			}
		}
		else
		{
			$this->_data[$key] = $value;
		}

		return $this;
	}

	/**
	 * Assigns a value by reference. The benefit of binding is that values can
	 * be altered without re-setting them. It is also possible to bind variables
	 * before they have values. Assigned values will be available as a
	 * variable within the view file:
	 *
	 *     // This reference can be accessed as $ref within the view
	 *     $view->bind('ref', $bar);
	 *
	 * @param   string  $key    variable name
	 * @param   mixed   $value  referenced variable
	 * @return  $this
	 */
	public function bind($key, & $value)
	{
		$this->_data[$key] =& $value;

		return $this;
	}

	/**
	 * Renders the view object to a string. Global and local data are merged
	 * and extracted to create local variables within the view file.
	 *
	 *     $output = $view->render();
	 *
	 * [!!] Global variables with the same key name as local variables will be
	 * overwritten by the local variable.
	 *
	 * @param   string  $file    view filename
	 * @param   string  $driver  template driver driver
	 * @param   bool    $clear   delete local variables after render?
	 * @return  string
	 * @throws  View_Exception
	 * @uses    self::capture
	 */
	public function render($file = NULL, $driver = NULL, $clear = FALSE)
	{
		if ($driver !== NULL)
		{
			// Set template engine driver
			$this->driver($driver);
		}

		if ($file !== NULL)
		{
			// Set template filename
			$this->filename($file);
		}
		if ($this->filename() == NULL)
		{
			throw new View_Exception('You must set the file to use within view before rendering');
		}

		// Combine local and global data and capture the output
		$result = self::capture($this->filename(), $this->_data, $this->driver());

		if ($clear)
		{
			// Delete local data
			$this->clear();
		}

		return $result;
	}

} // End Tpl
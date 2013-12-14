<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Template engine drivers configuration.
 * 
 * Basic config group:
 *   'native' => array(
 *     'driver'    => 'native', // Driver name
 *     'extension' => 'php',    // Extension of template file 
 *     'options'   => array(),  // Engine configururation
 *   ),
 */
return array(
	'default' => array(
		'driver'    => 'native',
		'extension' => 'php',
		'options'   => array(),
	),
	'smarty' => array(
		/**
		 * Smarty basic options.
		 * For get more info visit (project page)[http://www.smarty.net/docs/en/api.variables.tpl].
		 * 
		 * Type     Name            Description
		 * --------------------------------------------------------------------------------------------------
		 * string   class_name      Called class (Smarty - frontend, SmartyBC - backend).
		 * string   template_dir    Default template directory or directories.
		 * string   cache_dir       Directory where template caches are stored.
		 * string   compile_dir     Directory where compiled templates are located.
		 * string   config_dir      Directory or directories used to store config files used in the templates.
		 * boolean  caching         Caching enabled?
		 * integer  cache_lifetime  Cache lifetime in seconds.
		 * boolean  force_cache     Update cache templates on every invocation?
		 * boolean  force_compile   Update compile templates on every invocation?
		 * boolean  escape_html     Will escape all template variable output?
		 * boolean  debugging       Enables the debug-console?
		 */
		'driver'     => 'smarty',
		'extension'  => 'html',
		'class_name' => 'Smarty',
		'options'    => array(
			'config_dir'     => array(APPPATH.'config'),
			'cache_dir'      => Kohana::$cache_dir.'/smarty/cache/',
			'compile_dir'    => Kohana::$cache_dir.'/smarty/compile/',
			'caching'        => Kohana::$caching,
			'cache_lifetime' => Kohana::$cache_life,
			'force_cache'    => TRUE,
			'force_compile'  => TRUE,
			'escape_html'    => Kohana::$environment === Kohana::PRODUCTION,
			'debugging'      => Kohana::$errors,
		),
	),
	'fenom' => array(
		/**
		 * Fenom basic options.
		 * For get more info visit (project page)[https://github.com/bzick/fenom/].
		 * 
		 * Type     Name                  Description
		 * --------------------------------------------------------------------------------------------------
		 * boolean  disable_statics       Disable statics variables in the template.
		 * boolean  disable_cache         Not cache templates.
		 * boolean  disable_methods       Disable calling methods in templates.
		 * boolean  disable_native_funcs  Prohibit the use of PHP functions, except as permitted.
		 * array    allowed_funcs         Array of allowed functions name.
		 * boolean  auto_reload           Rebuild if the original template has been changed.
		 * boolean  force_compile         Recompile the template for each invocation.
		 * boolean  force_include         Optimize insert template in the template..
		 * boolean  force_verify          Check issued by each variable and return NULL if the variable does not exist.
		 * boolean  auto_escape           All output variables and function results will be escaped.
		 * boolean  auto_trim             At compile all whitespace between the tags will be deleted.
		 * string   template_dir          Default template directory.
		 * string   compile_dir           Directory where compiled templates are located.
		 */
		'driver'      => 'fenom',
		'extension'   => 'tpl',
		'compile_dir' => Kohana::$cache_dir.'/fenom/',
		'options'     => array(
			'disable_statics'      => FALSE,
			'disable_cache'        => ! Kohana::$caching,
			'disable_methods'      => FALSE,
			'disable_native_funcs' => FALSE,
			'auto_reload'          => TRUE,
			'force_compile'        => TRUE,
			'force_include'        => TRUE,
			'force_verify'         => TRUE,
			'auto_escape'          => Kohana::$environment === Kohana::PRODUCTION,
			'auto_trim'            => FALSE,
		),
	),
	'twig' => array(
		/**
		 * Twig basic options.
		 * For get more info visit (project page)[http://twig.sensiolabs.org/documentation].
		 * 
		 * Type     Name              Description
		 * --------------------------------------------------------------------------------------------------
		 * boolean  debug             Display the generated nodes (default to false).
		 * string   charset           The charset used by the templates (default to utf-8).
		 * boolean  auto_reload       Recompile the template whenever the source code changes.
		 * boolean  strict_variables  If set to false, will silently ignore invalid variables.
		 *                            When set to true,throws an exception instead (default to false).
		 * mixed    autoescape        Auto-escaping will be enabled by default for all templates (default to true).
		 * integer  optimizations     A flag that indicates which optimizations to apply (default to -1).
		 *                            
		 */
		'driver'    => 'twig',
		'extension' => 'twig',
		'options'   => array(
			'cache'            => Kohana::$cache_dir.'/twig/',
			'debug'            => Kohana::$errors,
			'charset'          => Kohana::$charset,
			'auto_reload'      => TRUE,
			'strict_variables' => FALSE,
			'autoescape'       => Kohana::$environment === Kohana::PRODUCTION,
			'optimizations'    => Twig_NodeVisitor_Optimizer::OPTIMIZE_ALL,
		),
	),
);
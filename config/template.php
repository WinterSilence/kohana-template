<?php
/**
 * Configuration for drivers of template engine.
 * Required options:
 *   'php' => [
 *     'adapter'   => 'Native', // Engine adapter class
 *     'extension' => 'php',    // Extension of template file 
 *     'options'   => [],       // Engine configururation
 *   ]
 */
return [
	'default' => [
		'adapter'   => 'native',
		'extension' => 'php',
		'options'   => [],
	],
	'smarty' => [
		/**
		 * [Smarty configuration](https://smarty.net/docs/en/api.variables.tpl)
		 * 
		 * Type    | Name           | Description
		 * ------- | ------------------------------------------------------------------------------------------
		 * string  | classname      | Called class (`Smarty` - frontend, `SmartyBC` - backend)
		 * string  | template_dir   | Default template directory or directories
		 * string  | cache_dir      | Directory where template caches are stored
		 * string  | compile_dir    | Directory where compiled templates are located
		 * string  | config_dir     | Directory or directories used to store config files used in the templates
		 * boolean | caching        | Caching enabled?
		 * integer | cache_lifetime | Cache lifetime in seconds
		 * boolean | force_cache    | Update cache templates on every invocation?
		 * boolean | force_compile  | Update compile templates on every invocation?
		 * boolean | escape_html    | Will escape all template variable output?
		 * boolean | debugging      | Enables the debug-console?
		 */
		'adapter'   => 'smarty',
		'extension' => 'tpl',
		'classname' => 'Smarty',
		'options'   => [
			'config_dir'     => [APPPATH.'config'],
			'cache_dir'      => KO7::$cache_dir.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'cache',
			'compile_dir'    => KO7::$cache_dir.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'compile',
			'caching'        => KO7::$caching,
			'cache_lifetime' => 300,
			'force_cache'    => TRUE,
			'force_compile'  => TRUE,
			'escape_html'    => KO7::$environment == KO7::PRODUCTION,
			'debugging'      => KO7::$errors,
		],
	],
	'twig' => [
		/**
		 * [Twig configuration](https://twig.symfony.com/doc/2.x/api.html#environment-options)
		 * 
		 * Type    | Name             | Description
		 * --------------------------------------------------------------------------------------------------
		 * boolean | debug            | Display the generated nodes (default to `FALSE`)
		 * string  | charset          | The charset used by the templates (default to `utf-8`)
		 * boolean | auto_reload      | Recompile the template whenever the source code changes
		 * boolean | strict_variables | If set to `FALSE`, will silently ignore invalid variables, else throws an exception instead
		 * mixed   | autoescape       | Auto-escaping will be enabled by default for all templates (default to `TRUE`)
		 * integer | optimizations    | A flag that indicates which optimizations to apply (default to `-1` - all optimizations, `0` - disable)
		 * array   | globals          | Global variables
		 * array   | filters          | Filters
		 * array   | functions        | Functions
		 */
		'adapter'   => 'twig',
		'extension' => 'twig',
		'options'   => [
			'cache'            => KO7::$cache_dir.DIRECTORY_SEPARATOR.'twig',
			'debug'            => KO7::$errors,
			'charset'          => KO7::$charset,
			'auto_reload'      => TRUE,
			'strict_variables' => KO7::$environment != KO7::PRODUCTION,
			'autoescape'       => KO7::$environment == KO7::PRODUCTION,
			'optimizations'    => -1,
		],
		'globals'   => [
			/*
			'KO7'   => new KO7,
			'I18n'  => new I18n,
			'URL'   => new URL,
			'HTML'  => new HTML,
			'Form'  => new Form,
			'Route' => new Route,
			*/
		],
		'filters'   => [],
		'functions' => [
			/*
			'__'   => '__',
			'i18n' => '__',
			*/
		],
	],
	'fenom' => [
		/**
		 * [Fenom configuration](https://github.com/fenom-template/fenom/blob/master/docs/en/configuration.md)
		 * 
		 * Type    | Name                 | Description
		 * --------------------------------------------------------------------------------------------------
		 * string  | compile_dir          | Directory where compiled templates are located
		 * boolean | disable_call         | Disable statics variables in the template
		 * boolean | disable_cache        | Not cache templates
		 * boolean | disable_methods      | Disable calling methods in templates
		 * boolean | disable_native_funcs | Prohibit the use of PHP functions, except as permitte
		 * boolean | auto_reload          | Rebuild if the original template has been changed
		 * boolean | force_compile        | Recompile the template for each invocation
		 * boolean | force_include        | Optimize insert template in the template
		 * boolean | force_verify         | Check issued by each variable and return `NULL` if not exists
		 * boolean | auto_escape          | All output variables and function results will be escaped
		 * boolean | strip                | Strip all whitespaces in templates
		 * array   | allowed_funcs        | Array of allowed functions name
		 */
		'adapter'     => 'fenom',
		'extension'   => 'tpl',
		'compile_dir' => KO7::$cache_dir.DIRECTORY_SEPARATOR.'fenom',
		'options'     => [
			'disable_call'         => FALSE,
			'disable_cache'        => ! KO7::$caching,
			'disable_methods'      => FALSE,
			'disable_native_funcs' => FALSE,
			'auto_reload'          => TRUE,
			'force_compile'        => KO7::$environment != KO7::PRODUCTION,
			'force_include'        => TRUE,
			'force_verify'         => FALSE,
			'auto_escape'          => KO7::$environment == KO7::PRODUCTION,
			'strip'                => TRUE,
		],
	],
];

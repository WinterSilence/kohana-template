<?php
/**
 * Configuration for adapters of template engines.
 * 
 * Required options:
 
 * ~~~php
 * 'native' => [
 *     'adapter'   => 'native', // adapter name
 *     'extension' => 'tpl',    // template extension
 *     'options'   => [],       // configururation of template engine
 * ],
 * ~~~
 */
return [
	'default' => [
		'driver'    => 'native',
		'extension' => 'php',
		'options'   => [
			'cache_dir' => Kohana::$cache_dir.'/tpl_native',
		],
	],
	'smarty' => [
		/**
		 * [Smarty configuration](http://smarty.net/docs/en/api.variables.tpl).
		 * 
		 * Type    | Name           | Description
		 * ------- | ------------------------------------------------------------------------------------------
		 * string  | class_name     | Called class (Smarty - frontend, SmartyBC - backend).
		 * string  | template_dir   | Default template directory or directories.
		 * string  | cache_dir      | Directory where template caches are stored.
		 * string  | compile_dir    | Directory where compiled templates are located.
		 * string  | config_dir     | Directory or directories used to store config files used in the templates.
		 * boolean | caching        | Caching enabled?
		 * integer | cache_lifetime | Cache lifetime in seconds.
		 * boolean | force_cache    | Update cache templates on every invocation?
		 * boolean | force_compile  | Update compile templates on every invocation?
		 * boolean | escape_html    | Will escape all template variable output?
		 * boolean | debugging      | Enables the debug-console?
		 */
		'driver'     => 'smarty',
		'extension'  => 'tpl',
		'class_name' => 'Smarty',
		'options'    => [
			'config_dir'     => [APPPATH.'config'],
			'cache_dir'      => Kohana::$cache_dir.'/tpl_smarty_cache',
			'compile_dir'    => Kohana::$cache_dir.'/tpl_smarty_compile',
			'caching'        => Kohana::$caching,
			'cache_lifetime' => Kohana::$cache_life,
			'force_cache'    => true,
			'force_compile'  => ! Kohana::$caching,
			'escape_html'    => false,
			'debugging'      => Kohana::$errors,
		],
	],
	'twig' => [
		/**
		 * [Twig](https://twig.symfony.com). configuration
		 * 
		 * Type    | Name             | Description
		 * --------------------------------------------------------------------------------------------------
		 * boolean | debug            | Display the generated nodes (default to FALSE).
		 * string  | charset          | The charset used by the templates (default to utf-8).
		 * boolean | auto_reload      | Recompile the template whenever the source code changes.
		 * boolean | strict_variables | If set to FALSE, will silently ignore invalid variables, else throws an exception instead.
		 * mixed   | autoescape       | Auto-escaping will be enabled by default for all templates (default to true).
		 * integer | optimizations    | A flag that indicates which optimizations to apply (default to -1).
		 * array   | globals          | Global variables.
		 * array   | filters          | Filters.
		 * array   | functions        | Functions.
		 */
		'driver'    => 'twig',
		'extension' => 'twig',
		'options'   => [
			'cache'            => Kohana::$cache_dir.'/tpl_twig',
			'debug'            => Kohana::$errors,
			'charset'          => Kohana::$charset,
			'auto_reload'      => true,
			'strict_variables' => false,
			'autoescape'       => false,
			'optimizations'    => Twig_NodeVisitor_Optimizer::OPTIMIZE_ALL,
		],
		'globals'   => [
			'Kohana' => new Kohana(),
			'I18n'   => new I18n(),
			'URL'    => new URL(),
			'HTML'   => new HTML(),
			'Form'   => new Form(),
			'Route'  => new Route(),
		],
		'filters'   => [],
		'functions' => [
			'__'   => '__',
			'i18n' => '__',
		],
	],
	'fenom' => [
		/**
		 * [Fenom configuration](http://github.com/bzick/fenom/).
		 * 
		 * Type    | Name                 | Description
		 * --------------------------------------------------------------------------------------------------
		 * boolean | disable_statics      | Disable statics variables in the template.
		 * boolean | disable_cache        | Not cache templates.
		 * boolean | disable_methods      | Disable calling methods in templates.
		 * boolean | disable_native_funcs | Prohibit the use of PHP functions, except as permitted.
		 * array   | allowed_funcs        | Array of allowed functions name.
		 * boolean | auto_reload          | Rebuild if the original template has been changed.
		 * boolean | force_compile        | Recompile the template for each invocation.
		 * boolean | force_include        | Optimize insert template in the template..
		 * boolean | force_verify         | Check issued by each variable and return NULL if the variable does not exist.
		 * boolean | auto_escape          | All output variables and function results will be escaped.
		 * boolean | auto_trim            | At compile all whitespace between the tags will be deleted.
		 * string  | template_dir         | Default template directory.
		 * string  | compile_dir          | Directory where compiled templates are located.
		 */
		'driver'      => 'fenom',
		'extension'   => 'tpl',
		'cache_dir'   => Kohana::$cache_dir.'/tpl_fenom',
		'options'     => [
			'disable_cache'        => ! Kohana::$caching,
			'auto_reload'          => true,
			'force_compile'        => ! Kohana::$caching,
			'force_include'        => true,
			'force_verify'         => true,
			'auto_escape'          => false,
			'auto_trim'            => false,
		],
	],
];

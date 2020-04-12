# Template module for Kohana/Koseven framework

Based on the Kohana [View](../kohana/mvc/views), has a number of additional methods.
Also, contains `Controller_Tpl` which is an improved version of `Controller_Template`.

## Adapters

- [Smarty](https://github.com/smarty-php/smarty)
- [Twig](http://twig.sensiolabs.org)
- [Fenom](https://github.com/fenom-template)

## Usage

Create instance:

~~~php
// Creates view using Smarty template engine
$smartyView = Tpl::factory('news/list', ['news' => $news], 'smarty');
// Creates view using Twig engine
$twigView = Tpl::factory('news/list', ['news' => $news], 'twig');
// Creates native PHP view
$view = Tpl::factory('news/list', ['news' => $news]);
~~~

Change default adapter:

~~~php
Tpl::$default = 'fenom';
~~~

Delete local variables:

~~~php
$view->clear();
~~~

Delete all variables:

~~~php
$view->clear(true);
~~~

## Kohana's helpers

### Smarty

Helpers occurs without any problems:
.
~~~smarty
<base href="{URL::base()}">
<title>{$title|default:''}</title>
<meta charset="{Kohana::$charset}">
~~~

### Twig

To use a helper is necessary to register them in `tpl.twig.globals`. Use a dot instead of a double colon for dividing the class and method:

~~~twig
<base href="{{ URL.base() }}">
<title>{{ title|default('') }}</title>
<meta charset="{{ Kohana.charset }}">
~~~

### Fenom

Similar to Smarty:

~~~smarty
<base href="{URL::base()}">
<title>{$title ?: ''}</title>
<meta charset="{Kohana::$charset}">
~~~

## Controller_Tpl

The controller uses 3 template nested:

- `$tpl_page` - Main page content. Varies depending on the controller and action [Optional]
- `$tpl_theme` - Theme-wrapper for the main content. Used to set the overall style page
- `$tpl_theme->content` - Contains `$tpl_page`
- `$tpl_frame` - Document skeleton, the main task of forming `head` section
- `$tpl_frame->content` - Contains `$tpl_theme`

This approach allows incrementally generate page content. It is necessary for the formation of convenient page head container 
and the convenience of connecting widgets/snippets in the theme/page.

If path to `$tpl_page` file not set, it automatically generated based on the controller and action:

~~~php
class Controller_News extends Controller_Tpl
{
	// $this->tpl_page = 'views/news/index.php'
	public function action_index()
	{
		// Add 5 latest news in template 'page' using ORM
		$this->tpl_page->news = ORM::factory('News')->find_latest(5);
		// Add menu in template 'theme' using  HMVC request
		$this->tpl_theme->menu = Request::factory('widget/menu')->execute();
		// Add auth block in template 'theme' using HMVC request
		$this->tpl_theme->auth = Request::factory('widget/auth')->execute();
		// Add styles in template 'frame'
		$this->tpl_frame->styles = ['bootstrap4', 'theme-red'];
	}
}
~~~

## License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

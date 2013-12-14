## Tpl(Template) module for Kohana framework 3.3

Based on the Kohana View, has a number of additional methods, supports popular template engines (Smarty, Twig, Fenom). 
Also contains Controller_Tpl, which is an improved version Kohana Controller_Template.

### Tpl view:
~~~
// Create view using Smarty template engine
$view_smarty = Tpl::factory('news/list', array('news' => $news), 'smarty');
// Create view using Twig engine
$view_twig = Tpl::factory('news/list', array('news' => $news), 'twig');
// Create native(PHP) view
$view_native = Tpl::factory('news/list', array('news' => $news));
~~~
~~~
// Change current engine driver
$view_native->driver('smarty');
// Change default engine driver
Tpl::$default = 'fenom';
~~~
~~~
// Delete local variables
$view_native->clear();
// Delete local and global variables
$view_native->clear(TRUE);
~~~
~~~
// Change template, change engine, render content, delete local variables
$content = $view_native->render($new_template, $new_engine, $clear_local);
~~~

### Controller_Tpl:

The controller uses 3 template nested:
- $tpl_page - Main page content. Varies depending on the controller and action[optional].
- $tpl_theme - Theme-wrapper for the main content. Used to set the overall style page.
- $tpl_theme->content - Contains $tpl_page.
- $tpl_frame - Document skeleton, the main task of forming `head` section.
- $tpl_frame->content - Contains $tpl_theme.

This approach allows incrementally generate page content. 
It is necessary for the formation of convenient page head container 
and the convenience of connecting widgets\snippets in the theme\page.

If path to $tpl_page file not set, it automatically generated based on the controller and action.
For example, Controller_News - action_index, $tpl_page = 'news/index'.

~~~
class Controller_News extends Controller_Tpl {

	// Frame template
	public $tpl_frame = 'frame';
	// Theme template
	public $tpl_theme = 'themes/default';
	// Page template.
	public $tpl_page = NULL;
	
	public function action_index()
	{
		// Send 5 latest news in page template
		$this->tpl_page->news = ORM::factory('News')->find_latest(5);
		// Send title and styles in frame template
		$this->tpl_frame->title = __('Latest news');
		$this->tpl_frame->styles = array('bootstrap.css', 'red-theme.css');
	}

}
~~~

###License:
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
<?php defined('SYSPATH') OR die('No direct script access.') ?>
<!DOCTYPE html>
<html lang="<?php echo I18n::lang() ?>">
	<head>
		<base href="<?php echo URL::base() ?>">
		<title><?php echo isset($title) ? $title : '' ?></title>
		
		<meta charset="<?php echo Kohana::$charset ?>">
		<meta name="description" content="<?php echo isset($description) ? $description : '' ?>">
		<meta name="keywords" content="<?php echo isset($keywords) ? $keywords : '' ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<?php echo HTML::style('http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css').PHP_EOL ?>
		<?php if (isset($styles))
			foreach ($styles as $style)
				echo HTML::style($style).PHP_EOL ?>
		
		<!--[if lt IE 9]>
		<?php echo HTML::script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js').PHP_EOL ?>
		<?php echo HTML::script('https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js').PHP_EOL ?>
		<![endif]-->
	</head>
	<body>
		<?php echo $content ?>
		
		<!-- Bootstrap core JavaScript -->
		<!-- Placed at the end of the document so the pages load faster -->
		<?php if (isset($scripts))
			foreach ($scripts as $script)
				echo HTML::script($script).PHP_EOL ?>
	</body>
</html>
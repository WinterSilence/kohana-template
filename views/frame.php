<?php defined('SYSPATH') OR die('No direct script access.')?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo I18n::lang() ?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?php echo I18n::lang() ?>"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?php echo I18n::lang() ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo I18n::lang() ?>"> <!--<![endif]-->
    <head>
        <base href="<?php echo URL::base() ?>">
        <title><?php echo isset($title) ? $title : '' ?></title>
        <meta name="description" content="<?php echo isset($description) ? $description : '' ?>">
        <meta name="keywords" content="<?php echo isset($keywords) ? $keywords : '' ?>">
        <meta charset="<?php echo Kohana::$charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/x-icon" href="<? echo URL::site('favicon.ico') ?>">

        <!-- Include CSS files -->
        <?php echo HTML::style('http://raw.github.com/necolas/normalize.css/master/normalize.css').PHP_EOL ?>
        <?php echo HTML::style('assets/css/main.css').PHP_EOL ?>
        
        <!-- Modernizr detects HTML5 and CSS3 features in the user’s browser. -->
        <?php echo HTML::script('http://raw.github.com/h5bp/html5-boilerplate/master/js/vendor/modernizr-2.7.1.min.js').PHP_EOL ?>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy"><?php echo __('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.') ?></p>
        <![endif]-->

        <!-- Page - Theme -->
        <?php echo $content.PHP_EOL ?>
        
        <!-- Include JavaScript files -->
        <?php echo HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js').PHP_EOL ?>
        <?php echo HTML::script('http://raw.github.com/h5bp/html5-boilerplate/master/js/plugins.js').PHP_EOL ?>
        <?php echo HTML::script('assets/js/main.js') ?>
        
        <!-- Google Analytics -->
        <?php if (isset($google_analytics_id)): ?>
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','<?php echo $google_analytics_id ?>');
            ga('send','pageview');
        </script>
        <?php endif ?>

    </body>
</html>
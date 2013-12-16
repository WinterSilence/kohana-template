<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{$lang}"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="{$lang}"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="{$lang}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{$lang}"> <!--<![endif]-->
    <head>
        {*<base href="{$url_base}">*}
        <title>{$title}</title>
        <meta name="description" content="{$description}">
        <meta name="keywords" content="{$keywords}">
        <meta charset="{$charset}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {*<link rel="icon" type="image/x-icon" href="{$URL->site('favicon.ico')}">*}

        <!-- Include CSS files -->
        {*{$HTML->style('http://raw.github.com/necolas/normalize.css/master/normalize.css')}*}
        {*{$HTML->style('assets/css/main.css')}*}
        
        <!-- Modernizr detects HTML5 and CSS3 features in the user’s browser. -->
        {*{$HTML->script('http://raw.github.com/h5bp/html5-boilerplate/master/js/vendor/modernizr-2.7.1.min.js')}*}
    </head>
    <body>
        <!--[if lt IE 7]>
            {*<p class="browsehappy">{$I18n->get('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.')}</p>*}
        <![endif]-->

        <!-- Page - Theme -->
        {$content}
        
        <!-- Include JavaScript files -->
        {*{$HTML->script('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js')}*}
        {*{$HTML->script('http://raw.github.com/h5bp/html5-boilerplate/master/js/plugins.js')}*}
        {*{$HTML->script('assets/js/main.js')}*}
        
        <!-- Google Analytics -->
        {if $google_analytics_id!}
        <script>
            {ignore}(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            {/ignore}ga('create','{$google_analytics_id}');
            ga('send','pageview');
        </script>
        {/if}
    </body>
</html>
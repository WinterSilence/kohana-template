<!DOCTYPE html>
<html lang="{I18n::lang()}">
    <head>
        {* <base href="{URL::base()}"> *}
        <title>{$meta.title}</title>
        <meta charset="{Kohana::$charset}">
        <meta name="description" content="{$meta.description}">
        <meta name="keywords" content="{$meta.keywords}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{URL::site('assets/img/favicon.ico')}" rel="icon" type="image/x-icon">

        <!-- Include CSS files -->
        {* HTML::style('assets/css/main.css') *}
    </head>
    <body>
        <!-- Main content -->
        <main>{$content->render()}</main>
        
        <!-- Include JavaScript files -->
        {* HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/latest/jquery.min.js') *}
        {* HTML::script('assets/js/main.js') *}
    </body>
</html>

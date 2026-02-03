<?php
// loaders/loader_laravel_sidebar_html.php
if (!function_exists('loader_option_laravel_sidebar_html'))
    {
    function loader_option_laravel_sidebar_html()
    {
        return get_option('laravel_sidebar_html', '', 'no');
    }
}
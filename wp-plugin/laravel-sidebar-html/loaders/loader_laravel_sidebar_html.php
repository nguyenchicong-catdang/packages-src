<?php
// loaders/loader_laravel_sidebar_html.php
if (!function_exists('loader_laravel_sidebar_html')) {
    function loader_laravel_sidebar_html() {
        $data_laravel_sidebar_html = get_option('laravel_sidebar_html', '');
    }
}
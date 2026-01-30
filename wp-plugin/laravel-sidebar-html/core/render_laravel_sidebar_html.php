<?php
// wp-plugin/laravel-sidebar-html/core/render_laravel_sidebar_html.php
if (!function_exists('render_laravel_sidebar_html')) {
    function render_laravel_sidebar_html()
    {
        $file_render = ROOT_PLUGIN . 'laravel-sidebar-html/views/laravel-sidebar-html.php';
        //echo "ROOT_PLUGIN: $ROOT_PLUGIN";
        //echo "--> file_render: $file_render";
        if (file_exists($file_render)) {
            require_once $file_render;
        } else {
            echo "Khong co: $file_render";
        }
    }
}
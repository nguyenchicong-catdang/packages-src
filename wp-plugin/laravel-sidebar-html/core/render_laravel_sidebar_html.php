<?php
// wp-plugin/laravel-sidebar-html/core/render_laravel_sidebar_html.php

// docment
if (!function_exists('render_laravel_sidebar_html_document')) {
    function render_laravel_sidebar_html_document() {
        $file_render = ROOT_PLUGIN . 'laravel-sidebar-html/views/laravel_sidebar_html_document.php';

        if (file_exists($file_render)) {
            require_once $file_render;
        } else {
            echo "Khong ton tai: $file_render";
        }
    }
}

// edit
if (!function_exists('render_laravel_sidebar_html_edit')) {
    function render_laravel_sidebar_html_edit()
    {
        $file_render = ROOT_PLUGIN . 'laravel-sidebar-html/views/laravel_sidebar_html_edit.php';
        //echo "ROOT_PLUGIN: $ROOT_PLUGIN";
        //echo "--> file_render: $file_render";
        if (file_exists($file_render)) {
            require_once $file_render;
        } else {
            echo "Khong ton tai: $file_render";
        }
    }
}
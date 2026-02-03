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
        $file_loader = ROOT_PLUGIN . 'laravel-sidebar-html/loaders/loader_option_laravel_sidebar_html.php';
        $file_render = ROOT_PLUGIN . 'laravel-sidebar-html/views/laravel_sidebar_html_edit.php';
        $data_laravel_sidebar_html = ''; // Khởi tạo mặc định
        // loader
        if (file_exists($file_loader)) {
            require_once $file_loader;
            if (function_exists('loader_option_laravel_sidebar_html')) {
                // Lấy dữ liệu từ hàm loader gán vào biến local
                $data_laravel_sidebar_html = loader_option_laravel_sidebar_html();
            }
        } else {
            echo "khong ton tai $file_loader";
        }
        //echo "ROOT_PLUGIN: $ROOT_PLUGIN";
        //echo "--> file_render: $file_render";
        if (file_exists($file_render)) {
            // Truyền biến vào dưới dạng mảng
            $view_data = [
                'data_laravel_sidebar_html' => $data_laravel_sidebar_html
            ];

            // Hàm này sẽ "biến" các key của mảng thành biến local
            extract($view_data, EXTR_SKIP);
            require_once $file_render;
        } else {
            echo "Khong ton tai: $file_render";
        }
    }
}
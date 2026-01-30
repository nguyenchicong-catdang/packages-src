<?php
// wp-plugin/laravel-sidebar-html/core/assets_laravel_sidebar_html.php

if (!function_exists('assets_laravel_sidebar_html')) {
    function assets_laravel_sidebar_html($hook)
    {
        //echo $hook;
        if ('toplevel_page_laravel-sidebar-html' !== $hook) {
            return;
        }

        // add main.css
        wp_enqueue_style(
            'assets_laravel_sidebar_html_css',
            ROOT_PLUGIN_URL . 'laravel-sidebar-html/views/css/main.css',
            array(),
            // dev
            time()
        );
        // add main.js
        wp_enqueue_script(
            'assets_laravel_sidebar_html_js',
            ROOT_PLUGIN_URL . 'laravel-sidebar-html/views/js/main.js',
            array(),
            // dev
            time(),
            true
        );
        // 2. Thêm filter để biến nó thành module
        add_filter('script_loader_tag', function ($tag, $handle, $src) {
            // Chỉ áp dụng cho đúng cái "handle" mà bạn đã đăng ký ở trên
            // echo $handle;
            if ('assets_laravel_sidebar_html_js' !== $handle) {
                return $tag;
            }

            // Thay đổi thẻ script thành type="module"
            $tag = '<script type="module" src="' . esc_url($src) . '" id="' . esc_attr($handle) . '"></script>';
            return $tag;
        }, 10, 3);

    }   

    add_action('admin_enqueue_scripts', 'assets_laravel_sidebar_html');
}

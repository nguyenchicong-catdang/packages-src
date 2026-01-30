<?php
/*
 * Plugin Name: LARAVEL SIDEBAR HTML
 */
// wp-plugin/laravel-sidebar-html/laravel-sidebar-html.php
if (!defined('ROOT_PLUGIN')) {
    // Định nghĩa hằng số trỏ tới thư mục chứa file này
    define('ROOT_PLUGIN', dirname(plugin_dir_path(__FILE__)) . '/');
}
if (!defined('ROOT_PLUGIN_URL')) {
    // Định nghĩa hằng số trỏ tới thư mục chứa file này
    define('ROOT_PLUGIN_URL', dirname(plugin_dir_url(__FILE__)) . '/');
}
if (!function_exists('laravel_sidebar_html')) {
    function laravel_sidebar_html() {
        add_menu_page(
            'Laravel Sidebar Html',
            'Laravel Sidebar Html',
            'manage_options',
            'laravel-sidebar-html', // Slug chính
            'render_laravel_sidebar_html',
            'dashicons-html',
        );
    }
    add_action('admin_menu', 'laravel_sidebar_html');
    //echo ROOT_PLUGIN;
    //echo ROOT_PLUGIN_URL;
    // core render views
    require_once ROOT_PLUGIN . "laravel-sidebar-html/core/render_laravel_sidebar_html.php";
    // core assets
    require_once ROOT_PLUGIN . "laravel-sidebar-html/core/assets_laravel_sidebar_html.php";
}



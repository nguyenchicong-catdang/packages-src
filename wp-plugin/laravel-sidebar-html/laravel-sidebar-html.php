<?php
/*
 * Plugin Name: LARAVEL SIDEBAR HTML
 */
if (!defined('ABSPATH')) exit; // Bảo mật: Không cho phép truy cập trực tiếp
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
    function laravel_sidebar_html()
    {
        $parent_slug = 'laravel-sidebar-html';
        $render_document = 'render_laravel_sidebar_html_document';
        // menu page    
        add_menu_page(
            'Laravel Sidebar Html',
            'Laravel Sidebar Html',
            'manage_options',
            // 'laravel-sidebar-html', // Slug chính
            $parent_slug,
            $render_document,
            'dashicons-html',
        );
        // submenu document
        add_submenu_page(
            $parent_slug,
            'Laravel Sidebar Html Document',
            'Laravel Sidebar Html Document',
            'manage_options',
            // 'laravel-sidebar-html-document',
            $parent_slug,
            $render_document
        );
        // submenu edit
        add_submenu_page(
            $parent_slug,
            'Laravel Sidebar Html Edit',
            'Laravel Sidebar Html Edit',
            'manage_options',
            'laravel-sidebar-html-edit',
            'render_laravel_sidebar_html_edit'
        );
    }

    // 1. Chỉ đăng ký Menu (Luôn cần thiết để hiện Menu Admin)
    add_action('admin_menu', 'laravel_sidebar_html');

    // 2. CHỈ nạp file xử lý POST khi dữ liệu đang được gửi lên
    // if (is_admin() && isset($_POST['action']) && $_POST['action'] === 'action_edit_laravel_sidebar_html') {
    //     require_once ROOT_PLUGIN . "laravel-sidebar-html/actions/admin_post_action_edit_laravel_sidebar_html.php";
    // }
    add_action('admin_post_action_edit_laravel_sidebar_html', function () {
        // 1. Chỉ khi người dùng nhấn "Update", dòng này mới chạy.
        // Các trang khác (Viết bài, Dashboard) sẽ hoàn toàn lờ đi file này.
        require_once ROOT_PLUGIN . "laravel-sidebar-html/actions/admin_post_action_edit_laravel_sidebar_html.php";

        // 2. Kiểm tra an toàn xem hàm xử lý có tồn tại trong file vừa nạp không.
        if (function_exists('action_edit_laravel_sidebar_html')) {
            action_edit_laravel_sidebar_html();
        }
    });

    // nạp file Render khi ở đúng trang của Plugin
    // require_once ROOT_PLUGIN . "laravel-sidebar-html/core/render_laravel_sidebar_html.php";

    // nạp file Assets (CSS/JS)
    // require_once ROOT_PLUGIN . "laravel-sidebar-html/core/assets_laravel_sidebar_html.php";
    // Chỉ nạp các file xử lý giao diện khi người dùng đang ở trong Admin Dashboard
    if (is_admin()) {
        // nạp file Render
        require_once ROOT_PLUGIN . "laravel-sidebar-html/core/render_laravel_sidebar_html.php";

        // nạp file Assets (CSS/JS)
        require_once ROOT_PLUGIN . "laravel-sidebar-html/core/assets_laravel_sidebar_html.php";
    }
}

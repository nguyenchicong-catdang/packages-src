<?php
// wp-app/wp-content/plugins/laravel-sidebar-html/actions/admin_post_save_laravel_sidebar_html.php

if (!function_exists('action_edit_laravel_sidebar_html')) {
    function action_edit_laravel_sidebar_html() {
        // https://developer.wordpress.org/reference/functions/wp_verify_nonce/
        // 1. Kiểm tra Nonce
        if (!isset($_POST['nonce_edit_laravel_sidebar_html']) || !wp_verify_nonce($_POST['nonce_edit_laravel_sidebar_html'], 'action_edit_laravel_sidebar_html')) {
            wp_die("Yêu cầu của bạn không hợp lệ.");
        }

        // 2. Kiểm tra quyền
        if (!current_user_can('manage_options')) {
            wp_die("Bạn không có quyền.");
        }

        // 3. Xử lý lưu dữ liệu
        if (isset($_POST['laravel_sidebar_html_content'])) {
            // Lưu vào bảng wp_options
            // Sử dụng wp_kses_post nếu bạn muốn cho phép một số thẻ HTML an toàn
            // update_option('laravel_sidebar_html', $_POST['laravel_sidebar_html_content']);

            $content = $_POST['laravel_sidebar_html_content'];
            // Gỡ bỏ các dấu gạch chéo dư thừa và lọc HTML
            $clean_content = wp_kses_post(stripslashes($content));
            update_option('laravel_sidebar_html', $clean_content,'no');
        }

        // 4. Redirect quay lại trang edit kèm tham số thông báo thành công
        wp_redirect(admin_url('admin.php?page=laravel-sidebar-html-edit&status=success'));
        exit; // Luôn có exit sau redirect
    }

    // add_action('admin_post_action_edit_laravel_sidebar_html', 'action_edit_laravel_sidebar_html');
}
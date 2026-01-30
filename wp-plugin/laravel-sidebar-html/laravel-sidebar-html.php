<?php
/*
 * Plugin Name: LARAVEL SIDEBAR HTML
 */

add_action('admin_menu', function() {
    add_menu_page(
        'Laravel Sidebar Html',
        'Laravel Sidebar Html',
        'manage_options',
        'laravel-sidebar-html', // Slug chính
        'render_render_laravel_sidebar_html',
        'dashicons-html',
        6
    );
});

function render_render_laravel_sidebar_html() {
    echo '<div class="wrap"><h1>Laravel Sidebar Content</h1>';
    
    // Nếu bạn muốn render Blade component từ Provider đã đăng ký:
    // echo view('wpcomp::index')->render(); 
    
    echo '</div>';
}
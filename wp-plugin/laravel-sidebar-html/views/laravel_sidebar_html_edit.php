<?php
// $data_laravel_sidebar_html = get_option('laravel_sidebar_html');
// Kiểm tra nếu trên URL có status=updated
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p><strong>Thành công!</strong> Dữ liệu sidebar đã được cập nhật.</p>';
    echo '</div>';
}
?>
<div id="rootLaravelSidebarHtmlEdit">
    <!-- show -->
    <?php require_once ROOT_PLUGIN . 'laravel-sidebar-html/views/edit/show_sidebar.php' ?>
    <!-- edit form -->
    <?php require_once ROOT_PLUGIN . 'laravel-sidebar-html/views/edit/edit_sidebar.php' ?>
</div>
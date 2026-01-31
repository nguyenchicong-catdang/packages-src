<?php
$data_laravel_sidebar_html = get_option('laravel_sidebar_html');
?>
<div id="rootLaravelSidebarHtmlEdit">
    <!-- show -->
    <?php require_once ROOT_PLUGIN . 'laravel-sidebar-html/views/edit/show_sidebar.php' ?>
    <!-- edit form -->
    <?php require_once ROOT_PLUGIN . 'laravel-sidebar-html/views/edit/edit_sidebar.php' ?>
</div>
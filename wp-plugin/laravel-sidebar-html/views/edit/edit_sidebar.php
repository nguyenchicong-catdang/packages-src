
<div id="editSidebar">
    <h3>Edit sidebar</h3>
    <form action="<?= admin_url('admin-post.php') ?>" method="POST">
        <?php wp_nonce_field('action_edit_laravel_sidebar_html', 'nonce_edit_laravel_sidebar_html'); ?>
        <input type="hidden" name="action" value="action_edit_laravel_sidebar_html">
        <textarea name="laravel_sidebar_html_content" cols="30" rows="10"><?= esc_textarea(trim($data_laravel_sidebar_html)) ?></textarea><br>
        <button type="submit">Update</button>
    </form>
</div>
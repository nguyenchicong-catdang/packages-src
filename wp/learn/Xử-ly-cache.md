## plugin

add_action('save_post', function($post_id, $post, $update) {
    // Chỉ chạy khi bài viết được đăng hoặc cập nhật (publish)
    if (wp_is_post_revision($post_id) || $post->post_status != 'publish') {
        return;
    }

    // Lấy slug của bài viết
    $slug = $post->post_name;

    // Gọi URL nội bộ của Laravel (dùng tham số để truyền ID và Slug)
    // Ví dụ: /internal/purge?id=123&slug=thung-rac-dap-lon
    $url = add_query_arg([
        'id'   => $post_id,
        'slug' => $slug,
        'secret' => 'your-secure-token-here' // Thêm một token để bảo mật
    ], env('APP_URL') . "/internal/purge-post");

    wp_remote_get($url, [
        'blocking'  => false, // Không đợi phản hồi, chạy ngầm để admin WP không bị chậm
        'timeout'   => 1,
        'sslverify' => false,
    ]);
}, 10, 3);


## route

> Route::get('/internal/purge-post', [InternalCacheController::class, 'purge']);

# code

public function purge(Request $request) 
{
    // Bảo mật: Chỉ cho phép server gọi hoặc kiểm tra token
    if ($request->get('secret') !== 'your-secure-token-here') {
        abort(403);
    }

    $id = $request->get('id');
    $slug = $request->get('slug');

    // 1. Xóa Cache dữ liệu thô (Redis) theo Slug
    Cache::forget("post_full_data:{$slug}");

    // 2. Xóa Cache ESI Item (HTML) theo Slug
    // LSCache::purgeTag("post_item_{$slug}");

    // 3. Xóa Cache Danh mục (Vì bài mới có thể làm thay đổi thứ tự Category)
    // Chúng ta lấy nhanh Category ID từ DB thông qua ID bài viết
    $catIds = DB::connection('corcel')
                ->table('term_relationships')
                ->where('object_id', $id)
                ->pluck('term_taxonomy_id');

    foreach ($catIds as $catId) {
        // Xóa cache trang 1 của Category (Nơi bài mới thường xuất hiện)
        Cache::forget("cat_{$catId}_page_1");
        // Hoặc xóa theo Tag nếu bạn dùng LSCache
        // LSCache::purgeTag("category_{$catId}");
    }

    return response()->json(['status' => 'success']);
}

## Code Plugin "Kích nổ" Cache từ xa
// 1. Tạo Menu trong WP-Admin
add_action('admin_menu', function() {
    add_menu_page('Laravel Cache', 'Laravel Cache', 'manage_options', 'laravel-cache', 'render_cache_page', 'dashicons-performance');
});

// 2. Giao diện trang điều khiển
function render_cache_page() {
    ?>
    <div class="wrap">
        <h1>Quản lý Cache Laravel (ESI & Redis)</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row">Nhập Slug hoặc ID</th>
                    <td><input type="text" name="target_id" placeholder="ví dụ: thung-rac-lon hoặc 123" class="regular-text"></td>
                </tr>
            </table>
            <?php submit_button('Xóa Cache Ngay lập tức'); ?>
        </form>

        <?php
        if (isset($_POST['target_id'])) {
            $target = sanitize_text_field($_POST['target_id']);
            
            // Gửi tín hiệu sang Laravel (dùng cơ chế non-blocking như bạn đã thích)
            $response = wp_remote_get(add_query_arg([
                'target' => $target,
                'secret' => 'your-secure-token'
            ], "http://laravel-app.test/internal/purge-manual"), [
                'blocking' => true, // Ở trang Admin thì để true để xem thông báo kết quả
            ]);

            if (!is_wp_error($response)) {
                echo '<div class="updated"><p>Tín hiệu đã gửi! Laravel đang xử lý...</p></div>';
            }
        }
        ?>
    </div>
    <?php
}

## Laravel Side: Xử lý "Đa năng"

public function purgeManual(Request $request) 
{
    $target = $request->get('target');
    
    // Kiểm tra nếu target là ID (số) hoặc Slug (chuỗi)
    $post = is_numeric($target) 
        ? Post::find($target) 
        : Post::where('post_name', $target)->first();

    if ($post) {
        // Gọi lại Service xử lý tập trung mà chúng ta đã xây dựng
        CacheService::purgePost($post->ID, $post->post_name);
        return "Đã xóa cache cho bài: " . $post->post_title;
    }

    return "Không tìm thấy bài viết phù hợp!";
}
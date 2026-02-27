# service

<?php

namespace Vendorpath\Wp\Categories\Loader;

use Vendorpath\Wp\Categories\Interface\CategoryLoaderInterface;
use Corcel\Model\Taxonomy;
use Corcel\Model\Post;

class CategoryLoader extends Taxonomy implements CategoryLoaderInterface
{
    public function getCategory(string $slug): array|object
    {
        // 1. Lấy thông tin Category trước
        $category = self::slug($slug)->firstOrFail();

        // 2. Truy vấn thẳng từ Model Post dựa trên Taxonomy ID
        // Cách này giúp select() hoạt động chính xác vì nó không bị vướng logic pivot của belongsToMany
        $paginator = Post::status('publish')
            ->whereHas('taxonomies', function ($q) use ($category) {
                // Chỉ định rõ bảng để tránh lỗi ambiguous
                // Lưu ý: Corcel mặc định dùng bảng 'term_relationships' làm pivot
                $q->where('term_relationships.term_taxonomy_id', $category->term_taxonomy_id);
            })
            ->select(['ID', 'post_name'])
            ->latest()
            ->paginate(2);

        return [
            'category' => $category,
            'paginator' => $paginator
        ];
    }
}

public function postItem($slug) 
{
    // Thử lấy dữ liệu đầy đủ từ Redis trước
    $postData = Cache::remember("post_full_data:{$slug}", 3600, function() use ($slug) {
        $post = Post::where('post_name', $slug)->status('publish')->first();
        if (!$post) return null;

        // Trả về mảng chứa những gì cần hiển thị ở danh sách (Thumbnail, Title, Excerpt)
        return [
            'title' => $post->post_title,
            'url' => url($post->post_name),
            'thumb' => $post->thumbnail, // Corcel tự xử lý lấy ảnh đại diện
            'excerpt' => $post->post_excerpt ?: Str::limit(strip_tags($post->post_content), 100),
        ];
    });

    if (!$postData) return '';

    return view('esi.single-post-item', ['post' => $postData]);
}


@foreach($paginator as $post)
    <x-esi 
        :url="route('esi.post.item', ['slug' => $post->post_name])" 
        :action="[\App\Http\Controllers\EsiController::class, 'postItem', ['slug' => $post->post_name]]" 
    />
@endforeach

add_action('save_post', function($post_id) {
    if (wp_is_post_revision($post_id)) return;

    // Gọi một URL nội bộ của Laravel để báo hiệu "Bài này vừa đổi, xóa cache đi"
    // Việc này giúp logic xóa cache nằm trọn vẹn ở phía Laravel
    wp_remote_get(env('APP_URL') . "/internal/purge-post/" . $post_id);
}, 10, 1);
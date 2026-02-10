<?php

namespace Vendorpath\Wp\Posts;

use Corcel\Model\Post;
use Corcel\Model\Meta\PostMeta;

class PostLoader extends Post
{
    protected $connection = 'wordpress';

    // Đổi tên append cho đồng nhất với hàm Getter bên dưới
    protected $appends = ['featured_src'];

    public function getPost($slug)
    {
        return self::status('publish')
            ->where('post_name', $slug)
            ->firstOrFail(); // Corcel mặc định đã load meta rất "lạ", đôi khi không cần with()
    }

    

    /**
     * Tầng 2: Accessor
     * Tên hàm: getFeaturedSrcAttribute -> truy cập bằng $post->featured_src
     */
    public function getFeaturedSrcAttribute()
    {
        // 1. Lấy thumbnail_id từ collection meta của Corcel (rất nhanh, không query thêm)
        $thumbnailId = $this->meta->_thumbnail_id;

        if (!$thumbnailId) {
            return null;
        }

        // 2. Query trực tiếp từ bảng PostMeta bằng đúng kết nối 'wordpress'
        // Chúng ta phải chỉ định rõ connection để tránh nó lấy connection mặc định của Laravel
        $meta = PostMeta::on($this->connection)
            ->where('post_id', $thumbnailId)
            ->where('meta_key', '_wp_attached_file')
            ->first();

        return $meta ? $meta->meta_value : null;
    }
}
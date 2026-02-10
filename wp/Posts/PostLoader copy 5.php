<?php

namespace Vendorpath\Wp\Posts;

use Corcel\Model\Post;
use Corcel\Model\Meta\PostMeta;

class PostLoader extends Post
{
    protected $connection = 'wordpress';
    protected $appends = ['featured_src'];

    

    public function getPost($slug)
    {
        return self::status('publish')
            ->where('post_name', $slug)
            ->with(['thumbnail']) // "Tối thượng": Load Post -> Load Ảnh -> Load toàn bộ Meta của ảnh
            ->firstOrFail();
    }

    public function getFeaturedSrcAttribute() // Sửa tên hàm cho đúng (Src chứ không phải Srcl)
    {
        // 1. Kiểm tra xem thumbnail meta có tồn tại không
        if (!$this->thumbnail) {
            return null;
        }

        // 2. Kiểm tra xem có tìm thấy bản ghi Attachment không
        $attachment = $this->thumbnail->attachment;
        if (!$attachment) {
            return null;
        }

        // 3. Trả về URL (Corcel sẽ tự lấy guid hoặc xử lý logic lấy URL cho bạn)
        $url = $attachment->url;
        return $url ?: '/uploads/no-image.jpg';
    }

    public function getFeaturedAltAttribute()
    {
        // 1. Kiểm tra xem thumbnail meta có tồn tại không
        if (!$this->thumbnail) {
            return null;
        }

        // 2. Kiểm tra xem có tìm thấy bản ghi Attachment không
        $attachment = $this->thumbnail->attachment;
        if (!$attachment) {
            return null;
        }

        // 3. Trả về URL (Corcel sẽ tự lấy guid hoặc xử lý logic lấy URL cho bạn)
        $alt = $attachment->alt;
        return $alt ?: $this->title;
    }
}
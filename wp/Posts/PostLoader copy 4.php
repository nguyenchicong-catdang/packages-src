<?php

namespace Vendorpath\Wp\Posts;

use Corcel\Model\Post;
use Corcel\Model\Attachment;

class PostLoader extends Post
{
    protected $connection = 'wordpress';
    protected $appends = ['featured_url'];

    /**
     * Tường minh tầng 1: Lấy Model Attachment thay vì chỉ lấy ID
     * Corcel đã có sẵn quan hệ 'thumbnail', nhưng ta viết lại cho đúng ý bạn.
     */
    public function featured()
    {
        // Ta mượn quan hệ 'thumbnail' của Corcel để lấy hẳn Model Attachment
        // Model này chứa TẤT CẢ meta của cái ảnh đó.
        return $this->thumbnail();
    }

    /**
     * Tường minh tầng 2: Truy cập dữ liệu như một Collection
     */
    public function getFeaturedUrlAttribute()
    {
        // $this->featured bây giờ là một Object của class Attachment
        // Attachment trong Corcel đã tự nạp toàn bộ meta của nó vào collection rồi.
        if (!$this->featured) {
            return null;
        }

        // Lấy cực nhanh từ bộ nhớ (không query thêm)
        return $this->featured->meta->_wp_attached_file;
    }

    public function getPost($slug)
    {
        return self::status('publish')
            ->where('post_name', $slug)
            ->with(['featured.meta']) // "Tối thượng": Load Post -> Load Ảnh -> Load toàn bộ Meta của ảnh
            ->firstOrFail();
    }
}
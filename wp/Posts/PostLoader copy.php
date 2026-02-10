<?php
// Posts/PostLoader.php
namespace Vendorpath\Wp\Posts;

use Corcel\Model\Post;

class PostLoader extends Post
{
    protected $connection = 'wordpress';

    public function getPost($slug)
    {
        // firstOrFail    
        //return self::status('publish')->firstOrFail($slug);
        // return self::status('publish')
        //     ->where('post_name', $slug) // WordPress lưu slug ở cột post_name
        //     // ->with(['thumbnail'])
        //     ->with(['meta', 'thumbnail', 'thumbnail.attachment']) // Eager load ở đây
        //     ->firstOrFail();

        return self::status('publish')
            ->where('post_name', $slug)
            // Chỉ load meta, vì thumbnail thực chất là ID trong meta
            // ->with(['meta'])
            ->firstOrFail();
    }

    // Accessor cho URL ảnh
    public function getFeaturedImageUrlAttribute()
    {
        return $this->thumbnail?->attachment?->url ?? asset('uploads/no-image.png');
    }

    // Accessor cho Alt text
    public function getFeaturedImageAltAttribute()
    {
        return $this->thumbnail?->attachment?->alt ?? $this->post_title;
    }
}
<?php
// Posts/PostLoader.php
namespace Vendorpath\Wp\Posts;

use Corcel\Model\Post;

class PostLoader extends Post
{
    protected $connection = 'wordpress';

    // Thiết lập quan hệ với Yoast
    // public function yoast()
    // {
    //     // object_id trong Yoast chính là ID của Post
    //     return $this->hasOne(YoastIndexable::class, 'object_id', 'ID');
    // }

    public function getPost($slug)
    {
        return self::status('publish')
            ->where('post_name', $slug)
            // ->with(['yoast']) // Eager load Yoast ngay tại đây!
            ->firstOrFail();
    }

    // Accessor sử dụng quan hệ đã load
    // public function getYoastSchemaJsonAttribute()
    // {
    //     $indexable = $this->yoast; // Lấy dữ liệu từ relation đã eager load

    //     if (!$indexable) return null;

    //     $imageMeta = json_decode($indexable->open_graph_image_meta, true);

    //     $schema = [
    //         "@context" => "https://schema.org",
    //         "@graph" => [
    //             [
    //                 "@type" => "Article",
    //                 "@id" => $indexable->permalink . "#article",
    //                 "headline" => $indexable->title ?: $this->post_title,
    //                 "description" => $indexable->description,
    //                 // ... các logic khác y như cũ ...
    //             ]
    //         ]
    //     ];

    //     return json_encode(
    //         $schema,
    //         JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    //     );
    // }
}
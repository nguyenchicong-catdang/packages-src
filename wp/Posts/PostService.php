<?php
// Posts/PostService.php
namespace Vendorpath\Wp\Posts;

class PostService
{
    public function toArray($slug)
    {
        $data = app(PostLoader::class)->getPost($slug);
        return [
            'title' => $data?->title,
            'content' => $data?->content,
            'excerpt' => $data?->excerpt,
            'thumbnail_src' => $data?->thumbnail->url,
            'thumbnail_alt' =>$data?->thumbnail->alt
        ];
    }
}
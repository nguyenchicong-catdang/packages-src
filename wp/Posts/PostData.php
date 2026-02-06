<?php
// Dùng Data Transfer Object (DTO)
namespace Vendorpath\Wp\Posts;

class PostData
{
    public function __construct(
        public string $title,
        public string $url,
        public string $thumb,
        // ...
    ) {}

    public static function fromModel($post)
    {
        return new self(
            title: $post->title,
            url: url($post->slug),
            thumb: $post->thumbnail?->attachment?->url ?? asset('no-image.png')
        );
    }
}

// return PostData::fromModel($post)
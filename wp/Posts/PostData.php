<?php
// Dùng Data Transfer Object (DTO)
namespace Vendorpath\Wp\Posts;

class PostData
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $excerpt,
        public readonly string $content,
        public readonly string $featured_src,
        public readonly string $featured_alt,
        // ...
    ) {}

    public static function fromModel($post)
    {
        $repeat = [
            'title' => (string) data_get($post, 'title', 'UnTitle'),
            'featured_src' => (string) data_get($post, 'thumbnail.attachment.url', '/uploads/no-image.png'),
            'post' => $post
        ];
        return new self(
            title: (string) $repeat['title'],
            slug: (string) data_get($post, 'slug', ''),
            excerpt: (string) data_get($post, 'excerpt', ''),
            content: (string) data_get($post, 'content', ''),
            featured_src: (string) $repeat['featured_src'],
            featured_alt: (string) (string) data_get($post, 'thumbnail.attachment.url', (string) $repeat['title'])
        );
    }
}

// return PostData::fromModel($post)
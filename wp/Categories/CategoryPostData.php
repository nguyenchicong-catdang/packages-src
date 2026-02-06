<?php
// Categories/CategoryPostData.php
namespace Vendorpath\Wp\Categories;

class CategoryPostData
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $excerpt,
        public readonly string $date,
        public readonly string $featured_image_url,
        public readonly string $featured_image_alt
    ) {}

    public static function fromModel($post): self
    {
        return new self(
            title: (string) $post->title,
            slug: (string) $post->slug,
            excerpt: (string) $post->excerpt,
            date: (string) $post->post_date->format('d M, Y') ?: 'N/A',
            featured_image_url: (string) $post->thumbnail?->attachment?->url ?: '/uploads/no-image.png',
            featured_image_alt: (string) $post->thumbnail?->attachment?->alt ?: (string) $post->title
        );
    }
}
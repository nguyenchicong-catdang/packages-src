<?php
// Categories/DTO/CatPostsDTO.php
namespace Vendorpath\Wp\Categories\DTO;


class CatPostsDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $slug,
        public readonly string $excerpt,
        public readonly object $thumbnail,
    ) {}

    public static function DTO(object|array $post): self
    {
        // dd($post->thumbnail);
        return new self(
            id: $post->id ?? 0,
            title: $post->title ?? '',
            slug: $post->slug ?? '',
            excerpt: $post->excerpt ?? '',
            thumbnail: CatPostThumbnailDTO::DTO($post->thumbnail),
        );
    }
}
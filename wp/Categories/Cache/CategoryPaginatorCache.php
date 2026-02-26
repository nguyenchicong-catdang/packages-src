<?php
//Categories/Cache/CategoryPaginatorCache.php
namespace VendorPath\Wp\Categories\Cache;

class CategoryPaginatorCache
{
    public static function cache(object|array $lengthAwarePaginator): array
    {
        // Illuminate\Pagination\LengthAwarePaginator
        // dd($lengthAwarePaginator);
        return self::DTO($lengthAwarePaginator);
    }

    private static function DTO($paginator): array
    {
        // dd($paginator->items());
        return [
            'currentPage' => $paginator->currentPage(),
            'lastPage' => $paginator->lastPage(),
            'perPage' => $paginator->perPage(),
            'total' => $paginator->total(),
            'items' => self::itemsDTO($paginator->items()),
        ];
    }

    private static function itemsDTO($items): array
    {
        return  array_map(function ($post) {
            // dd($post?->thumbnail?->attachment);
            return [
                'id'    => $post?->ID ?? null,
                'title' => $post?->post_title ?? null,
                'excerpt' => $post?->post_excerpt ?? null,
                'slug' => $post?->post_name ?? null,
                'thumbnail' => [
                    'url' => $post?->thumbnail?->attachment?->url ?? null,
                    'metadata' => $post?->thumbnail?->attachment?->meta?->_wp_attachment_metadata ?? null,
                    'alt' => $post?->thumbnail?->attachment?->alt ?? null,
                ],
            ];
        }, $items);
    }
}

<?php
namespace Vendorpath\Wp\Categories;

class CategoryCacheArray
{
    public static function cache(object|array $loader): array
    {
        // dd($loader);
        return [
            'category' => Cache\CategoryCache::cache($loader['category'] ?? []),
            'paginator' => Cache\CategoryPaginatorCache::cache($loader['paginator'] ?? []),
        ];
    }
}
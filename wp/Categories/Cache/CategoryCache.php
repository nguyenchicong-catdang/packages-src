<?php
namespace VendorPath\Wp\Categories\Cache;

class CategoryCache
{
   public static function cache(object|array $category): array
   {
    // dd($cat);
    return self::DTO($category);
   }

   private static function DTO($category): array
   {
    return [
        'id' => $category?->term_id,
        'description' => $category?->description,
        'name' => $category?->term?->name,
        'slug' => $category?->term?->slug,
    ];
   }
}
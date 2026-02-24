<?php
namespace Vendorpath\Wp\Categories\DTO;

class CatPosts extends \Vendorpath\Wp\Abstract\BaseDTO
{
    protected static function map(object|array $data): array
    {
        return [
            'id' => (int) data_get($data, 'ID'),
            'title' => (string) data_get($data, 'post_title'),
            'excerpt' => (string) data_get($data, 'post_excerpt'),
            'slug' => (string) data_get($data, 'post_name'),
            'featured_image_src' => (string) data_get($data, 'thumbnail.attachment.url'),
            'featured_image_alt' => (string) data_get($data, 'thumbnail.attachment.alt'),
        ];
    }
}
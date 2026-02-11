<?php
namespace Vendorpath\Wp\Categories;
use Vendorpath\Wp\Abstract\BaseDTO;
class CategoryData extends BaseDTO
{
    public function __construct(
        public readonly object $dev,
        public readonly array $cat_data,
    ) {}

    protected static function map(object|array $data): array
    {
        $cat = data_get($data, 'category', []);
        $posts = data_get($data, 'posts', []);
        $repeat = [
            'cat' => $cat,
            'posts' => $posts,
        ];
        return [
            'dev' => (object) $data,
            'cat_data' => (array) self::cat_data($repeat['cat']),
        ];
    }

    public static function cat_data($cat): array
    {
        return [
            'name' => (string) data_get($cat, 'term.name'),
            'description' => (string) data_get($cat, 'description') ?: 'Admin nhập liệu vào đây...',
        ];
    }
}
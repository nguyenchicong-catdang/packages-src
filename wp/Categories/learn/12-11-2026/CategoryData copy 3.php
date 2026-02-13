<?php
namespace Vendorpath\Wp\Categories;
use Vendorpath\Wp\Abstract\BaseDTO;
class CategoryData extends BaseDTO
{
    public function __construct(
        public readonly object $dev,
        // public readonly object $cat_data,
        public readonly object $cat_data_item,
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
            // 'cat_data' => self::cat_data($repeat['cat']),
            'cat_data_item' => self::cat_fun_item($repeat['cat']),
        ];
    }

    // Hàm này chuyên trách việc "Làm phẳng" - Đúng ý bạn muốn DTO quản lý logic này
    public static function prepare(array|object $data): array
    {
        $cat = data_get($data, 'category');
        $posts = data_get($data, 'posts', []);

        // Trả về mảng phẳng - cực nhẹ để Cache
        return [
            'id'          => $cat->term_id,
            'name'        => (string) data_get($cat, 'name'),
            'description' => (string) data_get($cat, 'description') ?: 'Default...',
            'seo_title'   => (string) $cat->meta?->rank_math_title ?: $cat->name,
            'posts'       => array_map(fn($p) => [
                'title' => $p->post_title,
                // 'url'   => get_permalink($p->ID)
            ], (array) $posts)
        ];
    }

    public static function cat_fun_item($cat): array|object
    {
        return DTO\CategoryDataItemCat::fromLoader($cat);
    }

    // public static function cat_data($cat): array|object
    // {
    //     return (object) [
    //         'name' => (string) data_get($cat, 'term.name'),
    //         'description' => (string) data_get($cat, 'description') ?: 'Admin nhập liệu vào đây...',
    //     ];
    // }
}
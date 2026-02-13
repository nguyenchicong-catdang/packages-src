<?php
// Categories/CategoryData.php
namespace Vendorpath\Wp\Categories;

use Vendorpath\Wp\Abstract\BaseDTO;

class CategoryData extends BaseDTO
{
    public function __construct(
        public readonly object $dev,
        public readonly array $category,
        public readonly array $posts,
    ) {}
    

    protected static function map(object|array $data): array
    {
        $isFlat = is_array(data_get($data,'category'));
        if (!$isFlat) {
            // sau dev comment bien $data
            $data = static::prepare($data);
        }
        
        return [
            // sau dev comment bien $data
            'dev' => $data,
            'category' => $data['category'],
            'posts' => $data['posts'],
        ];
    }

    public static function prepare(array|object $data): array
    {
        $cat = data_get($data, 'category');
        $posts = data_get($data, 'posts', []);
        return [
            'category' => [
                'name' => (string) data_get($cat, 'term.name'),
                'description' => (string) data_get($cat, 'description') ?: 'Admin nhập liệu vào đây...',
            ],
            'posts' => $posts->getCollection()->map(fn($post) => [
                'title' => (string) $post->title,
                'excerpt' => (string) $post->excerpt,
                'link' => (string) $post->link,
            ]),
        ];
    }
}
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
        // Bước 1: Kiểm tra trạng thái dữ liệu
        // $isObject = is_object($data);

        // Bước 2: Chuẩn hóa dữ liệu về mảng phẳng (Nếu chưa phẳng)
        // $flattened = $isObject ? static::prepare($data) : $data;

        // Bước 3: Trả về cấu trúc đồng nhất
        return [
            // Nếu là Object thì giữ nguyên Object làm dev (để soi quan hệ, methods...)
            // Nếu là Array (từ cache) thì dùng chính nó làm dev (soi dữ liệu đã lọc)
            // 'dev'      => $isObject ? $data : (object) $flattened,
            // 'dev' => $isObject
            //     ? static::dev($data) // Đây là Object xịn từ DB
            //     : (object) [
            //         'message' => 'Dữ liệu này lấy từ CACHE nên đã bị làm phẳng!',
            //         'raw' => $data
            //     ],
            // 'dev'      => $data['dev'],
            'category' => $data['category'],
            'posts'    => $data['posts'],
        ];
    }

    public static function dev(array|object $data)
    {
        $mappedData = self::map($data); // Hứng kết quả từ map

        // Gộp mảng từ map với mảng chứa key dev
        return array_merge($mappedData, [
            'dev' => $data
        ]);
    }

    public static function prepare(array|object $data): array
    {
        $cat = data_get($data, 'category');
        $postsPaginator = data_get($data, 'posts'); // Đây là đối tượng LengthAwarePaginator

        return [
            'dev' => $data,
            'category' => [
                'name' => (string) data_get($cat, 'term.name'),
                'description' => (string) data_get($cat, 'description') ?: 'Admin nhập liệu...',
            ],
            'posts' => $postsPaginator->getCollection()->map(fn($post) => [
                'title' => (string) $post->post_title,
                'excerpt' => (string) $post->post_excerpt,
                'link' => (string) $post->url,
            ])->toArray(),
            // PHẢI CÓ CÁI NÀY ĐỂ VẼ PHÂN TRANG
            'pagination_meta' => [
                'total' => $postsPaginator->total(),
                'per_page' => $postsPaginator->perPage(),
                'current_page' => $postsPaginator->currentPage(),
            ]
        ];
    }
}
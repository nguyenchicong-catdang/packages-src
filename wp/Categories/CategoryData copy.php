<?php
// Categories/CategoryData.php
namespace Vendorpath\Wp\Categories;

use Vendorpath\Wp\Abstract\BaseDTO;

class CategoryData extends BaseDTO
{
    public function __construct(
        public readonly object $dev,
    ) {}
    

    protected static function map(object|array $data): array
    {
        // Lấy dữ liệu từ Rank Math hoặc nguồn nào đó
        $cat = data_get($data, 'category', []);
        $posts = data_get($data, 'posts', []);
        
        return [
            'dev' => $data['dev'],
        ];
    }

    public static function prepare(array|object $data): array
    {
        $cat = data_get($data, 'category');
        $posts = data_get($data, 'posts', []);
        return [
            'dev' => $data
        ];
    }
}
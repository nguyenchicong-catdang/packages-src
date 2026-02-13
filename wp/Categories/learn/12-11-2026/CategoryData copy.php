<?php
namespace Vendorpath\Wp\Categories;
use Vendorpath\Wp\Abstract\BaseDTO;
class CategoryData extends BaseDTO
{
    public function __construct(
        public readonly string $description
    ) {}

    // public static function fromLoader(object $cat): self
    // {
    //     return new self(
    //         title: (string) data_get($cat, 'name'),
    //     );
    // }

    protected static function map(object|array $cat): array
    {
        return [
            // Nếu object WordPress trả về 'cat_name' thay vì 'name'
            // 'description' => $cat->description ?? '',
            'description' => (string) data_get($cat, 'description', ''),
        ];
    }

    // protected static function map(object|array $cat): array
    // {
    //     // Đảm bảo $cat là object để dùng -> hoặc ép về array tùy ý
    //     $catObj = (object) $cat;
    //     return [
    //         'description' => $catObj->description ?? '',
    //     ];
    // }
}
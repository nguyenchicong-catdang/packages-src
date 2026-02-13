<?php
namespace Vendorpath\Wp\Categories\DTO;

class CategoryDataItemCat extends \Vendorpath\Wp\Abstract\BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
    ) {}

    protected static function map(object|array $data): array
    {
        return [
            'name' => (string) data_get($data, 'term.name'),
            'description' => (string) data_get($data, 'description') ?: 'Admin nhập liệu vào đây...',
        ];
    }
}
<?php
namespace Vendorpath\Wp\Categories\DTO;

class CatCard extends \Vendorpath\Wp\Abstract\BaseDTO
{
    protected static function map(object|array $data): array
    {
        return [
            'name' => (string) data_get($data, 'category.name'),
            'description' => (string) data_get($data, 'category.description') ?: 'Admin nhập liệu vào đây...',
        ];
    }
}
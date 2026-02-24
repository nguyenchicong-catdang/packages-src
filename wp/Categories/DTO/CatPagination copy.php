<?php
namespace Vendorpath\Wp\Categories\DTO;

class CatPagination extends \Vendorpath\Wp\Abstract\BaseDTO
{
    protected static function map(object|array $data): array
    {
        return [
            // 'data' => $data,
            'current_page' => (int) data_get($data, 'current_page'),
            'last_page' => (int) data_get($data, 'last_page'),
            'per_page' => (int) data_get($data, 'per_page'),
            'total' => (int) data_get($data, 'total'),
        ];
    }
}
<?php

namespace Vendorpath\Wp\Categories\DTO;

class CatPagination extends \Vendorpath\Wp\Abstract\BaseDTO
{
    protected static function map(object|array $data): array
    {
        // Kiểm tra nếu là Object Paginator thì dùng method, nếu là array thì dùng data_get
        $isObject = is_object($data);

        return [
            'current_page' => (int) ($isObject ? $data->currentPage() : data_get($data, 'current_page')),
            'last_page'    => (int) ($isObject ? $data->lastPage() : data_get($data, 'last_page')),
            'per_page'     => (int) ($isObject ? $data->perPage() : data_get($data, 'per_page')),
            'total'        => (int) ($isObject ? $data->total() : data_get($data, 'total')),
        ];
    }
}
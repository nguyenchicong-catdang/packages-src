<?php

namespace Vendorpath\Wp\Categories\DTO;

use Illuminate\Pagination\LengthAwarePaginator;


class CatPagination extends \Vendorpath\Wp\Abstract\BaseDTO
{
    // protected static function map(object|array $data): array
    // {
    //     // Kiểm tra nếu là Object Paginator thì dùng method, nếu là array thì dùng data_get
    //     $isObject = is_object($data);

    //     return [
    //         'current_page' => (int) ($isObject ? $data->currentPage() : data_get($data, 'current_page')),
    //         'last_page'    => (int) ($isObject ? $data->lastPage() : data_get($data, 'last_page')),
    //         'per_page'     => (int) ($isObject ? $data->perPage() : data_get($data, 'per_page')),
    //         'total'        => (int) ($isObject ? $data->total() : data_get($data, 'total')),
    //     ];
    // }


    protected static function map(object|array $data): array
    {
        if ($data instanceof LengthAwarePaginator) {
            return [
                'currentPage' => $data->currentPage(),
                'lastPage'    => $data->lastPage(),
                'perPage'     => $data->perPage(),
                'total'        => $data->total(),
                'items'        => $data->items(),
                // 'nextPageUrl' => $data->nextPageUrl(),
                // 'prevPageUrl' => $data->previousPageUrl(),
                // 'getPageName' => $data->getPageName(),
                // 'hasMorePages' => $data->hasMorePages(),
                // 'base_url'     => request()->url(),
                // 'query'        => request()->query(), // Giữ lại các filter khác trên URL nếu có
            ];
        }

        // Trường hợp là array (khi lấy từ cache hoặc toArray)
        return [
            'currentPage' => (int) data_get($data, 'currentPage'),
            'last_page'    => (int) data_get($data, 'last_page'),
            'per_page'     => (int) data_get($data, 'per_page'),
            'total'        => (int) data_get($data, 'total'),
            'nextPageUrl' => data_get($data, 'nextPageUrl'),
            'prevPageUrl' => data_get($data, 'prevPageUrl'),
        ];
    }
}
<?php
namespace Vendorpath\Wp\Categories\DTO;

class CatData extends \Vendorpath\Wp\Abstract\BaseDTO
{
    protected static function map(object|array $data): array
    {
        return [
            'id' => (int) data_get($data, 'term_id'),
            'name' => (string) data_get($data, 'term.name'),
            'slug' => (string) data_get($data, 'term.slug'),
            'description' => (string) data_get($data, 'description'),
            'rank_math_title' => (string) data_get($data, 'meta.rank_math_title'),
            'rank_math_description' => (string) data_get($data, 'meta.rank_math_description'),
        ];
    }
}
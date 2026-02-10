<?php
// Tạo Hợp đồng (Interface)
namespace Vendorpath\Wp\Categories\Interface;

interface CategoryLoaderInterface
{
    public function getCategory(string $slug): array|object;
}
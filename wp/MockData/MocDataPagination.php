<?php
namespace Vendorpath\Wp\MockData;

class MocDataPagination
{
    private static $nameSlugs = 'cat_slugs';

    private static function getFilePath(): string
    {
        // MockDataDir::makeDir() => return directory    
        return MockDataDir::makeDir() . self::$nameSlugs . '.php';
    }

    private static function fakeData() {
        $dataSlugs = [];
        $data = [];

        // Kiểm tra file có đọc được không trước khi include
        if (is_readable(self::getFilePath())) {
            $dataSlugs = include(self::getFilePath());
        }
        // thêm total_pages
        $data['total_items'] = count($dataSlugs);
        $data['limit'] = 12;

        return $data;
    }

    public static function mockData(bool $force = false)
    {
        return self::fakeData();
    }

    // \Vendorpath\Wp\MockData\MocDataPagination::mockData();

}
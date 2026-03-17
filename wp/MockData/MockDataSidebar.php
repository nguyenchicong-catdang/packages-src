<?php

namespace Vendorpath\Wp\MockData;

use Illuminate\Support\Str;

class MockDataSidebar
{
    private static $name = 'sidebar';
    // private static $dir = __DIR__ . '/share_data/';

    private static function getFilePath(): string
    {
        // MockDataDir::makeDir() => return directory    
        return MockDataDir::makeDir() . self::$name . '.php';
    }

    private static function fakeArray(): array
    {
        return [
            'thùng rác',
            'xe thu gom rác'
        ];
    }

    private static function arrayItem(string $item): array
    {
        return [
            'label' => ucfirst($item),
            'slug'  => Str::slug($item)
        ];
    }

    private static function makeData()
    {
        $fakeData = self::fakeArray();
        $data = [];
        foreach ($fakeData as $item) {
            $data[] = self::arrayItem($item);
        }
        return $data;
    }

    private static function makeFile()
    {
        $data = self::makeData();
        $content = "<?php return " . var_export($data, true) . ";";
        file_put_contents(self::getFilePath(), $content);
        return $data;
    }

    public static function mockData(bool $force = false)
    {
        if ($force || !file_exists(self::getFilePath())) {
            return self::makeFile();
        }

        // Kiểm tra file có đọc được không trước khi include
        if (is_readable(self::getFilePath())) {
            return include(self::getFilePath());
        }

        return [];
    }
}

// read

// \Vendorpath\Wp\MockData\MockDataSidebar::mockData();

// làm mới dữ liệu
// \Vendorpath\Wp\MockData\MockDataSidebar::mockData(true);
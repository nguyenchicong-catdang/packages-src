<?php
namespace Vendorpath\Wp\MockData;

class MockCatListsData
{
    private static $name = 'cat_lists';

    private static function getFilePath(): string
    {
        // MockDataDir::makeDir() => return directory    
        return MockDataDir::makeDir() . self::$name . '.php';
    }

    private static function fakeData(int $count = 12)
    {
        $data = [];
        for ($i = 0; $i <= $count; $i++) {
            $data[] = MockCatPostData::fakeData();
        }
        return $data;
    }

    private static function makeFile(int $count = 12)
    {
        $data = self::fakeData($count);
        $content = "<?php return " . var_export($data, true) . ";";
        file_put_contents(self::getFilePath(), $content);
        return $data;
    }

    public static function mockData(bool $force = false, int $count = 12)
    {
        if ($force || !file_exists(self::getFilePath())) {
            return self::makeFile($count);
        }

        // Kiểm tra file có đọc được không trước khi include
        if (is_readable(self::getFilePath())) {
            return include(self::getFilePath());
        }

        return [];
    }
}

// \Vendorpath\Wp\MockData\MockCatListsData::fakeData();

// \Vendorpath\Wp\MockData\MockCatListsData::mockData();
<?php
namespace Vendorpath\Wp\MockData;

class MockDataCatCard
{
    private static $name = 'cat_card';
    private static $faker;

    private static function getFilePath(): string
    {
        // MockDataDir::makeDir() => return directory    
        return MockDataDir::makeDir() . self::$name . '.php';
    }

    private static function getFaker()
    {
        return self::$faker ??= \Faker\Factory::create();
    }


    private static function fakeData()
    {
        $faker = self::getFaker();
        return [
            'name' => $faker->words(4, true),
            'description' => $faker->text(200),
            'featured_src' => 'https://dummyimage.com/650',
            'featured_alt' => 'Alt hinh anh featured_alt'
        ];
    }

    private static function makeFile()
    {
        $data = self::fakeData();
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

// \Vendorpath\Wp\MockData\MockDataCatCard::mockData();
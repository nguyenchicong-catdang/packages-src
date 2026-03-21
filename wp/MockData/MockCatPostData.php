<?php
namespace Vendorpath\Wp\MockData;

use Illuminate\Support\Str;

class MockCatPostData
{
    private static $name = 'cat_post';
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

    public static function fakeData()
    {
        $faker = self::getFaker();
        // $title = $faker->words(5, true);
        $title = $faker->unique()->words(5, true);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $faker->text(350),
            'featured_src' => 'https://dummyimage.com/250',
            'featured_alt' => 'Alt hinh anh ' . $title
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

// \Vendorpath\Wp\MockData\MockCatPostData::mockData();
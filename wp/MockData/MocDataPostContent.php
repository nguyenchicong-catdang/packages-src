<?php
namespace Vendorpath\Wp\MockData;

class MocDataPostContent
{
    private static $name = 'post_content';
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

    // private static function fakeData()
    // {
    //     $faker = self::getFaker();
    //     // $title = $faker->words(5, true);
    //     $title = $faker->unique()->words(5, true);
    //     $paragraph = $faker->paragraph();
    //     return [
    //         'title' => $title,
    //         'paragraph' => "<p>$paragraph</p>",
    //         'featured_src' => 'https://dummyimage.com/650',
    //         'featured_alt' => 'Alt hinh anh ' . $title,

    //     ];
    // }

    private static function fakeData()
    {
        $faker = self::getFaker();
        // $title = $faker->words(5, true);
        $title = $faker->unique()->words(5, true);
        $paragraph = $faker->paragraph();
        $paragraph2 = $faker->paragraph(20);
        return "
        <h2>$title</h2>
        <p>$paragraph</p>
        <img class=\"img-fluid\" src=\"https://dummyimage.com/650\" alt=\"alt anh $paragraph\">
        <p>$paragraph2</p>
        ";
    }

    private static function makeFile()
    {
        $data = '';
        for ($i = 0; $i <= 3; $i++) {
            $data .= self::fakeData();
        }
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
    // \Vendorpath\Wp\MockData\MocDataPostContent::mockData();
}
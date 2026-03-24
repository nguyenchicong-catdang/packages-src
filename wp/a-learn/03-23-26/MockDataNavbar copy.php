<?php
namespace Vendorpath\Wp\MockData;

class MockDataNavbar
{
    // Biến lưu trữ Faker dùng chung
    private static $faker;

    private static function getFaker()
    {
        // if (!self::$faker) {
        //     self::$faker = \Faker\Factory::create();
        // }
        // return self::$faker;
        // Nếu chưa có thì tạo, có rồi thì trả về luôn
        return self::$faker ??= \Faker\Factory::create();
    }

    private static function fakeData(string $type = 'link')
    {
        //$faker = \Faker\Factory::create();
        // Sử dụng lại 1 instance duy nhất
        $faker = self::getFaker();
        $label = $faker->words(3,true);
        return [
            'label' => ucfirst($label),
            'slug' => \Illuminate\Support\Str::slug($label),
            'type' => $type,
            'children' => []
        ];
    }

    private static function makeData(string $name = 'navbar')
    {
        $data = [];
        for ($i = 0; $i < 4; $i++) {
            $data[] = self::fakeData();
            if ($i === 3) {
                $data[$i] = self::fakeData('dropdown');
                for ($j = 0; $j < 4; $j ++) {
                    $data[$i]['children'][] = self::fakeData();
                }
            }
        }

        return $data;
    }

    private static function makeFile(string $name = 'navbar')
    {
        $dir = __DIR__ . '/share_data/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $fileName = $dir . $name . '.php';
        $data = self::makeData();

        $content = "<?php return " . var_export($data, true) . ";";

        file_put_contents($fileName, $content);
        return $data;
    }

    public static function mockData(bool $force = false,)
    {
        $dir = __DIR__ . '/share_data/';
        $name = 'navbar';
        $fileName = $dir . $name . '.php';

        if ($force || !file_exists($fileName)) {
            return self::makeFile($name);
        }

        // Kiểm tra file có đọc được không trước khi include
        if (is_readable($fileName)) {
            return include($fileName);
        }

        return [];
    }
}

// \Vendorpath\Wp\MockData\MockDataNavbar::mockData();
// \Vendorpath\Wp\MockData\MockDataNavbar::mockData(true);
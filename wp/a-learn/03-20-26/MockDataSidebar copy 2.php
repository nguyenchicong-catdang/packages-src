<?php

namespace Vendorpath\Wp\MockData;

class MockDataSidebar
{
    // Chuyển sang static
    private static function fakeData()
    {
        $faker = \Faker\Factory::create();
        $label = $faker->words(3, true);
        return [
            'label' => ucfirst($label),
            'slug'  => \Illuminate\Support\Str::slug($label),
        ];
    }

    // Chuyển sang static và dùng self::
    private static function makeData(int $count = 5)
    {
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = self::fakeData();
        }
        return $data;
    }

    private static function makeFile(string $name = 'sidebar', int $count = 5)
    {
        $dir = __DIR__ . '/share_data/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $fileName = $dir . $name . '.php';
        $data = self::makeData($count);
        $content = "<?php return " . var_export($data, true) . ";";

        file_put_contents($fileName, $content);
        return $data;
    }

    // Đây là hàm bạn cần: getData static
    public static function mockData(bool $force = false, int $count = 5)
    {
        $dir = __DIR__ . '/share_data/';
        $name = 'sidebar';
        $fileName = $dir . $name . '.php';

        if ($force || !file_exists($fileName)) {
            return self::makeFile($name, $count);
        }

        // Kiểm tra file có đọc được không trước khi include
        if (is_readable($fileName)) {
            return include($fileName);
        }

        return [];
    }
}

// \Vendorpath\Wp\MockData\MockDataSidebar::mockData();

// \Vendorpath\Wp\MockData\MockDataSidebar::mockData('sidebar', true, 10);
<?php
namespace Vendorpath\Wp\MockData;

class MockDataSidebar
{
    public function fakeData()
    {
        $faker = \Faker\Factory::create();
        $label = $faker->words(3, true);
        return [
            'label' => ucfirst($label),
            'slug'  => \Illuminate\Support\Str::slug($label), // Tạo slug từ chính cái tên đó
        ];
    }

    public function makeData(int $count = 5)
    {
        $data = [];
        for ($i =0; $i < $count; $i++) {
            $data[] = $this->fakeData();
        }
        return $data;
    }

    public function makeFile(string $name = 'sidebar', int $count = 5)
    {
        $dir = __DIR__ . '/share_data/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true); // Tạo thư mục nếu chưa có
        }
        $fileName = $dir . $name . '.php';
        $data = $this->makeData($count);
        $content = "<?php return " . var_export($data, true) . ";";

        file_put_contents($fileName, $content);
        return $content;
    }

    public function mockData(string $name = 'sidebar', bool $force = false, int $count = 5)
    {
        $dir = __DIR__ . '/share_data/';
        $fileName = $dir . $name . '.php';

        // Nếu ép buộc tạo mới hoặc file chưa tồn tại
        if ($force || !file_exists($fileName)) {
            $this->makeFile($name, $count);
        }

        return include($fileName);
    }
}

// app(\Vendorpath\Wp\MockData\MockDataSidebar::class)->makeData();

// app(\Vendorpath\Wp\MockData\MockDataSidebar::class)->makeFile();

// app(\Vendorpath\Wp\MockData\MockDataSidebar::class)->mockData();
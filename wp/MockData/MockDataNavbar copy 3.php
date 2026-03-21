<?php

namespace Vendorpath\Wp\MockData;

class MockDataNavbar
{
    private static $name = 'navbar';
    // private static $dir = __DIR__ . '/share_data/';

    private static function getFilePath(): string
    {
        // MockDataDir::makeDir() => return directory    
        return MockDataDir::makeDir() . self::$name . '.php';
    }

    private static function arrLink(): array
    {
        return [
            'Trang chủ | / | link',
            'Giới thiệu | gioi-thieu | link',
            'Sản phẩm | san-pham | dropdown',
            'Blog | blog | dropdown',
            'Liên hệ | lien-he | link'
        ];
    }

    // private static function arrDropdown(): array
    // {
    //     return [
    //         'Thùng rác',
    //         'xe thu gom rác',
    //         'thùng rác y tế'
    //     ];
    // }

    private static function arrDropdown(): array
    {
        return [
            'Sản phẩm' => [
                'Thùng rác | thung-rac | link',
                'xe thu gom rác | xe-thu-gom-rac | link',
                'thùng rác y tế | thung-rac-y-te | link'
            ],
            'Blog' => [
                'web | web | link'
            ]
        ];
    }

    // private static function arrayItem(string $item, string $type = 'link')
    // {
    //     //$faker = \Faker\Factory::create();
    //     // Sử dụng lại 1 instance duy nhất
    //     return [
    //         'label' => ucfirst($item),
    //         'slug' => \Illuminate\Support\Str::slug($item),
    //         'type' => $type,
    //         'children' => []
    //     ];
    // }

    private static function arrayItem(?array $item)
    {
        //$faker = \Faker\Factory::create();
        // Sử dụng lại 1 instance duy nhất
        return [
            'label' => ucfirst($item[0]),
            'slug' => $item[1],
            'type' => $item[2],
            'children' => []
        ];
    }

    public static function makeArrItems()
    {
        $items = self::arrLink();
        $data = [];
        foreach ($items as $item) {
            // 1. Cắt và trim chuỗi
            $parts = array_map('trim', explode('|', $item));
            // 2. Viết lại array
            $data[] = self::arrayItem($parts);
        }
        // $arrItem = array_map('trim', explode('|', $item));
        return $data;
        // \Vendorpath\Wp\MockData\MockDataNavbar::makeArrItems();

    }

    public static function makeArrDropdown()
    {
        $dataDropdown = self::arrDropdown();
        $data = [];
        foreach ($dataDropdown as $key => $items) {
            foreach ($items as $item) {
                $parts = array_map('trim', explode('|', $item));
                $data[$key][] = self::arrayItem($parts);
            }
        }
        return $data;
    }
    // \Vendorpath\Wp\MockData\MockDataNavbar::makeArrDropdown();



    // private static function makeData(): array
    // {
    //     $data = [];
    //     foreach (self::arrLink() as $item) {
    //         // 1. Tạo item cha trước
    //         $newItem = self::arrayItem($item);

    //         // 2. Nếu là Sản phẩm, biến nó thành dropdown và thêm con
    //         if ($item === 'Sản phẩm') {
    //             $newItem['type'] = 'dropdown'; // Đổi type

    //             foreach (self::arrDropdown() as $child) {
    //                 // Thêm vào mảng children bằng toán tử []
    //                 $newItem['children'][] = self::arrayItem($child);
    //             }
    //         }

    //         // 3. Đẩy vào mảng tổng
    //         $data[] = $newItem;
    //     }
    //     return $data;
    // }

    public static function makeData(): array
    {
        $dataSubMenu = self::makeArrItems();
        $dataDropdown = self::makeArrDropdown();
        // $dataDropdow = self
        $data = [];
        foreach ($dataSubMenu as $sub) {
            if ($sub['type'] === 'dropdown' && array_key_exists($sub['label'], $dataDropdown)) {
                $sub['children'] = $dataDropdown[$sub['label']];
            }

            $data[] = $sub;
        }
        return $data;
    }
    // \Vendorpath\Wp\MockData\MockDataNavbar::makeData();


    private static function makeFile()
    {

        $data = self::makeData();

        $content = "<?php return " . var_export($data, true) . ";";

        file_put_contents(self::getFilePath(), $content);
        return $data;
    }

    public static function mockData(bool $force = false,)
    {
        // $dir = __DIR__ . '/share_data/';
        // $name = 'navbar';
        // $fileName = $dir . $name . '.php';

        if ($force || !file_exists(self::getFilePath())) {
            return self::makeFile();
        }

        // Kiểm tra file có đọc được không trước khi include
        if (is_readable(self::getFilePath())) {
            return include(self::getFilePath());
        }

        return [];

        // return self::makeData();
    }
}
// read

// \Vendorpath\Wp\MockData\MockDataNavbar::mockData();

// Làm mới dữ liệu

// \Vendorpath\Wp\MockData\MockDataNavbar::mockData(true);
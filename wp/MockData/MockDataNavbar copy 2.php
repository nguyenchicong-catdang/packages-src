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
            'Trang chủ',
            'Giới thiệu',
            'Sản phẩm',
            'Liên hệ'
        ];
    }

    private static function arrDropdown(): array
    {
        return [
            'Thùng rác',
            'xe thu gom rác',
            'thùng rác y tế'
        ];
    }

    private static function arrayItem(string $item, string $type = 'link')
    {
        //$faker = \Faker\Factory::create();
        // Sử dụng lại 1 instance duy nhất
        return [
            'label' => ucfirst($item),
            'slug' => \Illuminate\Support\Str::slug($item),
            'type' => $type,
            'children' => []
        ];
    }

    private static function makeData(): array
    {
        $data = [];
        foreach (self::arrLink() as $item) {
            // 1. Tạo item cha trước
            $newItem = self::arrayItem($item);

            // 2. Nếu là Sản phẩm, biến nó thành dropdown và thêm con
            if ($item === 'Sản phẩm') {
                $newItem['type'] = 'dropdown'; // Đổi type

                foreach (self::arrDropdown() as $child) {
                    // Thêm vào mảng children bằng toán tử []
                    $newItem['children'][] = self::arrayItem($child);
                }
            }

            // 3. Đẩy vào mảng tổng
            $data[] = $newItem;
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
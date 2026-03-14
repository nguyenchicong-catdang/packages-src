## fakeData
```php
private function fakeData()
    {
        // Dữ liệu giả để test khi chưa có kết nối DB hoặc trong môi trường local
        return '
        Trang chủ | /
        Sản phẩm | # | dropdown
            Thùng rác | category/thung-rac
            Thùng rác đạp chân | category/thung-rac-dap-chan
        Tin Tức | blog
        Liên Hệ | contact
        ';
    }
```

## code parse
```php
<?php

namespace Vendorpath\Wp\Esi\Navbars;

class NavbarActionParse
{
    public function action(?string $data): array
    {
        if (empty($data)) return [];

        // 1. Tách dòng và loại bỏ dòng trống
        $lines = array_filter(explode("\n", $data), fn($l) => trim($l) !== '');

        $result = [];
        $stack = [0 => &$result]; // Lưu trữ tham chiếu đến mảng children theo từng cấp độ thụt lề
        $indents = [0 => -1]; // Lưu giá trị thụt lề (số khoảng trắng) để so sánh cấp độ

        foreach ($lines as $line) {
            $trimmed = ltrim($line);
            $currentIndent = strlen($line) - strlen($trimmed);

            $parts = array_map('trim', explode('|', $trimmed));
            if (count($parts) < 2) continue;

            $item = [
                'label'    => $parts[0],
                'slug'     => $parts[1],
                'type'     => $parts[2] ?? 'link',
                'children' => []
            ];

            // 2. Tìm cấp cha dựa trên số lượng khoảng trắng (indent)
            // Quay ngược stack lại cho đến khi tìm thấy indent nhỏ hơn indent hiện tại
            $depth = count($indents) - 1;
            while ($depth > 0 && $indents[$depth] >= $currentIndent) {
                array_pop($indents);
                array_pop($stack);
                $depth--;
            }

            // 3. Thêm mục vào mảng con của cấp cha hiện tại
            $parentList = &$stack[count($stack) - 1];
            $parentList[] = $item;

            // 4. Lưu tham chiếu của mục vừa thêm vào stack để làm cha cho các dòng sau
            $newIdx = count($parentList) - 1;
            $stack[] = &$parentList[$newIdx]['children'];
            $indents[] = $currentIndent;
        }
        dd($result);
        return $result;
    }
}

```

<?php

namespace Vendorpath\Wp\Esi\Navbars;

class NavbarActionParse
{
    public function action(?string $data): array
    {
        if (empty($data)) return [];

        // 1. Tách dòng và loại bỏ dòng trống
        $lines = array_filter(explode("\n", $data), fn($l) => trim($l) !== '');

        $result = [];
        $stack = [0 => &$result]; // Lưu trữ tham chiếu đến mảng children theo từng cấp độ thụt lề
        $indents = [0 => -1]; // Lưu giá trị thụt lề (số khoảng trắng) để so sánh cấp độ

        foreach ($lines as $line) {
            $trimmed = ltrim($line);
            $currentIndent = strlen($line) - strlen($trimmed);

            $parts = array_map('trim', explode('|', $trimmed));
            if (count($parts) < 2) continue;

            $item = [
                'label'    => $parts[0],
                'slug'     => $parts[1],
                'type'     => $parts[2] ?? 'link',
                'children' => []
            ];

            // 2. Tìm cấp cha dựa trên số lượng khoảng trắng (indent)
            // Quay ngược stack lại cho đến khi tìm thấy indent nhỏ hơn indent hiện tại
            $depth = count($indents) - 1;
            while ($depth > 0 && $indents[$depth] >= $currentIndent) {
                array_pop($indents);
                array_pop($stack);
                $depth--;
            }

            // 3. Thêm mục vào mảng con của cấp cha hiện tại
            $parentList = &$stack[count($stack) - 1];
            $parentList[] = $item;

            // 4. Lưu tham chiếu của mục vừa thêm vào stack để làm cha cho các dòng sau
            $newIdx = count($parentList) - 1;
            $stack[] = &$parentList[$newIdx]['children'];
            $indents[] = $currentIndent;
        }
        dd($result);
        return $result;
    }
}

## tham khảo
```php
<?php
namespace Vendorpath\Wp\Esi\Navbars;

class NavbarActionParse
{
    public function action(?string $data): array
    {
        if (empty($data)) return [];

        // 1. Tách dòng và làm sạch
        $lines = array_filter(explode("\n", $data), fn($l) => trim($l) !== '');
        
        $result = [];
        $lastParentIdx = -1; // Lưu vị trí của mục cha cuối cùng được tìm thấy

        foreach ($lines as $line) {
            $trimmed = ltrim($line);
            $indent = strlen($line) - strlen($trimmed);
            
            $parts = array_map('trim', explode('|', $trimmed));
            if (count($parts) < 2) continue;

            $item = [
                'label'    => $parts[0],
                'slug'     => $parts[1],
                'type'     => $parts[2] ?? 'link',
                'children' => []
            ];

            // LOGIC CHỐT 2 CẤP:
            // Nếu không thụt lề (indent == 0) -> Luôn là cấp CHA
            if ($indent === 0) {
                $result[] = $item;
                $lastParentIdx = count($result) - 1;
            } 
            // Nếu có thụt lề (indent > 0) -> Luôn là cấp CON của cha gần nhất
            else {
                if ($lastParentIdx !== -1) {
                    // Ép buộc vào children của cha, không cần biết thụt vào bao nhiêu space
                    $result[$lastParentIdx]['children'][] = $item;
                } else {
                    // Phòng hờ trường hợp dòng đầu tiên bị thụt lề trái phép
                    $result[] = $item;
                    $lastParentIdx = count($result) - 1;
                }
            }
        }

        return $result;
    }
}
```
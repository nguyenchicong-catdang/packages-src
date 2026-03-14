## Cách kiểm tra lại dữ liệu đầu vào (Fake Data)
Bạn hãy đảm bảo dữ liệu truyền vào không được có khoảng trắng dư thừa ở các dòng cấp 1:

PHP
// CẤP 1 PHẢI VIẾT SÁT LỀ TRÁI
$data = "
Thùng rác | category/thung-rac
 Con của thùng rác 1 | slug-1
 Con của thùng rác 2 | slug-2
Xe đạp | category/xe-dap
 Điện thoại | category/dien-thoai
";

Vấn đề nằm ở chỗ cái chuỗi `fakeData` của bạn đang bị **thụt lề hàng loạt** do cách viết code (indent của IDE), dẫn đến việc `$indentSize` luôn lớn hơn 0 ngay từ dòng đầu tiên. Khi `$indentSize > 0`, code hiểu lầm tất cả là "Con" nhưng lại chưa có ông "Cha" nào được khởi tạo trước đó.

Để "phi shop" và bất tử trước mọi kiểu nhập liệu (dù là textarea hay fake data trong code), bạn cần thêm bước **tự động trừ đi khoảng trắng thừa của cả khối dữ liệu**.

Dưới đây là bản fix triệt để:

### 1. Logic xử lý "Indentation Offset" (Tự cân bằng thụt lề)

Hàm này sẽ tìm xem dòng nào có độ thụt lề nhỏ nhất, coi đó là mốc 0 (Cấp 1), mọi thứ thụt vào sâu hơn mốc đó sẽ là Cấp 2.

```php
<?php

namespace Vendorpath\Wp\Esi\Sidebars;

class SidebarActionToArray
{
    public function action(?string $data): array
    {
        if (empty($data)) return [];

        // 1. Tách dòng và loại bỏ các dòng chỉ chứa khoảng trắng/rỗng
        $lines = array_values(array_filter(
            explode("\n", $data), 
            fn($line) => trim($line) !== ''
        ));

        if (empty($lines)) return [];

        // 2. TÌM MỐC THỤT LỀ NHỎ NHẤT (Base Indent)
        // Điều này giúp xử lý việc fakeData bị thụt lề do format code
        $minIndent = 999;
        foreach ($lines as $line) {
            $currentIndent = strlen($line) - strlen(ltrim($line));
            if ($currentIndent < $minIndent) {
                $minIndent = $currentIndent;
            }
        }

        $result = [];
        $lastParentIndex = -1;

        foreach ($lines as $line) {
            // 3. Tính toán Indent dựa trên mốc Min đã tìm được
            $trimmedLine = ltrim($line);
            $currentIndent = strlen($line) - strlen($trimmedLine);
            $relativeIndent = $currentIndent - $minIndent;

            $parts = explode('|', $trimmedLine);
            if (count($parts) !== 2) continue;

            $item = [
                'label' => trim($parts[0]),
                'slug'  => trim($parts[1]),
                'children' => []
            ];

            // 4. Nếu relativeIndent == 0 -> Chắc chắn là CHA (Cấp 1)
            if ($relativeIndent <= 0) {
                $result[] = $item;
                $lastParentIndex = count($result) - 1;
            } 
            // Nếu thụt vào sâu hơn -> Là CON (Cấp 2)
            else {
                if ($lastParentIndex >= 0) {
                    $result[$lastParentIndex]['children'][] = $item;
                } else {
                    // Phòng thủ nếu data dòng đầu bị lệch
                    $result[] = $item;
                    $lastParentIndex = count($result) - 1;
                }
            }
        }

        return $result;
    }
}

```

---

### 2. Tại sao cách này giải quyết được vấn đề của bạn?

1. **Xóa bỏ sự khác biệt giữa Fake Data và Textarea:** Dù bạn viết code thụt lề 8 dấu cách hay Textarea sát lề trái, thuật toán `$relativeIndent` sẽ đưa dòng "ngoài cùng nhất" về giá trị 0.
2. **`array_filter` & `array_values`:** Loại bỏ hoàn toàn các dòng trống thừa thãi ở đầu, giữa hoặc cuối chuỗi do gõ phím `Enter` dư.
3. **Lỳ lợm với dữ liệu:** Nó không quan tâm bạn thụt lề bao nhiêu (2, 4 hay 8 spaces), nó chỉ quan tâm "Ông nào thụt lề ít nhất thì ông đó là Cha".

---

### 3. Giải trình với sếp (Phản biện)

Nếu sếp hỏi tại sao code phức tạp thế này, bạn trả lời:

> *"Dữ liệu từ Textarea hoặc Fake Data thường bị dính lỗi khoảng trắng ngoài ý muốn (whitespace noise). Em đã triển khai thuật toán **Indentation Normalization** (Chuẩn hóa thụt lề). Nó tự động tính toán 'vùng đệm' khoảng trắng để xác định cấp độ Cha-Con một cách tương đối. Nhờ vậy, người nhập liệu có thể trình bày theo ý thích mà hệ thống vẫn render mảng chuẩn 100%."*

### Tiếp theo cho bạn:

Giờ bạn thử dùng `dd()` với `fakeData` cũ của bạn xem. Kết quả chắc chắn sẽ bung ra các Index 0, 1, 2 thay vì bị gộp vào một chỗ. Bạn có muốn tôi tối ưu thêm phần **ghi file cache** cho cái mảng đã xử lý này để ESI gọi phát ăn luôn không?
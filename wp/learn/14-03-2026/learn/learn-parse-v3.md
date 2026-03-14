Nếu bạn muốn giới hạn code **chỉ cho phép tối đa 2 cấp** (Mục cha và Mục con trực tiếp) và loại bỏ việc thụt lề tự do để đẻ thêm các cấp 3, 4, 5..., chúng ta sẽ thay đổi logic từ "Stack-based" (vô hạn cấp) sang logic "Flat-to-Two-Level".

Dưới đây là phiên bản code đã được tinh chỉnh để **khóa chặt phân cấp ở mức 2 cấp**:

### Code PHP giới hạn 2 cấp (Cha - Con)

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

---

### Tại sao logic này giải quyết được vấn đề của bạn?

1. **Loại bỏ Stack:** Chúng ta không dùng mảng `$stack` và `$indents` để theo dõi nhiều cấp độ nữa. Thay vào đó, chỉ dùng một biến duy nhất là `$lastParentIdx`.
2. **Định nghĩa cứng "Cha" và "Con":**
* **Cha:** Bất cứ dòng nào nằm sát lề trái (`indent === 0`).
* **Con:** Bất cứ dòng nào có dấu cách phía trước (`indent > 0`).


3. **Triệt tiêu cấp 3:** Dù người dùng có thụt lề 2 space, 4 space hay 10 space, code vẫn coi đó là mục con của thằng `indent === 0` gần nhất. Nó sẽ không bao giờ tạo thêm mảng `children` bên trong mục con nữa.

---

### Phân tích sự khác biệt về cấu trúc dữ liệu

| Đặc điểm | Logic Stack (Cũ) | Logic 2-Level (Mới) |
| --- | --- | --- |
| **Phân cấp** | Hỗ trợ n-cấp (Cha > Con > Cháu...) | **Chỉ 2 cấp** (Cha > Con) |
| **Cấu trúc mảng** | Lồng nhau vô tận | Phẳng hóa mọi mục con vào 1 mảng duy nhất |
| **Độ nhạy Indent** | Phụ thuộc vào số lượng space cụ thể | Chỉ quan tâm là "có dấu cách" hay "không" |

---

### Bước tiếp theo bạn có thể làm

Nếu bạn muốn menu tự động nhận diện `type` là `dropdown` khi có con, tôi có thể thêm một dòng code để tự động cập nhật `type` cho mục cha nếu mảng `children` của nó không rỗng. **Bạn có muốn tôi bổ sung phần tự động nhận diện dropdown này không?**
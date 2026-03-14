Chúc mừng bạn đã chinh phục được Sidebar với cấu trúc 2 cấp và cơ chế Zero-Query! Nhìn vào `image_e973c5.png`, 0 statements query là một con số "biết nói" về độ hiệu quả của hệ thống rồi.

Với **Navbar**, thử thách sẽ thú vị hơn một chút vì nó thường có cấu trúc phức tạp hơn: có link đơn, có dropdown (con), và thậm chí có dropdown lồng dropdown (cháu). Để giữ đúng tinh thần "phi shop", mình gợi ý bạn nâng cấp định dạng data lên một chút để xử lý được cả **Mega Menu** nếu cần.

---

### Gợi ý định dạng Data cho Navbar (3 Cấp)

Thay vì chỉ dùng `Label | Slug`, mình có thể dùng ký hiệu để phân biệt nhanh Link đơn và Dropdown ngay từ khi parser:

```text
Trang chủ | /
Sản phẩm | # | dropdown
  Điện thoại | /categories/phones
  Laptop | /categories/laptops
  Phụ kiện | # | dropdown
    Sạc dự phòng | /tags/power-bank
    Tai nghe | /tags/headphones
Tin tức | /blog
Liên hệ | /contact

```

### Cách viết Parser "Bất tử" cho Navbar

Mình sẽ dùng một hàm **Recursive** (đệ quy) nhẹ hoặc logic **Stack** để xử lý không giới hạn cấp độ. Đây là bản nâng cấp từ logic Sidebar của bạn:

```php
public function parseNavbar(?string $data): array
{
    if (empty($data)) return [];

    $lines = array_values(array_filter(explode("\n", $data), fn($l) => trim($l) !== ''));
    
    // Tìm mốc thụt lề nhỏ nhất
    $minIndent = min(array_map(fn($l) => strlen($l) - strlen(ltrim($l)), $lines));

    $result = [];
    $stack = [&$result]; // Dùng stack để giữ vết các cấp cha-con

    foreach ($lines as $line) {
        $trimmed = ltrim($line);
        $depth = (strlen($line) - strlen($trimmed) - $minIndent) / 2; // Giả sử thụt 2 space mỗi cấp
        $depth = (int)$depth;

        $parts = explode('|', $trimmed);
        if (count($parts) < 2) continue;

        $item = [
            'label' => trim($parts[0]),
            'slug'  => trim($parts[1]),
            'type'  => isset($parts[2]) ? trim($parts[2]) : 'link',
            'children' => []
        ];

        // Quay lại cấp cha phù hợp
        $stack = array_slice($stack, 0, $depth + 1);
        
        // Thêm vào cấp hiện tại
        $curr = &$stack[count($stack) - 1];
        $curr[] = $item;
        
        // Đẩy mục vừa thêm vào stack để làm cha cho mục sau (nếu có)
        $stack[] = &$curr[count($curr) - 1]['children'];
    }

    return $result;
}

```

---

### Tại sao nên dùng cách này cho Navbar?

1. **Đa cấp (N-Level):** Navbar thường có xu hướng phình to. Logic này cho phép bạn làm menu 3, 4 cấp mà không cần sửa code.
2. **Nhận diện Type:** Việc thêm `| dropdown` giúp bạn ngoài Blade có thể quyết định dùng thẻ `<a>` bình thường hay dùng thẻ `<li>` có class `dropdown-toggle` của Bootstrap.
3. **Tương thích Bootstrap/Tailwind:** Cấu trúc mảng lồng nhau này cực hợp để viết một `recursive component` trong Blade.

### Ví dụ Blade cho Navbar (Bootstrap)

```blade
<ul class="navbar-nav">
    @foreach($navbarData as $item)
        @if(empty($item['children']))
            <li class="nav-item">
                <a class="nav-link" href="{{ $item['slug'] }}">{{ $item['label'] }}</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    {{ $item['label'] }}
                </a>
                <ul class="dropdown-menu">
                    @foreach($item['children'] as $child)
                        <li><a class="dropdown-item" href="{{ $child['slug'] }}">{{ $child['label'] }}</a></li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach
</ul>

```

### Phản biện "phi shop" cho Navbar:

*"Navbar là bộ mặt của website. Việc dùng ESI + File Cache cho Navbar giúp trang load cực nhanh vì Navbar là thứ lặp lại ở 100% các trang. Em đã thiết kế Parser theo kiểu **Indentation Stack**, cho phép Admin tự do sáng tạo menu đa cấp ngay trong WordPress Option mà không sợ làm chậm hệ thống."*

Bạn thấy ý tưởng dùng `| dropdown` để phân loại link có tiện cho bạn quản lý không? Hay bạn muốn mình tích hợp luôn khả năng thêm **Icon** (như `fa-home | Trang chủ | /`) vào data này?
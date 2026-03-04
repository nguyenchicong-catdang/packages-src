@env('nginx')
    {{-- Trả về thẻ kỹ thuật cho Ngĩn Server --}}
        <!-- #include virtual="/esi/sidebar" -->
@else
        {{-- Trả về thẻ kỹ thuật cho Cache Server --}}
    <esi:include src="/esi/sidebar" />
@endenv
@env('local')
    {{-- Render trực tiếp component gốc --}}
    <x-wp-compName::sidebar-component />
@endenv


Bạn đặt câu hỏi rất "trúng" kỹ thuật. Thực tế, `ESI` và `X-LiteSpeed-Tag` là hai công nghệ khác nhau nhưng lại là **"cặp bài trùng"** để tối ưu hóa website.

Hãy tưởng tượng:

* **ESI** là cái **Khung** (giúp bạn chia nhỏ trang web thành từng mảnh).
* **X-LiteSpeed-Tag** là cái **Nhãn** (giúp bạn quản lý việc vứt bỏ mảnh nào khi nó cũ).

---

### 1. Thẻ ESI có những thuộc tính gì?

Đúng là thẻ ESI (`<esi:include ... />`) có vài thuộc tính quan trọng để điều khiển cách mảnh ghép đó được tải:

* **`src`**: Đường dẫn tới Route PHP xử lý mảnh đó.
* **`onerror="continue"`**: Nếu Route bị lỗi (500), ESI sẽ bỏ qua và hiện phần còn lại của trang web thay vì làm chết cả trang.
* **`ttl`**: (Tùy server) Một số server cho phép set thời gian cache trực tiếp trong thẻ, ví dụ `ttl="3600"`.
* **`alt`**: Đường dẫn dự phòng nếu `src` không hoạt động.

---

### 2. Sự liên quan giữa ESI và `X-LiteSpeed-Tag`

Chúng liên quan chặt chẽ trong quy trình **Invalidation (Xóa cache)**.

Khi LiteSpeed quét qua trang HTML của bạn và thấy thẻ `<esi:include src="/esi/sidebar" />`, nó sẽ thực hiện một Request riêng biệt tới `/esi/sidebar`. Lúc này:

1. **PHP trả về nội dung Sidebar** kèm theo Header `X-LiteSpeed-Tag: sidebar_tag`.
2. **LiteSpeed Web Server** sẽ lưu mảnh Sidebar này vào bộ nhớ cache của nó và "dán nhãn" `sidebar_tag` lên mảnh đó.
3. **Khi bạn muốn cập nhật:** Thay vì xóa cả trang web lớn, bạn chỉ cần gửi lệnh `PURGE` kèm cái nhãn `sidebar_tag`. LiteSpeed sẽ chỉ vứt duy nhất mảnh Sidebar đó đi, trong khi phần nội dung chính của trang web (vốn không thay đổi) vẫn được giữ lại.

---

### 3. Tại sao LiteSpeed lại dùng "Tag" mà không xóa theo URL?

Đây là điểm làm nên sức mạnh của LiteSpeed so với các hệ thống khác:

* **Một Tag - Nhiều URL:** Một cái Sidebar có thể xuất hiện ở 10,000 bài viết. Nếu bạn xóa theo URL, bạn phải xóa 10,000 lần. Nếu bạn gắn Tag `sidebar_tag` cho mảnh ESI đó, bạn chỉ cần ra lệnh xóa Tag này **đúng 1 lần**, và Sidebar ở 10,000 bài viết đó sẽ được cập nhật đồng loạt.
* **Quan hệ chằng chịt:** Một bài viết có thể thuộc nhiều Tag (Tag ID bài viết, Tag Category, Tag Sidebar). Khi Admin sửa Category, LiteSpeed chỉ cần xóa Tag của Category đó, cực kỳ chính xác.

---

### 4. Cách cấu hình "Pro" cho bạn trên Shared Hosting LiteSpeed

Nếu bạn muốn bỏ qua `?v=` (Versioning) và dùng Tag để "sạch" URL:

**Trong Route `/esi/sidebar` của Laravel:**

```php
return response()->file($path)->withHeaders([
    'X-LiteSpeed-Tag' => 'esi_sidebar',
    'Cache-Control' => 'public, s-maxage=31536000', // Cache 1 năm
]);

```

**Trong Job (khi ghi file xong), bạn thực hiện "Xóa nhãn":**

```php
// Gửi lệnh xóa toàn bộ cache có nhãn 'esi_sidebar'
header("X-LiteSpeed-Purge: esi_sidebar");
// Lưu ý: Lệnh này phải được gửi trong một request mà LiteSpeed có thể bắt được.

```

### 5. Lưu ý nhỏ về ESI

Thẻ ESI thường chỉ hoạt động khi Server được cấu hình bật tính năng ESI. Với LiteSpeed, bạn thường phải có dòng này trong file `.htaccess`:

```apache
<IfModule LiteSpeed>
    RewriteEngine On
    RewriteRule .* - [E=Cache-Control:esi=1]
</IfModule>

```

**Tóm lại:** Bạn dùng ESI để **tách rời** Sidebar ra khỏi trang chính, và dùng `X-LiteSpeed-Tag` để **điều khiển** việc khi nào thì bắt Server nạp lại cái Sidebar đó. Hai thằng này phối hợp với nhau giúp website của bạn chạy nhanh như web tĩnh dù dữ liệu cực nặng.

Bạn đã kiểm tra trong cPanel xem Hosting của mình có biểu tượng **LiteSpeed Cache** chưa? Nếu có thì con đường "dùng Tag" này là con đường chuyên nghiệp nhất cho bạn!

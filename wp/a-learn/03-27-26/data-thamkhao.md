Trong cấu trúc dữ liệu của WordPress (WP), một **Post Card** (thẻ bài viết) thường được dùng để hiển thị tóm tắt nội dung ở trang chủ, trang danh mục (category) hoặc kết quả tìm kiếm.

Để một Post Card trông chuyên nghiệp và đầy đủ, bạn cần lấy các trường dữ liệu từ đối tượng `WP_Post` và các Metadata liên quan.

Dưới đây là danh sách các trường dữ liệu phổ biến nhất:

---

### 1. Dữ liệu Cơ bản (Core Data)
Đây là các trường luôn có sẵn trong bảng `wp_posts`:
* **ID:** Mã định danh duy nhất của bài viết.
* **Title (`post_title`):** Tiêu đề bài viết.
* **Slug (`post_name`):** Đường dẫn thân thiện (ví dụ: `bai-viet-moi-nhat`).
* **Excerpt (`post_excerpt`):** Đoạn tóm tắt ngắn. Nếu không có, WP thường tự cắt từ nội dung chính.
* **Date (`post_date`):** Ngày đăng bài (thường được định dạng lại như `24/03/2026`).

### 2. Dữ liệu Hình ảnh (Media)
Phần quan trọng nhất để làm Card bắt mắt:
* **Featured Image (Thumbnail):** Ảnh đại diện của bài viết.
    * `src`: Đường dẫn ảnh (URL).
    * `alt`: Văn bản thay thế (tốt cho SEO).
    * `srcset`: Các kích thước ảnh khác nhau để tối ưu hiển thị trên mobile/desktop.

### 3. Dữ liệu Phân loại (Taxonomies)
Giúp người dùng biết bài viết thuộc chủ đề nào:
* **Categories:** Danh mục chính (ví dụ: Tin tức, Đời sống). Thường chỉ hiển thị danh mục đầu tiên trên Card.
* **Tags:** Các từ khóa liên quan (ít khi hiện trên Card hơn Category để tránh rối mắt).

### 4. Dữ liệu Tác giả & Tương tác
* **Author:** Tên người đăng bài (kèm link đến trang cá nhân của tác giả).
* **Comment Count:** Số lượng bình luận (tạo hiệu ứng đám đông, tăng uy tín).
* **Reading Time:** Thời gian đọc ước tính (thường tính bằng logic: `tổng số từ / 200`).

---

### Cấu trúc JSON mẫu cho một Post Card
Nếu bạn làm việc với API hoặc Mock Data như các câu hỏi trước, dữ liệu sẽ trông như thế này:

```json
{
  "id": 101,
  "title": "Cách tối ưu hóa hiệu suất WordPress 2026",
  "slug": "cach-toi-uu-hoa-hieu-suat-wordpress",
  "excerpt": "Tìm hiểu các kỹ thuật mới nhất để tăng tốc website của bạn chỉ trong vài bước...",
  "featured_image": {
    "url": "https://example.com/wp-content/uploads/photo.jpg",
    "alt": "Tối ưu WordPress"
  },
  "category": {
    "name": "Thủ thuật WP",
    "link": "/category/thu-thuat-wp"
  },
  "author": "Admin",
  "date": "2026-03-24",
  "reading_time": "5 min"
}
```

---

### 5. Lưu ý khi code (PHP/Laravel)
Khi bạn làm Mock Data cho Post Card trong môi trường Laravel/WP kết hợp như bạn đang làm, hãy nhớ:
* Luôn có trường **URL** (sử dụng `route()` hoặc `get_permalink()`).
* **Excerpt** nên giới hạn số ký tự (ví dụ: 100-150 ký tự) để các Card có chiều cao bằng nhau, giao diện sẽ đẹp hơn.



Bạn có muốn tôi viết một hàm **Mock Data** chuẩn bao gồm đầy đủ các trường này để bạn sử dụng cho Component Post Card không?
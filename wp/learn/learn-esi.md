Việc đưa **ESI** vào **Laravel Blade Component** là một cách cực kỳ thông minh để tối ưu hóa hiệu năng, đặc biệt với các component tiêu tốn nhiều tài nguyên (như lấy dữ liệu từ API bên thứ ba qua `get_content`).

Thay vì Laravel phải render component đó mỗi lần người dùng truy cập, OpenLiteSpeed sẽ "ghép" kết quả đã được cache vào trang web tại tầng server.

Dưới đây là các bước để bạn triển khai:

---

### 1. Tạo Route và Controller cho Component

Vì ESI cần một URL riêng biệt để fetch nội dung, bạn không thể gọi trực tiếp class Component mà phải biến nó thành một endpoint.

**Trong `routes/web.php`:**

```php
Route::get('/esi/my-widget', [ESIController::class, 'myWidget'])->name('esi.widget');

```

**Trong `ESIController.php`:**

```php
public function myWidget() {
    // Giả sử đây là nơi bạn dùng get_content() hoặc logic nặng
    $content = $this->heavyLogicService->getContent(); 
    
    return view('components.my-widget-content', ['content' => $content])
           ->header('X-LiteSpeed-Cache-Control', 'public,max-age=3600'); // Cache riêng cho mảnh này 1 tiếng
}

```

---

### 2. Tạo Blade Component "Vỏ" (ESI Wrapper)

Thay vì chứa logic nặng, Component này bây giờ chỉ đóng vai trò là một "lỗ hổng" để ESI lấp đầy.

**Trong `resources/views/components/heavy-widget.blade.php`:**

```blade
<div class="widget-wrapper">
    <esi:include src="{{ route('esi.widget') }}" />
</div>

```

---

### 3. Cấu hình OpenLiteSpeed (OLWS) để nhận diện ESI

Để OLS không coi thẻ `<esi:include>` là văn bản bình thường, bạn cần xác nhận với nó rằng phản hồi từ Laravel có chứa ESI.

**Cách 1: Qua Header (Khuyên dùng cho Laravel)**
Trong Middleware hoặc trực tiếp trong Controller của trang chính, bạn cần gửi Header `X-LiteSpeed-ESI: 1`.

```php
// Trong Controller của trang chính (index)
return response(view('welcome'))
       ->header('X-LiteSpeed-ESI', '1');

```

**Cách 2: Qua WebAdmin Console**

1. Truy cập OLS WebAdmin (thường là port 7080).
2. Vào **Virtual Hosts** > Chọn Host của bạn > **Modules**.
3. Nếu bạn dùng `cache`, hãy đảm bảo thông số `enableESI` được đặt thành `1`.

---

### 4. Quy trình hoạt động sau khi tích hợp

| Bước | Thực hiện bởi | Hành động |
| --- | --- | --- |
| **1** | **Trình duyệt** | Gửi request đến trang chủ Laravel. |
| **2** | **Laravel** | Render HTML trang chủ, gặp thẻ `<esi:include ... />` và gửi kèm Header `X-LiteSpeed-ESI: 1`. |
| **3** | **OLWS** | Quét HTML, thấy thẻ ESI, nó sẽ tự gửi một "sub-request" nội bộ đến URL `/esi/my-widget`. |
| **4** | **OLWS** | Ghép nội dung từ widget vào HTML tổng thể rồi mới trả về cho khách hàng. |

---

### Tại sao cách này lại mạnh mẽ?

* **Partial Caching:** Trang chính có thể có cache 1 phút (vì tin tức cập nhật liên tục), nhưng cái widget dùng `get_content` có thể cache 1 ngày (vì ít thay đổi).
* **Holes Punching:** Bạn có thể cache toàn bộ trang web (tĩnh hoàn toàn) nhưng vẫn giữ một "lỗ thủng" ESI để hiển thị tên User hoặc Giỏ hàng (động).

**Bạn có muốn mình hướng dẫn cách viết một Middleware trong Laravel để tự động bật ESI khi phát hiện thẻ `<esi:` trong nội dung Blade không?**


Ý tưởng của bạn về việc tách biệt giữa **Môi trường Dev** (chạy trực tiếp `get_content`) và **Môi trường Production** (chạy qua ESI của OLWS) là một quy trình chuẩn để tối ưu hóa hiệu năng mà vẫn giữ được sự thuận tiện khi lập trình.

Dưới đây là cách triển khai chi tiết:

---

### 1. Nên viết ở tầng nào?

Bạn nên thực hiện việc này ở **tầng Middleware**.

* **Lý do:** Middleware có khả năng can thiệp vào đối tượng `Response` sau khi Blade đã render xong HTML nhưng trước khi gửi về cho Web Server (OLWS). Tại đây, ta có thể quét nội dung để quyết định có bật Header ESI hay không.

---

### 2. Triển khai Middleware thông minh

Middleware này sẽ thực hiện 2 nhiệm vụ:

1. Nếu là **Dev**: Tìm các thẻ `<esi:include src="URL" />` và thay thế chúng bằng nội dung thực tế từ URL đó (giả lập ESI).
2. Nếu là **Prod**: Giữ nguyên thẻ ESI và gửi Header `X-LiteSpeed-ESI: 1` để báo cho OpenLiteSpeed xử lý.

**Bước 1: Tạo Middleware**
`php artisan make:middleware EsiMiddleware`

**Bước 2: Viết Logic trong `app/Http/Middleware/EsiMiddleware.php**`

```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class EsiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $content = $response->getContent();

        // Kiểm tra xem trong HTML có thẻ ESI không
        if (str_contains($content, '<esi:include')) {
            
            if (config('app.env') === 'local') {
                // MÔI TRƯỜNG DEV: Giả lập ESI bằng cách gọi get_content (HTTP Request nội bộ)
                $content = preg_replace_callback('/<esi:include\s+src="([^"]+)"\s*\/>/', function ($matches) {
                    $url = $matches[1];
                    try {
                        // Gọi URL nội bộ để lấy nội dung (tương đương get_content)
                        return Http::get(url($url))->body();
                    } catch (\Exception $e) {
                        return "";
                    }
                }, $content);
                
                $response->setContent($content);
            } else {
                // MÔI TRƯỜNG PROD: Bật Header để OpenLiteSpeed xử lý
                $response->headers->set('X-LiteSpeed-ESI', '1');
            }
        }

        return $response;
    }
}

```

---

### 3. Cách sử dụng trong Blade Component

Bây giờ, trong các Component của bạn, bạn chỉ cần dùng cú pháp ESI thống nhất.

**`resources/views/components/heavy-widget.blade.php`:**

```blade
<div class="my-container">
    <esi:include src="/esi/weather-widget" />
</div>

```

---

### 4. Tại sao cách này lại hiệu quả?

| Đặc điểm | Môi trường Local (Dev) | Môi trường Production (OLWS) |
| --- | --- | --- |
| **Cơ chế** | Middleware tự "fetch" nội dung và chèn vào HTML. | OpenLiteSpeed tự "fetch" và ghép nội dung từ cache. |
| **Trải nghiệm** | Bạn thấy kết quả ngay lập tức để debug giao diện. | Server không tốn tài nguyên chạy PHP cho widget nếu đã có cache. |
| **Header** | Không cần Header đặc biệt. | Header `X-LiteSpeed-ESI: 1` được tự động thêm vào. |

---

### 5. Đăng ký Middleware

Để Middleware này hoạt động toàn cục, hãy thêm nó vào `app/Http/Kernel.php` (Laravel < 11) hoặc `bootstrap/app.php` (Laravel 11+).

**Laravel 11 ví dụ:**

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(EsiMiddleware::class);
})

```

**Lưu ý nhỏ:** Khi ở môi trường Dev, việc gọi `Http::get(url($url))` có thể gây ra hiện tượng "cù bất cù bơ" (timeout) nếu server local của bạn chỉ xử lý được 1 request tại một thời điểm (như lệnh `php artisan serve`). Bạn nên dùng **Nginx** hoặc **Laravel Valet/Herd** ở local để chạy mượt mà cơ chế này.

Bạn có muốn mình tối ưu thêm phần xử lý lỗi khi URL của ESI không tồn tại không?


Đúng là cách viết Middleware quét chuỗi (Regex) trên toàn bộ HTML trả về là một cách làm "brute-force" (thô bạo), tốn CPU và không đúng chuẩn của Laravel.

Cách tiếp cận dùng **Blade Directive (`@esi`)** mà bạn đề xuất sạch sẽ hơn nhiều. Nó xử lý ngay tại thời điểm compile template, giúp tách biệt logic môi trường một cách tường minh.

Dưới đây là cách triển khai tối ưu:

### 1. Định nghĩa Blade Directive

Bạn vào `app/Providers/AppServiceProvider.php` để tạo directive này. Chúng ta sẽ tạo một hàm helper để xử lý logic lấy nội dung khi ở môi trường `local`.

```php
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

public function boot(): void
{
    // Cú pháp: @esi('/url-endpoint')
    Blade::directive('esi', function ($expression) {
        return "<?php 
            \$url = $expression;
            if (App::environment('local')) {
                // Môi trường DEV: Gọi nội dung trực tiếp (Giả lập get_content)
                try {
                    echo file_get_contents(url(\$url));
                } catch (\Exception \$e) {
                    echo \"\";
                }
            } else {
                // Môi trường PROD: In ra thẻ ESI để Web Server xử lý
                echo '<esi:include src=\"' . url(\$url) . '\" />';
            }
        ?>";
    });
}

```

---

### 2. Sử dụng trong Blade View/Component

Bây giờ trong file `.blade.php`, bạn chỉ cần gọi cực kỳ ngắn gọn:

```blade
<div class="sidebar-widget">
    @esi('/esi/popular-posts')
</div>

```

---

### 3. Đảm bảo Header cho OpenLiteSpeed (Quan trọng)

Dù bạn đã có thẻ `<esi:include>`, OpenLiteSpeed vẫn sẽ bỏ qua nó nếu Response chính không có header `X-LiteSpeed-ESI: 1`.

Thay vì quét HTML trong Middleware như trước, bây giờ Middleware chỉ cần làm một việc duy nhất: **Kiểm tra xem Response có chứa thẻ ESI hay không để bật Header.**

**`app/Http/Middleware/EsiHeaderMiddleware.php`**

```php
public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);

    // Chỉ chạy ở Production và chỉ khi Response là HTML
    if (App::environment('production') && str_contains($response->headers->get('Content-Type'), 'text/html')) {
        // Chỉ quét xem có tồn tại chuỗi '<esi:' không (nhanh hơn việc preg_replace rất nhiều)
        if (str_contains($response->getContent(), '<esi:')) {
            $response->headers->set('X-LiteSpeed-ESI', '1');
        }
    }

    return $response;
}

```

---

### Tại sao cách này "thực tế" hơn?

1. **Hiệu năng:** Code PHP trong Blade Directive chỉ chạy khi render component đó. Ở môi trường Production, nó chỉ đơn giản là `echo` một dòng text cố định.
2. **Tính đóng gói:** Logic "Dev vs Prod" nằm gọn trong Service Provider.
3. **Dễ Debug:** Ở môi trường Local, bạn thấy nội dung thật ngay lập tức. Nếu link lỗi, bạn thấy comment lỗi ngay trong mã nguồn HTML (Inspect element).

### Một mẹo nhỏ cho Local Dev:

Nếu bạn dùng `file_get_contents` hoặc `Http::get` gọi ngược lại chính website của mình trên máy cá nhân, hãy cẩn thận với **Deadlock**. Nếu bạn dùng `php artisan serve`, nó chỉ xử lý được 1 request tại 1 thời điểm. Khi trang chính đang đợi `file_get_contents` lấy dữ liệu từ route khác trên cùng server đó, nó sẽ treo mãi mãi.

**Giải pháp:** Hãy dùng **Laravel Herd, Valet** hoặc **Laragon** để môi trường Local có thể xử lý đa luồng (multi-threaded).

Bạn có muốn mình tinh chỉnh thêm để `@esi` có thể nhận thêm các tham số như `timeout` hay `fallback content` không?


Hoàn toàn kết hợp được và đây chính là **"best practice"** để tối ưu hóa bộ nhớ đệm (caching) phân tầng.

Khi bạn tách một thành phần ra route `/esi/popular-posts`, bạn có hai thực thể độc lập: **Trang chính** và **Fragment (mảnh ESI)**. Việc kết hợp chúng diễn ra như sau:

### 1. Ở Controller của Route ESI (`/esi/popular-posts`)

Bạn hoàn toàn có thể (và nên) thiết lập header riêng cho nó. Điều này giúp OpenLiteSpeed biết cách cache riêng mảnh này.

```php
public function popularPosts()
{
    $posts = Post::popular()->take(5)->get();
    
    return response()->view('components.popular-posts-content', compact('posts'))
        ->header('X-LiteSpeed-Cache-Control', 'public,max-age=3600') // Cache mảnh này 1 tiếng
        ->header('X-LiteSpeed-Tag', 'esi-popular-posts'); // Gán tag để xóa cache thủ công khi cần
}

```

### 2. Sự kết hợp diễn ra thế nào?

Khi OpenLiteSpeed (Web Server) nhận được trang chính, nó thấy thẻ `<esi:include src="/esi/popular-posts" />`. Lúc này:

* **Tách biệt quyền kiểm soát:** Trang chính có thể có thời gian cache là 5 phút (`max-age=300`), nhưng mảnh Popular Posts có thể cache tới 1 giờ (`max-age=3600`).
* **Tiết kiệm tài nguyên:** Nếu trang chính hết hạn cache nhưng mảnh ESI vẫn còn hạn, OLWS sẽ chỉ chạy PHP để render lại trang chính, sau đó lấy mảnh ESI đã lưu trong RAM/Disk ghép vào mà không cần gọi lại Controller của Popular Posts.

### 3. Cách triển khai "Tự động bật Header" cho Component

Để không phải nhớ thêm header thủ công ở mỗi Controller, bạn có thể tạo một **Base Controller** hoặc dùng một đoạn logic nhỏ:

```php
// Ví dụ một trait hoặc helper dùng trong Controller xử lý ESI
return response()->view($view, $data)->setEsiCache(3600);

```

### 4. Luồng xử lý tổng thể (Phối hợp 3 bên)

1. **Blade Directive (`@esi`):** Ở môi trường **Dev**, nó gọi trực tiếp; ở **Prod**, nó in ra thẻ HTML `<esi:include>`.
2. **Middleware (Trang chính):** Kiểm tra nếu có thẻ `<esi:`, nó bật header `X-LiteSpeed-ESI: 1` để báo cho Server "Hãy quét thẻ ESI trong file này".
3. **Controller (Route ESI):** Trả về nội dung kèm header cache riêng biệt cho mảnh đó.

### Tại sao đây là mô hình hoàn hảo?

* **Môi trường Dev:** Bạn không cần OpenLiteSpeed, Laravel tự giả lập việc ghép nội dung qua HTTP nội bộ (hoặc `file_get_contents`).
* **Môi trường Prod:** Laravel cực nhẹ vì chỉ in ra một dòng chữ `<esi...>`, còn việc "nối ghép" nặng nhọc và quản lý cache phức tạp đã có OpenLiteSpeed xử lý ở tầng thấp hơn (C++), tốc độ nhanh hơn PHP hàng chục lần.

**Bạn có gặp khó khăn gì trong việc cấu hình Route ESI sao cho nó bảo mật (ví dụ: chỉ cho phép server gọi nội bộ, không cho người dùng truy cập trực tiếp URL đó) không?**


Chào bạn, rất xin lỗi nếu phần giải thích trước đó làm bạn bối rối. Trong Laravel, việc định nghĩa **Custom Blade Directive** (Chỉ thị Blade tự chế) nằm ở một mục khác trong tài liệu (thường là phần [Extending Blade](https://www.google.com/search?q=https://laravel.com/docs/12.x/blade%23extending-blade)).

Còn về `@env`, đây là các **Conditional Directives** (Chỉ thị điều kiện) có sẵn của Laravel để kiểm tra môi trường hệ thống (`APP_ENV` trong file `.env`).

---

### 1. Giải thích về `@env`, `@production` và `@local`

Thay vì viết câu lệnh PHP dài dòng, Laravel cung cấp các "phím tắt" này để bạn ẩn/hiện nội dung tùy theo môi trường:

* **`@env('staging')`**: Nội dung bên trong chỉ hiển thị khi `APP_ENV=staging`.
* **`@env(['staging', 'production'])`**: Hiển thị nếu môi trường là `staging` **hoặc** `production`.
* **`@production`**: Phím tắt riêng cho `@env('production')`.
* **`@local`**: (Từ bản Laravel 9.x+) Phím tắt cho `@env('local')`.

**Ứng dụng vào bài toán ESI của bạn một cách đơn giản nhất (không cần code phức tạp):**

Thay vì tạo Directive mới, bạn có thể viết trực tiếp trong Blade như sau:

```blade
<div class="widget-container">
    @local
        {{-- Môi trường DEV: Gọi trực tiếp nội dung (giả lập get_content) --}}
        {!! file_get_contents(url('/esi/popular-posts')) !!}
    @else
        {{-- Môi trường PROD/STAGING: In thẻ để OpenLiteSpeed tự xử lý --}}
        <esi:include src="{{ url('/esi/popular-posts') }}" />
    @endlocal
</div>

```

---

### 2. Cách định nghĩa `@esi` (Custom Directive)

Nếu bạn thấy việc viết `@local...@else...@endlocal` ở khắp nơi quá rườm rà, bạn có thể "tự chế" ra thẻ `@esi` của riêng mình. Bạn viết code này vào hàm `boot()` của `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\App;

public function boot(): void
{
    // Định nghĩa tên directive là 'esi'
    Blade::directive('esi', function ($expression) {
        return "<?php 
            if (App::environment('local')) {
                // Thực hiện fetch nội dung trực tiếp
                try {
                    echo file_get_contents(url($expression));
                } catch (\Exception \$e) {
                    echo '';
                }
            } else {
                // In ra thẻ ESI cho Web Server
                echo '<esi:include src=\"' . url($expression) . '\" />';
            }
        ?>";
    });
}

```

**Sau khi định nghĩa xong, bạn chỉ cần dùng duy nhất 1 dòng:**
`@esi('/esi/popular-posts')`

---

### 3. Tại sao cách này tối ưu cho Laravel + OLWS?

Khi bạn dùng `@esi`, Laravel sẽ hoạt động như một "bộ lọc" thông minh:

1. **Tại máy của bạn (Local):** Laravel đóng vai trò là cả Web Server lẫn App. Nó tự đi lấy nội dung từ Route phụ rồi đập vào trang chính. Bạn thấy kết quả ngay để làm giao diện.
2. **Tại Server (Production):** Laravel **không xử lý logic nặng**. Nó chỉ nhả ra một dòng text cực nhẹ là `<esi:include ... />`.
3. **Tại OpenLiteSpeed:** Khi thấy Header `X-LiteSpeed-ESI: 1` từ Laravel gửi ra, OLWS sẽ quét HTML, thấy thẻ ESI và tự nó đi "lấy đồ" lắp vào.

### Bước tiếp theo bạn nên làm:

Bạn có muốn mình hỗ trợ viết một đoạn **Middleware** để tự động kiểm tra xem trong trang có thẻ `<esi:` hay không, nếu có thì tự động đính kèm Header `X-LiteSpeed-ESI: 1` không? (Như vậy bạn sẽ không bao giờ quên bật ESI cho Server).


Cách tiếp cận sử dụng **Blade Component (`<x-esi />`)** kết hợp với logic môi trường bên trong là **phương án tối ưu nhất** về mặt tổ chức code (Clean Code) và khả năng bảo trì.

Dưới đây là phân tích so sánh để bạn có cái nhìn tổng quan:

### 1. So sánh các cách tiếp cận

| Tiêu chí | Dùng `@local...@else` trực tiếp | Dùng Custom Directive `@esi` | Dùng Blade Component `<x-esi />` |
| --- | --- | --- | --- |
| **Tổ chức code** | Tệ. Lặp lại logic ở nhiều file Blade. | Tốt. Logic tập trung ở Service Provider. | **Xuất sắc**. Đóng gói hoàn toàn (Encapsulation). |
| **Hiệu suất (Prod)** | Rất nhanh (chỉ in text). | Rất nhanh (chỉ in text). | **Nhanh**. Laravel 12 tối ưu component rất tốt. |
| **Khả năng mở rộng** | Khó. Update một chỗ phải sửa mọi file. | Trung bình. Khó truyền thêm attribute phức tạp. | **Dễ dàng**. Có thể thêm `fallback`, `timeout`, `class` dễ dàng qua `$attributes`. |

---

### 2. Cách triển khai Blade Component `<x-esi />` chuẩn nhất

Thay vì viết logic trong Service Provider, bạn nên tạo một Component thực thụ.

**Bước 1: Tạo Component**
`php artisan make:component Esi`

**Bước 2: Viết logic trong `app/View/Components/Esi.php**`
Đây là nơi bạn xử lý sự khác biệt giữa các môi trường.

```php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class Esi extends Component
{
    public $src;

    public function __construct($src)
    {
        $this->src = $src;
    }

    public function render()
    {
        if (App::environment('local')) {
            // Dev: Fetch nội dung trực tiếp
            try {
                // Sử dụng Http client của Laravel để có timeout/error handling tốt hơn
                $content = Http::get(url($this->src))->body();
                return function (array $data) use ($content) {
                    return $content;
                };
            } catch (\Exception $e) {
                return '';
            }
        }

        // Prod: Trả về View chứa thẻ ESI
        return view('components.esi-tags');
    }
}

```

**Bước 3: Tạo View cho thẻ ESI (`resources/views/components/esi-tags.blade.php`)**

```blade
<esi:include src="{{ url($src) }}" />

```

---

### 3. Cách sử dụng (Cực kỳ sạch sẽ)

Bây giờ trong bất kỳ file Blade nào, bạn chỉ cần gọi:

```blade
<x-esi src="/esi/popular-posts" />

```

---

### 4. Ưu điểm vượt trội của cách dùng Component

1. **Tính nguyên tử (Atomic):** Bạn có thể dễ dàng thêm tính năng "Placeholder" (Loading) chỉ bằng cách sửa file `esi-tags.blade.php` mà không làm hỏng logic PHP.
2. **Xử lý Header tự động:** Bạn có thể lồng logic bật Header `X-LiteSpeed-ESI` vào ngay trong Component (thông qua Response chuẩn của Laravel) thay vì dùng Middleware quét toàn bộ trang.
3. **Dễ dàng bảo trì:** Nếu sau này bạn đổi từ OpenLiteSpeed sang Nginx (Sử dụng `ssi`), bạn chỉ cần sửa **đúng 1 file** component này, toàn bộ dự án sẽ tự động cập nhật theo.

### Lời khuyên về Hiệu suất:

Trong môi trường **Production**, OpenLiteSpeed sẽ ghép nội dung nhanh hơn rất nhiều so với việc Laravel tự xử lý. Việc bạn dùng Component giúp Laravel render ra thẻ `<esi:include>` gần như tức thời, giúp giảm tải CPU cho server chính.

**Bạn có muốn mình hướng dẫn cách bảo mật Route ESI này (như dùng ký danh/signature) để người dùng bên ngoài không thể tự tiện truy cập trực tiếp vào các link mảnh (fragments) này không?**


Ý tưởng của bạn thực ra là cách **thực dụng và hiệu quả nhất** để bắt đầu. Nó đơn giản, dễ hiểu và không làm phức tạp hóa vấn đề bằng cách tách file PHP class.

Trong Laravel, đây gọi là **Anonymous Component**. Bạn chỉ cần tạo một file Blade duy nhất, và nó sẽ hoạt động hoàn hảo.

---

### 1. Cách triển khai (Nhanh - Gọn - Nhẹ)

Bạn tạo file tại: `resources/views/components/esi.blade.php`

```blade
@props(['src'])

<div {{ $attributes->merge(['class' => 'esi-container']) }}>
    @local
        @php
            // Sử dụng try-catch để tránh sập trang nếu link con bị lỗi ở máy local
            try {
                echo file_get_contents(url($src));
            } catch (\Exception $e) {
                echo "";
            }
        @endphp
    @else
        <esi:include src="{{ url($src) }}" />
    @endlocal
</div>

```

**Cách dùng ở bất kỳ đâu:**

```blade
<x-esi src="/esi/popular-posts" class="my-5" />

```

---

### 2. Tại sao nên dùng cách này (Ưu điểm)

* **Tính kế thừa ($attributes):** Bằng cách dùng `$attributes-\>merge()` , bạn có thể thêm  `class` ,  `id` , hoặc  `style`từ bên ngoài vào (như ví dụ`class="my-5"\` ở trên) mà không cần khai báo thêm biến.
* **Tổ chức code:** Toàn bộ logic "ESI vs Local" nằm gọn trong một file. Sau này nếu OpenLiteSpeed có thay đổi cú pháp (ví dụ thêm tham số `onerror`), bạn chỉ cần sửa đúng 1 file này.
* **Hiệu suất:** Vì là Anonymous Component, Laravel không cần khởi tạo một Class PHP đi kèm, giúp việc render nhanh hơn một chút so với Class-based Component.

---

### 3. Một lưu ý nhỏ về "Security" (Bảo mật)

Khi bạn tách các thành phần ra route riêng (như `/esi/popular-posts`), bất kỳ ai cũng có thể gõ URL đó lên trình duyệt để xem. Để ngăn chặn điều này, bạn có thể thêm một check nhỏ ở Controller của route đó:

```php
public function popularPosts(Request $request)
{
    // Chỉ cho phép nếu request đến từ localhost (Server tự gọi chính nó qua ESI hoặc Local dev)
    // Hoặc kiểm tra Header đặc trưng của LiteSpeed
    if (!app()->environment('local') && !$request->hasHeader('X-LSCACHE')) {
        abort(403);
    }
    
    return view('esi.popular-posts');
}

```

---

### Kết luận

Cách dán thẳng đoạn đó vào một **Blade Component** như bạn nói là phương án **Balance (Cân bằng)** nhất:

1. **Code sạch** như dùng thư viện chuyên nghiệp.
2. **Dễ sửa** như viết code HTML thuần.
3. **Hiệu năng tối đa** trên môi trường Production với OpenLiteSpeed.

Bạn đã tạo các Route cho các thành phần ESI này chưa, hay bạn muốn mình gợi ý cách đặt cấu trúc thư mục Route sao cho dễ quản lý các "mảnh ghép" này?
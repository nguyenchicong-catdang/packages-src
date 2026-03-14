# tham khảo
```php
use Illuminate\Support\Facades\Cache;

Route::post('/esi/sidebar/update', function () {
    // Chỉ cho phép 1 tiến trình update chạy, khóa trong 60s để tránh "spam"
    return Cache::withoutOverlapping('update-sidebar-lock', function () {
        
        $fileName = 'sidebar.php';
        $filePath = Storage::path($fileName);

        // Logic render và ghi file ở đây...
        // (Hoặc đơn giản là xóa file để SidebarEsi tự sinh lại)
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return response()->json(['message' => 'Sidebar đã được làm mới!']);
        
    }, 60); 
});
```
# ghi đè
```php
Route::post('/esi/sidebar/update', function () {
    return Cache::withoutOverlapping('update-sidebar-lock', function () {
        $fileName = 'sidebar.php';
        $filePath = Storage::path($fileName);
        $backupKey = 'sidebar_fallback_content';

        // 1. Render nội dung mới ngay tại đây
        $service = app(\Vendorpath\Wp\Components\Sidebars\SidebarService::class);
        $html = view('wp-view::components.sidebar', ['data' => $service->toArray()])->render();

        // 2. Ghi ra file tạm và RENAME (Ghi đè tức thì)
        $content = "<?php return " . var_export($html, true) . ";";
        $tempPath = $filePath . '.' . uniqid() . '.tmp';
        
        file_put_contents($tempPath, $content);
        
        // Thao tác này thay thế file cũ bằng file mới mà không có giây phút nào file bị mất
        rename($tempPath, $filePath);

        // 3. Cập nhật Fallback Cache (Redis/DB) để đồng bộ
        Cache::put($backupKey, $html, 3600);

        // 4. Xóa OPcache để PHP nhận file mới ngay
        if (function_exists('opcache_invalidate')) {
            @opcache_invalidate($filePath, true);
        }

        return response()->json(['status' => 'success', 'message' => 'Sidebar đã được làm mới!']);
    }, 60);
});
```
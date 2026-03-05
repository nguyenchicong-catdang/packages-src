<?php

namespace Vendorpath\Wp\Components\Sidebars;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class SidebarEsi
{
    /**
     * Thay đổi return type từ string sang Response để gửi kèm Header
     */
    public static function getHtml(): Response
    {
        $fileName = 'sidebar.php';
        $filePath = Storage::path($fileName);
        $backupKey = 'sidebar_fallback_content';

        // 1. Ưu tiên số 1: File vật lý (OPcache hỗ trợ)
        if (file_exists($filePath)) {
            return response(include($filePath))
                ->header('Cache-Control', 'public, max-age=86400');
        }

        // 2. Thử lấy Lock để sinh file mới
        $lock = Cache::lock('run-query-sidebar', 40);

        if ($lock->get()) {
            try {
                ignore_user_abort(true);
                set_time_limit(30);

                $service = app(SidebarService::class);
                $html = view('wp-view::esi.sidebar', ['data' => $service->toArray()])->render();

                // Ghi file PHP (Dùng hàm thuần PHP để đảm bảo tối đa hiệu năng và atomic)
                $content = "<?php return " . var_export($html, true) . ";";
                $tempPath = $filePath . '.' . uniqid() . '.tmp';

                if (file_put_contents($tempPath, $content) !== false) {
                    rename($tempPath, $filePath);
                    if (function_exists('opcache_invalidate')) {
                        @opcache_invalidate($filePath, true);
                    }

                    // Cập nhật luôn fallback cache để dùng cho lần update sau
                    Cache::put($backupKey, $html, 3600);
                }

                return response($html)->header('Cache-Control', 'public, max-age=60');
            } finally {
                $lock->release();
            }
        }

        // 3. Ưu tiên số 2: Nếu đang bị lock, lấy hàng từ Cache Remember (HTML cũ)
        $fallback = Cache::get($backupKey);
        if ($fallback) {
            return response($fallback)->header('Cache-Control', 'public, max-age=60');
        }
        // xóa cache fallback nếu file đã tồn tại để tránh dùng cache cũ khi đã có file mới
        // DELETE FROM cache WHERE expiration < UNIX_TIMESTAMP();

        // 4. Cuối cùng: Placeholder (Chỉ xuất hiện khi Deploy lần đầu hoặc Cache Redis chết)
        return response(self::placeholder())->header('Cache-Control', 'public, max-age=10');
    }

    private static function placeholder(): string
    {
        return '
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">A simple default list group item</a>
            </div>
        ';
    }
}

<?php
namespace Vendorpath\Wp\Esi\Sidebars;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SidebarEsi
{
    public static function esi()
    {
        $fileName = 'sidebar.php';
        $filePath = Storage::path($fileName);
        // 1. Ưu tiên số 1: File vật lý (OPcache hỗ trợ)
        if (file_exists($filePath)) {
            return response(include($filePath))
                ->header('Cache-Control', 'public, max-age=86400');
        }

        // 2. Thử lấy Lock để sinh file mới
        $lock = Cache::lock('lock-query', 40);
        if ($lock->get()) {
            Log::debug('Lock acquired for generating sidebar ESI content' . $lock->get());

            try {
                // GIẢ LẬP: Treo máy 10 giây để "dụ" các request khác vào chiếm lock
                sleep(3);

                ignore_user_abort(true);
                set_time_limit(30);

                $service = app(SidebarService::class);
                $html = view('wp-view::esi.sidebar', ['data' => $service->service()])->render();

                // Ghi file PHP (Dùng hàm thuần PHP để đảm bảo tối đa hiệu năng và atomic)
                $content = "<?php return " . var_export($html, true) . ";";
                $tempPath = $filePath . '.' . uniqid() . '.tmp';

                if (file_put_contents($tempPath, $content) !== false) {
                    rename($tempPath, $filePath);
                    if (function_exists('opcache_invalidate')) {
                        @opcache_invalidate($filePath, true);
                    }

                    return response($html)->header('Cache-Control', 'public, max-age=60');
                }
            } finally {
                $lock->release();
            }
        }
        // 3. Ưu tiên số 2: Nếu đang bị lock, lấy hàng từ Cache Remember (HTML cũ)
        return response('Hệ thông đang cập nhật, vui long F5 sau 1 phút')->header('Cache-Control', 'public, max-age=60');
    }
}
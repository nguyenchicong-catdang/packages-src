<?php

namespace Vendorpath\Wp\Esi\Navbars;

use Illuminate\Support\Facades\Storage;

class NavbarEsi
{
    public static function esi()
    {
        $fileName = 'navbar.php';
        $filePath = Storage::path($fileName);
        // 1. Ưu tiên số 1: File vật lý (OPcache hỗ trợ)
        if (file_exists($filePath)) {
            return response(include($filePath))
                ->header('Cache-Control', 'public, max-age=86400');
        }
        // kiểm tra file lock
        if (\Vendorpath\Wp\Utils\LockFile::canProceed()) {
            try {
                ignore_user_abort(true);
                set_time_limit(30);

                $service = app(NavbarService::class);
                $html = view('wp-view::esi.navbar', ['data' => $service->service()])->render();

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
                // Không cần release gì cả vì LockFile đã tự động hết hạn
            }
        }
        return response('Hệ thông đang cập nhật, vui long F5 sau 1 phút')->header('Cache-Control', 'public, max-age=60');
    }
}

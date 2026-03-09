<?php

namespace Vendorpath\Wp\Esi\Sidebars;

use Illuminate\Support\Facades\Storage;

class SidebarEsi
{
    public static function esi()
    {
        $fileName = 'sidebar.php';
        $filePath = Storage::path($fileName);
        if (file_exists($filePath)) {
            return response(include($filePath))
                ->header('Cache-Control', 'public, max-age=86400');
        }
        if (\Vendorpath\Wp\Utils\LockFile::canProceed()) {
            try {
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
                // Không cần release gì cả vì LockFile đã tự động hết hạn
                // flock($fp, LOCK_UN);
                // fclose($fp);
            }
        }
        return response('Hệ thông đang cập nhật, vui long F5 sau 1 phút')->header('Cache-Control', 'public, max-age=60');
    }
}

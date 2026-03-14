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

        // TRƯỜNG HỢP 1: OPcache sẽ xử lý cực nhanh ở đây
        if (file_exists($filePath)) {
            return response(include($filePath))
                ->header('Cache-Control', 'public, max-age=86400');
        }

        // 2. Dùng block(5) để đợi tối đa 5 giây nếu có thằng khác đang tạo file
        $lock = Cache::lock('run-query-sidebar', 40); // Lock 20s để dư sức cho PHP chạy
        if ($lock->get()) {
            try {
                // Đợi tối đa 5s để lấy lock, tránh trả về placeholder quá sớm
                ignore_user_abort(true);
                set_time_limit(30); // Nhỏ hơn lock time (30s)

                // Check lại lần nữa sau khi chờ lock
                // if (file_exists($filePath)) {
                //     return response(include($filePath))
                //         ->header('Cache-Control', 'public, max-age=86400');
                // }

                $service = app(SidebarService::class);
                $html = view('wp-view::components.sidebar', ['data' => $service->toArray()])->render();
    
                // Ghi file PHP an toàn
                $content = "<?php return " . var_export($html, true) . ";";
    
                // 1. Ghi nội dung vào file tạm (.tmp)
                $tempFileName = $fileName . '.tmp';
                Storage::put($tempFileName, $content);
    
                // 2. Lấy đường dẫn full để thực hiện rename
                $tempPath = Storage::path($tempFileName);
                $finalPath = Storage::path($fileName);
    
                // 3. Đổi tên file (Thao tác này cực nhanh và an toàn)
                if (file_exists($tempPath)) {
                    rename($tempPath, $finalPath);
                }
    
                return response($html)->header('Cache-Control', 'public, max-age=60');
            } finally {
                $lock->release();
            }
        }
        // TRƯỜNG HỢP 3: Không lấy được khóa (Lock bị chiếm)
        // Trả về placeholder và cho phép Varnish/Proxy cache trong 1 phút
        return response(self::placeholder())
            ->header('Cache-Control', 'public, max-age=60');
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

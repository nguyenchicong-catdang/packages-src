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
        $fileName = 'sidebar.html';
        // dd(Storage::path($fileName));

        // TRƯỜNG HỢP 1: File đã tồn tại (Đã qua bước khởi tạo)
        if (Storage::exists($fileName)) {
            return response(Storage::get($fileName))
                ->header('Cache-Control', 'public, max-age=86400'); // Cache dài hạn (24h)
        }

        // 2. Nếu chưa có file, dùng Atomic Lock để giành quyền Query
        $lock = Cache::lock('run-query-sidebar', 10);

        if ($lock->get()) {
            try {
                // 1. Chống ngắt quãng khi đang ghi file
                ignore_user_abort(true);

                // 2. Giới hạn thời gian chạy (ví dụ 30 giây)
                set_time_limit(30);

                if (Storage::exists($fileName)) {
                    return response(Storage::get($fileName))
                        ->header('Cache-Control', 'public, max-age=86400');
                }

                $service = app(SidebarService::class);
                $data = $service->toArray();
                $html = view('wp-view::components.sidebar', ['data' => $data])->render();

                Storage::put($fileName, $html);

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

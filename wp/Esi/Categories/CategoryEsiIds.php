<?php
namespace Vendorpath\Wp\Esi\Categories;

use Illuminate\Support\Facades\Storage;

class CategoryEsiIds
{
    public function esi()
    {
        $fileName = 'categories_ids.php';
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

                $service = app(CategoryService::class);
                $dataIds = $service->serviceIds();
                dd($dataIds);

            } finally {

            }
        }

        return response('Hệ thông đang cập nhật, vui long F5 sau 1 phút')->header('Cache-Control', 'public, max-age=60');
    }
}
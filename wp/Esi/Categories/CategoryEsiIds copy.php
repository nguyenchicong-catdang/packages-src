<?php
namespace Vendorpath\Wp\Esi\Categories;

use Illuminate\Support\Facades\Storage;

class CategoryEsiIds
{
    public function esi($slug = null)
    {
        $fileName = "categories_$slug.php";
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

                $service = app(CategoryService::class)->service($slug);
                $dataIds = $service->ids;
                dd($dataIds);
                // var_export($data, true) sẽ chuyển mảng thành một chuỗi code PHP hợp lệ
                $content = "<?php return " . var_export($dataIds, true) . ";";
                $tempPath = $filePath . '.' . uniqid() . '.tmp';

                if (file_put_contents($tempPath, $content) !== false) {
                    rename($tempPath, $filePath);
                }
                return response('$content')->header('Cache-Control', 'public, max-age=60');

            } finally {

            }
        }

        return response('Hệ thông đang cập nhật, vui long F5 sau 1 phút')->header('Cache-Control', 'public, max-age=60');
    }
}
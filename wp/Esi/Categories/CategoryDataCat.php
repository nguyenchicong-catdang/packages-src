<?php

namespace Vendorpath\Wp\Esi\Categories;

use Illuminate\Support\Facades\Storage;

class CategoryDataCat
{
    public function getData($slug = "")
    {
        $fileName = "categories/cat_data.php";
        $dataCat = [];
        if ($slug) {
            $fileName = "categories/$slug/cat_data_$slug.php";
        }
        $filePath = Storage::path($fileName);
        // 1. Ưu tiên số 1: File vật lý (OPcache hỗ trợ)
        if (file_exists($filePath)) {
            $dataCat = include($filePath);
            return $dataCat;
        }
        // kiểm tra file lock
        if (\Vendorpath\Wp\Utils\LockFile::canProceed()) {
            try {
                ignore_user_abort(true);
                set_time_limit(30);

                // get data
                $service = app(CategoryService::class)->service($slug);
                $dataCat = $service->data_cat;
                dd($dataCat);
                // var_export($data, true) sẽ chuyển mảng thành một chuỗi code PHP hợp lệ
                $content = "<?php return " . var_export($dataCat, true) . ";";
                $tempPath = $filePath . '.' . uniqid() . '.tmp';

                // Lấy đường dẫn thư mục cha của file
                $directory = dirname($filePath);

                // KIỂM TRA VÀ TẠO THƯ MỤC NẾU CHƯA CÓ
                if (!is_dir($directory)) {
                    // true ở tham số thứ 3 cho phép tạo thư mục phân cấp (recursive)
                    mkdir($directory, 0755, true);
                }
                // Thực hiện ghi file tạm

                if (file_put_contents($tempPath, $content) !== true) {
                    rename($tempPath, $filePath);
                }
                return $dataCat;
            } finally {
            }
        }

        return $dataCat;
    }
}

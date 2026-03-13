<?php

namespace Vendorpath\Wp\Esi\Categories;

use Illuminate\Support\Facades\Storage;

class CategoryDataCat
{
    public function getData($slug = "")
    {
        $fileName = "categories/data_cat.php";
        $dataCat = [];
        if ($slug) {
            $fileName = "categories/$slug/data_cat_$slug.php";
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
                // xử lý description
                $description = $dataCat['description'] ?? '';
                $parseDescription = app(CategoryActionParseDescription::class)->action($description);
                // thay thế $dataCat
                // $dataCat['description'] = $description['clean_content'];
                // them mới seo_img
                // $dataCat['seo_img'] = $description['first_image_src'];
                $dataCat = array_merge($dataCat, $parseDescription);
                // xư lý data dev
                if (isset($dataCat['dev'])) {
                    unset($dataCat['dev']);
                }
                // dd($description);
                // dd($dataCat);
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

                if (file_put_contents($tempPath, $content) !== false) {
                    rename($tempPath, $filePath);
                    // Tùy chọn: Xóa cache OPcache để cập nhật ngay lập tức
                    if (function_exists('opcache_invalidate')) {
                        opcache_invalidate($filePath, true);
                    }
                }
                return $dataCat;
            } finally {
            }
        }

        return $dataCat;
    }
}

<?php
namespace Vendorpath\Wp\Esi\Categories;

use Illuminate\Support\Facades\Storage;

class CategoryDataIds
{
    public function __construct(
        protected CategoryLoader $loader
    )
    {
    }
    public function getData($slug = "")
    {
        $fileName = "categories/data_ids.php";
        $dataIds = [];
        if ($slug) {
            $fileName = "categories/$slug/data_ids_$slug.php";
        }

        $filePath = Storage::path($fileName);

        // 1. Ưu tiên số 1: File vật lý (OPcache hỗ trợ)
        if (file_exists($filePath)) {
            $dataIds = include($filePath);
            // dd($dataIds);
            return $dataIds;
        }

        // kiểm tra file lock
        if (\Vendorpath\Wp\Utils\LockFile::canProceed()) {
            try {

                ignore_user_abort(true);
                set_time_limit(30);
                // get data
                // $service = app(CategoryService::class)->service($slug);
                $dataIds = $this->loader->data_ids;
                // dd($dataIds);
                $content = "<?php return ". var_export($dataIds, true) . ";";
                $tempPath = $filePath . '.' . uniqid() . '.tmp';

                // Lấy đường dẫn thư mục cha của file
                $directory = dirname($filePath);
                // KIỂM TRA VÀ TẠO THƯ MỤC NẾU CHƯA CÓ
                if (!is_dir($directory)) {
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
                return $dataIds;
            } finally {

            }
        }
        return $dataIds;
    }
}
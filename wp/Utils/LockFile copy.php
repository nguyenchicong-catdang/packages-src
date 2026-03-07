<?php

namespace Vendorpath\Wp\Utils;

use Illuminate\Support\Facades\Storage;

class LockFile
{
    private static $fileName = 'lock_app.php';
    private static $cacheTime = 10; // Nên để 10s để bù đắp độ trễ hệ thống

    public static function canProceed()
    {
        $path = Storage::path(self::$fileName);
        $now = time();

        // 1. Kiểm tra nhanh (Nếu file đang trong hạn lock thì té luôn)
        if (file_exists($path)) {
            $expireAt = include($path);
            if ($expireAt && $now < $expireAt) {
                return false;
            }
        }

        // 2. CHIẾM QUYỀN KHỞI TẠO (Atomic & Non-blocking)
        $fp = fopen($path, 'c+'); // Mở file (tạo mới nếu chưa có)

        // Thử chiếm khóa độc quyền, nếu có ông đang giữ thì "té" ngay (LOCK_NB)
        if (!flock($fp, LOCK_EX | LOCK_NB)) {
            fclose($fp);
            return false; // Có ông khác đang ghi rồi, mình rút!
        }

        // Nếu lọt xuống đây, nghĩa là CHỈ MÌNH BẠN đang cầm khóa
        try {
            $content = "<?php return " . ($now + self::$cacheTime) . ";";
            ftruncate($fp, 0);      // Xóa nội dung cũ
            fwrite($fp, $content);  // Ghi thời hạn mới
            fflush($fp);            // Đẩy dữ liệu xuống ổ cứng
        } finally {
            flock($fp, LOCK_UN);    // Nhả khóa
            fclose($fp);
        }

        return true;
    }
}

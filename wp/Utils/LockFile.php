<?php

namespace Vendorpath\Wp\Utils;

use Illuminate\Support\Facades\Storage;

class LockFile
{
    private static $fileName = 'lock_app.php';
    private static $cacheTime = 2; // Nên để 10s để bù đắp độ trễ hệ thống

    public static function canProceed()
    {
        $path = Storage::path(self::$fileName);
        $now = time();

        // 1. Kiểm tra nhanh bên ngoài (Chặn 90% traffic mà không cần mở file)
        if (file_exists($path)) {
            $expireAt = @include($path); // Dùng @ để tránh warning nếu file đang bị ghi
            if ($expireAt && $now < $expireAt) {
                return false;
            }
        }

        // 2. Mở file và chiếm khóa ngay
        $fp = fopen($path, 'c+');
        if (!$fp) return false;

        // Chiếm khóa độc quyền, ông nào đến sau là "văng" luôn
        if (!flock($fp, LOCK_EX | LOCK_NB)) {
            fclose($fp);
            return false;
        }

        try {
            // 3. QUAN TRỌNG: Kiểm tra lại một lần nữa khi đã ở trong khóa
            // Đọc thủ công để tránh cache của include
            rewind($fp);
            $data = stream_get_contents($fp);
            if (preg_match('/return (\d+);/', $data, $matches)) {
                $expireAt = (int)$matches[1];
                if ($now < $expireAt) {
                    return false; // Ông trước vừa mới ghi xong rồi, mình rút!
                }
            }

            // 4. Ghi đè thời gian mới
            $content = "<?php return " . ($now + self::$cacheTime) . ";";
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, $content);
            fflush($fp); // Ép dữ liệu xuống đĩa ngay lập tức

            return true;
        } finally {
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
}

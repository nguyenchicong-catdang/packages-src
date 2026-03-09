<?php

namespace Vendorpath\Wp\Utils;

use Illuminate\Support\Facades\Storage;


class LockFile
{
    private static $fileTime = 'lock_app.php';
    private static $fileLock = 'lock_setup.lock';
    private static $cacheTime = 1; // Nên để 10s để bù đắp độ trễ hệ thống

    public static function canProceed()
    {
        $pathTime = Storage::path(self::$fileTime);
        $pathLock = Storage::path(self::$fileLock);
        $now = time();

        // 1. Kiểm tra nhanh bên ngoài (Chặn 90% traffic mà không cần mở file)
        if (file_exists($pathTime)) {
            $expireAt = file_get_contents($pathTime); // Dùng @ để tránh warning nếu file đang bị ghi
            // dd(gettype((int) $expireAt));
            if ($expireAt && $now < (int) $expireAt) {
                return false;
            }
        }

        // 2. Mở file và chiếm khóa ngay
        $fp = fopen($pathLock, 'c+');

        // Chiếm khóa độc quyền, ông nào đến sau là "văng" luôn
        if (!flock($fp, LOCK_EX | LOCK_NB)) {
            fclose($fp);
            return false;
        }

        try {
            ignore_user_abort(true);
            set_time_limit(30);
            // 3. QUAN TRỌNG: Kiểm tra lại một lần nữa khi đã ở trong khóa
            // Đọc thủ công để tránh cache của include
            if (file_exists($pathTime)) {
                $expireAt = file_get_contents($pathTime); // Dùng @ để tránh warning nếu file đang bị ghi
                if ($expireAt && $now < (int) $expireAt) {
                    return false;
                }
            }

            // 4. Ghi đè thời gian mới
            $content = $now + self::$cacheTime;
            $tempPath = $pathTime . '.'  . uniqid() . '.tmp';

            // ghi file
            if(file_put_contents($tempPath, $content) !== false) {
                rename($tempPath, $pathTime);
            }
            return true;
        } finally {
            flock($fp, LOCK_UN);
            fclose($fp);
        }
        return false;
    }
}

<?php
namespace Vendorpath\Wp\MockData;

class MockDataDir
{
    private static $dir = __DIR__ . '/share_data/';

    public static function makeDir(): string
    {
        if (!is_dir(self::$dir)) {
            mkdir(self::$dir, 0755, true);
        }

        return self::$dir;
    }
}
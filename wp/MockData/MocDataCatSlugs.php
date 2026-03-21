<?php
namespace Vendorpath\Wp\MockData;

class MocDataCatSlugs
{
    private static $name = 'cat_slugs';
    private static $listPosts = 'cat_lists';

    private static function getFilePath(): string
    {
        // MockDataDir::makeDir() => return directory    
        return MockDataDir::makeDir() . self::$name . '.php';
    }

    private static function getFileListPosts(): string
    {
        // MockDataDir::makeDir() => return directory    
        return MockDataDir::makeDir() . self::$listPosts . '.php';
    }

    public static function fakeData()
    {
        $dataListPosts = [];
        $data = [];
        // Kiểm tra file có đọc được không trước khi include
        if (is_readable(self::getFileListPosts())) {
            $dataListPosts = include(self::getFileListPosts());
        }
        $dataSlugs = array_map(fn($slug) => $slug['slug'] ?? '', $dataListPosts);
        $data = array_filter($dataSlugs);
        return $data;
    }
    // \Vendorpath\Wp\MockData\MocDataCatSlugs::fakeData();

    public static function makeFile()
    {
        $data = self::fakeData();
        $content = "<?php return " . var_export($data, true) . ";";
        file_put_contents(self::getFilePath(), $content);
        return $data;
    }
    // \Vendorpath\Wp\MockData\MocDataCatSlugs::makeFile();

    public static function mockData(bool $force = false)
    {
        if ($force || !file_exists(self::getFilePath())) {
            return self::makeFile();
        }

        // Kiểm tra file có đọc được không trước khi include
        if (is_readable(self::getFilePath())) {
            return include(self::getFilePath()) ;
        }

        return [];
    }
    // \Vendorpath\Wp\MockData\MocDataCatSlugs::mockData();

}
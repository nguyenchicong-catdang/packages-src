<?php
namespace Vendorpath\Wp\MockData;

class MocDataEsiCatLists
{
    protected static $limit = 2;
    
    private static function fakeDataSlugs()
    {
        return \Vendorpath\Wp\MockData\MocDataCatSlugs::mockData();
    }
    // \Vendorpath\Wp\MockData\MocDataEsiCatLists::fakeData();

    private static function fakeDataCatSlugs()
    {
        // 1. Lấy dữ liệu thô
        $allSlugs = self::fakeDataSlugs();
        $allData = \Vendorpath\Wp\MockData\MockCatListsData::mockData();

        // 2. Tính toán phân trang
        $page = (int) request('page', 1);
        $offset = self::$limit * ($page - 1);

        // 3. Cắt cả 2 mảng theo cùng một vị trí offset và limit
        $slicedSlugs = array_slice($allSlugs, $offset, self::$limit);
        $slicedData = array_slice($allData, $offset, self::$limit);

        // 4. Kết hợp chúng lại
        $result = [];
        foreach ($slicedSlugs as $index => $slug) {
            $result[] = [
                'slug'      => $slug,
                // Lấy phần tử tương ứng từ mảng data đã cắt
                'slug_data' => $slicedData[$index] ?? null
            ];
        }

        return $result;
    }

    private static function fakeDataPagination()
    {
        $totalItems = count(self::fakeDataSlugs());
        $page = request('page', 1);
        return [
            'total_items' => $totalItems,
            'total_pages' => (int) min(ceil($totalItems / self::$limit), 10),
            'current_page' => $page,

        ];
    }

    public static function mockData()
    {
        return [
            'slugs' => self::fakeDataCatSlugs(),
            'pagination' => self::fakeDataPagination()
        ];
    }
    // \Vendorpath\Wp\MockData\MocDataEsiCatLists::mockData();
}
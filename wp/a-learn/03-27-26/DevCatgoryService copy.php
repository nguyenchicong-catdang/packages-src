<?php
namespace Vendorpath\Wp\DevFrontend\Categories;

use Illuminate\Http\Request;


class DevCatgoryService
{
    public function __construct(
        protected Request $request
    )
    {
    }

    public function service(): array
    {
        // $slug = $this->request->route('slug');
        $page = (int) $this->request->query('page', 1); // Dùng tham số thứ 2 của query làm default
        $limit = 3;
        $offset = $limit * ($page - 1);

        $allData = $this->fakeData();

        // CHỈ CẮT PHẦN CẦN THIẾT
        // Dùng preserve_keys = true nếu bạn cần giữ ID gốc của phần tử
        $pagedData = array_slice($allData['slugs'], $offset, $limit);

        // pagination
        $totalItems = count($allData['slugs']);

        return [
            'cat_card'    => $allData['cat_card'],
            'cat_lists' => [
                'slugs'       => $pagedData, // Mảng đã được cắt nhỏ (chỉ còn 2 phần tử)
                'pagination' => [
                    'total_items' => $totalItems,
                    'total_pages' => (int) min(ceil($totalItems / $limit), 10),
                    'current_page' => $page,
                ]
            ],
        ];
    }

    public function fakeData()
    {
        $dataSlugs = \Vendorpath\Wp\MockData\MocDataCatSlugs::mockData();
        $dataCatCard = \Vendorpath\Wp\MockData\MockDataCatCard::mockData();
        return [
            'cat_card' => $dataCatCard,
            'slugs' => $dataSlugs,
            // 'total_items' => count($dataSlugs),
        ];
    }
}
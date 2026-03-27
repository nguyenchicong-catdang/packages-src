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
        $limit = 2;
        $offset = $limit * ($page - 1);

        $allData = $this->fakeData();

        // CHỈ CẮT PHẦN CẦN THIẾT
        // Dùng preserve_keys = true nếu bạn cần giữ ID gốc của phần tử
        $pagedSlugsData = array_slice($allData['slugs'], $offset, $limit);
        $pagedListsData = array_slice($allData['cat_lists'], $offset, $limit);
        // xử lý lại slug
        // $slug_data = array_map(function($slug) {

        // }, $pagedListsData);
        // 4. Kết hợp chúng lại
        $result = [];
        foreach($pagedSlugsData as $index => $slug) {
            $result[] = [
                'slug' => $slug,
                'slug_data' => $pagedListsData[$index] ?? ''
            ];
        }


        // pagination
        $totalItems = count($allData['slugs']);

        return [
            'cat_card'    => $allData['cat_card'],
            'cat_lists' => [
                'slugs'       => $result, // Mảng đã được cắt nhỏ (chỉ còn 2 phần tử)
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
        $dataCatLists = \Vendorpath\Wp\MockData\MockCatListsData::mockData();

        return [
            'cat_card' => $dataCatCard,
            'slugs' => $dataSlugs,
            'cat_lists' => $dataCatLists,
        ];
    }
}
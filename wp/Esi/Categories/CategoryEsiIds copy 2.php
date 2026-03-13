<?php
namespace Vendorpath\Wp\Esi\Categories;

class CategoryEsiIds
{
    public function esi($slug = "")
    {
        $dataIds = app(CategoryDataIds::class)->getData($slug);
        // dd($dataIds);
        if ($dataIds) {
            return view('wp-view::esi.category-ids', ['data' => $dataIds]);
        }

        return response('Hệ thông đang cập nhật, vui long F5 sau 1 phút')->header('Cache-Control', 'public, max-age=60');
    }
}
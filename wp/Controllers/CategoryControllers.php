<?php
namespace Vendorpath\Wp\Controllers;

use App\Http\Controllers\Controller;
use Vendorpath\Wp\Esi\Categories\CategoryService;

class CategoryControllers extends Controller
{
    public function show($slug, CategoryService $service)
    {
        $dataCat = $service->getDataCat($slug);
        // $dataIds = $service->getDataIds($slug);
        
        return view('wp-view::category', [
            'data_cat' => $dataCat,
            // 'data_ids' => $dataIds
        ]);
    }
}
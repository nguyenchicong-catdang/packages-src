<?php
namespace Vendorpath\Wp\DevFrontend\Categories;

use App\Http\Controllers\Controller;

class DevCategoryController extends Controller
{
    public function show(DevCatgoryService $service)
    {
        $data =$service->service();
        // dd($data);
        return view('dev-view::category', ['data' => $data]);
    }
}
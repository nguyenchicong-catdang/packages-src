<?php
namespace Vendorpath\Wp\Categories;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function show()
    {
        return view('wp-view::category');
    }
}
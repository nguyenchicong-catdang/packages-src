<?php
// Categories/CategoryController.php
namespace Vendorpath\Wp\Categories;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function show($slug, CategoryService $service)
    {
        $data = $service->toArray($slug);
        return view('wp-view::category', [
            'cat' => (object) $data['cat'],
            'posts' => (object) $data['posts']
            ]);
    }
}
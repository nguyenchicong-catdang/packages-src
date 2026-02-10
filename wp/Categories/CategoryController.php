<?php
namespace Vendorpath\Wp\Categories;

use Illuminate\View\View;


class CategoryController
{
    public function show($slug, CategoryService $service): View
    {
        $data = $service->show($slug);
        return view('wp-view::category', ['cat' => $data]);
    }
}
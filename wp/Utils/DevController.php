<?php
namespace Vendorpath\Wp\Utils;

class DevController
{
    public function dev()
    {
        return 'Route dev';   
    }
    public function category()
    {
        $slug = 'thung-rac';
        // $slug = 'rank-math';
        // $slug = 'no-thing';
        // $service = \Vendorpath\Wp\Esi\Categories\CategoryService::class;
        // $data = app($service)->service($slug);
        $ids = app(\Vendorpath\Wp\Esi\Categories\CategoryEsiIds::class)->esi($slug);
        dd($ids);
        // $view = 'wp-view::esi.navbar';
        // return view($view, ['data' => $data]);
        return 'acb';
    }

    public function dataCat()
    {
        // $slug = 'uncategorized';
        $slug = 'thung-rac';
        $data = app(\Vendorpath\Wp\Esi\Categories\CategoryDataCat::class)->getData($slug);
        return view('wp-view::category', ['data' => $data]);
    }

    public function dataIds()
    {
        // $slug = 'uncategorized';
        $slug = 'thung-rac';
        $data = app(\Vendorpath\Wp\Esi\Categories\CategoryDataIds::class)->getData($slug);
        // dd($data);
        return view('wp-view::esi.category-ids', ['data' => $data]);
    }
}
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
        // $view = 'wp-view::esi.navbar';
        // return view($view, ['data' => $data]);
        return 'acb';
    }

    public function catData()
    {
        $slug = 'thung-rac';
        $data = app(\Vendorpath\Wp\Esi\Categories\CategoryDataCat::class)->getData($slug);
        return view('wp-view::category', ['data' => $data]);
    }
}
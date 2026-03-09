<?php
namespace Vendorpath\Wp\Utils;

class DevController
{
    public function dev()
    {
        $service = \Vendorpath\Wp\Esi\Categories\CategoryService::class;
        $data = app($service)->serviceIds();
        dd($data);
        $view = 'wp-view::esi.navbar';
        return view($view,['data' => $data]);
    }
}
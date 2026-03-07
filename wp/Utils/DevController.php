<?php
namespace Vendorpath\Wp\Utils;

class DevController
{
    public function dev()
    {
        $service = \Vendorpath\Wp\Esi\Navbars\NavbarService::class;
        $data = app($service)->service();
        $view = 'wp-view::esi.navbar';
        return view($view,['data' => $data]);
    }
}
<?php
// wp/Components/Sidebars/SidebarServiceProvider.php
namespace Vendorpath\Wp\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

class SidebarComponent extends Component
{
    public function render(): View
    {
        \Fruitcake\LaravelDebugbar\Facades\Debugbar::startMeasure('load_service', 'Thời gian tải Sidebar Service');

        $service = app(\Vendorpath\Wp\Components\Sidebars\SidebarService::class);
        $data = $service->toAray();

        \Fruitcake\LaravelDebugbar\Facades\Debugbar::stopMeasure('load_service');
        // Trỏ về file: wp/views/components/sidebar.blade.php
        return view('wp-view::components.sidebar', ['data' => $data]);
    }
}
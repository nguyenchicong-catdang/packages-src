<?php
// wp/Components/Sidebars/SidebarService.php
namespace Vendorpath\Wp\Components\Sidebars;

class SidebarService
{
    public function toArray(): array
    {
        $data = app(SidebarLoader::class)->getDataSidebar();
        \Fruitcake\LaravelDebugbar\Facades\Debugbar::startMeasure('SidebarActionWithClasses', 'Thời gian tải SidebarActionWithClasses');
        $dataAddClass = app(SidebarActionWithClasses::class)->addClass($data);
        \Fruitcake\LaravelDebugbar\Facades\Debugbar::stopMeasure('SidebarActionWithClasses');

        return [
            'data' => $dataAddClass
        ];
    }
}
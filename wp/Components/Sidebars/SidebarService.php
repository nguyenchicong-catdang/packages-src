<?php
// wp/Components/Sidebars/SidebarService.php
namespace Vendorpath\Wp\Components\Sidebars;

class SidebarService
{
    public function toAray(): array
    {
        $data = app(SidebarLoader::class)->getDataSidebar();
        return [
            'data' => $data
        ];
    }
}
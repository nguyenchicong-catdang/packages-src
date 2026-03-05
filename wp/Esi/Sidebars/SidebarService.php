<?php
namespace Vendorpath\Wp\Esi\Sidebars;

class SidebarService
{
    public function __construct(
        // Inject các service cần thiết để lấy dữ liệu cho sidebar
        protected SidebarLoader $sidebarLoader,
        protected SidebarActionAddClass $sidebarActionAddClass
    )
    {}

    public function service(): string
    {
        // Lấy dữ liệu từ các service và chuẩn bị mảng dữ liệu cho view
        $data = $this->sidebarLoader->loader();
        $dataWithClasses = $this->sidebarActionAddClass->action($data);
        return $dataWithClasses;
    }
}
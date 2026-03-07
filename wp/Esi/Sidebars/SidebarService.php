<?php
namespace Vendorpath\Wp\Esi\Sidebars;

class SidebarService
{
    public function __construct(
        // Inject các service cần thiết để lấy dữ liệu cho sidebar
        protected SidebarLoader $sidebarLoader,
        protected SidebarActionParse $sidebarActionParse,
        // protected SidebarActionAddClass $sidebarActionAddClass
    )
    {}

    public function service(): string|array
    {
        // Lấy dữ liệu từ các service và chuẩn bị mảng dữ liệu cho view
        $dataLoader = $this->sidebarLoader->loader();
        $dataArray = $this->sidebarActionParse->action($dataLoader);
        return $dataArray;
        // dd($dataArray);
        // $dataWithClasses = $this->sidebarActionAddClass->action($dataLoader);
        // return $dataWithClasses;
    }
}
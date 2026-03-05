<?php
namespace Vendorpath\Wp\Esi\Sidebars;
class SidebarLoader
{
    public function loader(): string
    {
        // fake data để test khi chưa có kết nối DB hoặc trong môi trường local
        return $this->fakeData();
        // Giả sử bạn lưu HTML sidebar trong một option của WordPress
        // Bạn có thể dùng Corcel để lấy dữ liệu này nếu đã cấu hình kết nối đến DB WordPress
        // return \Corcel\Model\Option::get('laravel_sidebar_html');
    }

    private function fakeData()
    {
        // Dữ liệu giả để test khi chưa có kết nối DB hoặc trong môi trường local
        return '<a href="#">Fake Sidebar Item</a>';
    }
}
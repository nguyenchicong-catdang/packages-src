<?php
namespace Vendorpath\Wp\Esi\Navbars;

class NavbarLoader
{
    public function loader()
    {
        // Giả lập dữ liệu động, có thể là kết quả từ DB hoặc API
        return $this->fakeData();
    }

    private function fakeData()
    {
        // Dữ liệu giả để test khi chưa có kết nối DB hoặc trong môi trường local
        return 'Fake Navbar Content - ' . date('H:i:s');
    }
}
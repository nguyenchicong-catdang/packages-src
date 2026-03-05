<?php
namespace Vendorpath\Wp\Esi\Navbars;
class NavbarService
{
    public function __construct(
        // Inject các service cần thiết để lấy dữ liệu cho navbar
        protected NavbarLoader $navbarLoader,
    )
    {}
    public function service(): string
    {
        // Giả lập dữ liệu động, có thể là kết quả từ DB hoặc API
        return $this->navbarLoader->loader();
    }
}
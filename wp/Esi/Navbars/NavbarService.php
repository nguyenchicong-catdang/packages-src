<?php
namespace Vendorpath\Wp\Esi\Navbars;
class NavbarService
{
    public function __construct(
        // Inject các service cần thiết để lấy dữ liệu cho navbar
        protected NavbarLoader $navbarLoader,
        protected NavbarActionParse $navbarActionParse,
    )
    {}
    public function service(): array
    {
        // Giả lập dữ liệu động, có thể là kết quả từ DB hoặc API
        $dataLoader = $this->navbarLoader->loader();
        $dataParse = $this->navbarActionParse->action($dataLoader);
        
        return $dataParse;
    }
}
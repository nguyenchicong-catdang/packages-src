<?php
// wp/Components/Sidebars/SidebarLoader.php
namespace Vendorpath\Wp\Components\Sidebars;

use Corcel\Model\Option;

class SidebarLoader extends Option
{
    // Nếu bạn đặt tên kết nối là 'wordpress' trong database.php
    // protected $connection = 'wordpress';

    public function getDataSidebar()
    {
        // CÁCH ĐÚNG: dùng static:: thay vì Option::
        // static:: sẽ sử dụng $connection = 'wordpress' bạn đã khai báo ở trên
        return self::get('laravel_sidebar_html');
    }

    public function fakeData()
    {
        // Dữ liệu giả để test khi chưa có kết nối DB hoặc trong môi trường local
        return '<a href="#">Fake Sidebar Item</a>';
    }
}

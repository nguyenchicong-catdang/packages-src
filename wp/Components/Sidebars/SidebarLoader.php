<?php
// wp/Components/Sidebars/SidebarLoader.php
namespace Vendorpath\Wp\Components\Sidebars;

use Corcel\Model\Option;

class SidebarLoader extends Option
{
    // Nếu bạn đặt tên kết nối là 'wordpress' trong database.php
    // protected $connection = 'wordpress';

    private function fakeData()
    {
        return '<div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">A simple default list group item</a>
                    <a href="#" class="list-group-item list-group-item-action">A simple default list group item</a>
                </div>';
    }
    public function getDataSidebar()
    {
        // CÁCH ĐÚNG: dùng static:: thay vì Option::
        // static:: sẽ sử dụng $connection = 'wordpress' bạn đã khai báo ở trên
        return self::get('laravel_sidebar_html');
        // return $this->fakeData();
    }
}

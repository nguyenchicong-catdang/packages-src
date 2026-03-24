<?php
namespace Vendorpath\Wp\MockData;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MockDataServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (app()->isLocal()) {
            
            // @mock .blade.php
            Blade::directive('mock', function ($expression) {
                // Dọn dẹp dấu nháy: 'sidebar' -> sidebar
                $name = trim($expression, "'\" ");

                switch ($name) {
                    case "sidebar":
                        // Phải trả về chuỗi mã PHP (string)
                        /* return "<?php \$data = \Vendorpath\Wp\MockData\MockDataSidebar::mockData(); ?>"; */
                        // Kiểm tra: Nếu biến $data chưa có giá trị, thì mới gọi mockData
                        return "<?php if(!isset(\$data)) { \$data = \Vendorpath\Wp\MockData\MockDataSidebar::mockData(); } ?>";
                    case "navbar":
                        return "<?php if(!isset(\$data)) { \$data = \Vendorpath\Wp\MockData\MockDataNavbar::mockData(); } ?>";
                    case "cat_card":
                        return "<?php if(!isset(\$data)) { \$data = \Vendorpath\Wp\MockData\MockDataCatCard::mockData(); } ?>";
                    case "cat_post":
                        return "<?php if(!isset(\$data)) { \$data = \Vendorpath\Wp\MockData\MockCatPostData::mockData(); } ?>";
                    case "cat_lists":
                        return "<?php if(!isset(\$data)) { \$data = \Vendorpath\Wp\MockData\MockCatListsData::mockData(); } ?>";
                    case "esi_cat_slugs":
                        return "<?php if(!isset(\$data)) { \$data = \Vendorpath\Wp\MockData\MocDataEsiCatLists::mockData(); } ?>";
                    case "pagination":
                        return "<?php if(!isset(\$data)) { \$data = \Vendorpath\Wp\MockData\MocDataPagination::mockData(); } ?>";
                    default:
                        // $message = "Mock name [{$name}] không tồn tại trong hệ thống!";
                        // Lưu ý dấu nháy đơn bao quanh $message bên trong chuỗi return
                        return "<div style=\"color: red; background: #fee; padding: 10px; border: 1px solid red;\">Không tồn tại: '$name'</div>";
                }
            });
        }
    }
}
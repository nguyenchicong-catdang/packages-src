<?php
// wp/Components/Sidebars/SidebarService.php
// SidebarService.php
namespace Vendorpath\Wp\Components\Sidebars;

class SidebarService
{
    protected static ?array $cachedData = null;
    // Inject tất cả những thứ cần thiết ngay tại đây
    public function __construct(
        protected SidebarLoader $loader,
        protected SidebarActionWithClasses $action
    ) {}

    public function toArray(): array
    {
        // Nếu đã có data từ instance trước đó, trả về luôn
        if (static::$cachedData !== null) {
            return static::$cachedData;
        }
        // Không dùng app() nữa, dùng thuộc tính class
        \Fruitcake\LaravelDebugbar\Facades\Debugbar::startMeasure('SidebarLazyDataProvider', 'Thời gian tải SidebarLazyDataProvider');

        $data = $this->loader->getDataSidebar();
        // dd($data);
        \Fruitcake\LaravelDebugbar\Facades\Debugbar::stopMeasure('SidebarLazyDataProvider');

        // \Fruitcake\LaravelDebugbar\Facades\Debugbar::startMeasure('SidebarActionWithClasses', 'Thời gian tải SidebarActionWithClasses');
        $dataAddClass = $this->action->addClass($data);
        // \Fruitcake\LaravelDebugbar\Facades\Debugbar::stopMeasure('SidebarActionWithClasses');

        return static::$cachedData = ['data' => $dataAddClass];
    }
}
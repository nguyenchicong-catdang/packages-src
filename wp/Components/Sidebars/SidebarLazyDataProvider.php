<?php

namespace Vendorpath\Wp\Components\Sidebars;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SidebarLazyDataProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        \Fruitcake\LaravelDebugbar\Facades\Debugbar::startMeasure('--- Provider đã thức dậy! ---');
        // Đăng ký Loader
        $this->app->singleton(SidebarLoader::class, function ($app) {
            return new SidebarLoader();
        });

        // Đăng ký Service chính (Cần thiết để Lazy Load hoạt động)
        // $this->app->singleton(SidebarService::class, function ($app) {
        //     return new SidebarService();
        // });
    }

    public function provides(): array
    {
        // Khi bất kỳ class nào ở đây được gọi (app(...)), Provider này mới thực sự chạy
        return [
            SidebarLoader::class,
            // SidebarService::class
        ];
    }
}
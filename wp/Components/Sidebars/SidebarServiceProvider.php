<?php

namespace Vendorpath\Wp\Components\Sidebars;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class SidebarServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        // Đăng ký Loader
        $this->app->singleton(SidebarLoader::class, function ($app) {
            return new SidebarLoader();
        });

        // Đăng ký Service chính (Cần thiết để Lazy Load hoạt động)
        $this->app->singleton(SidebarService::class, function ($app) {
            return new SidebarService();
        });
    }

    public function provides(): array
    {
        // Khi bất kỳ class nào ở đây được gọi (app(...)), Provider này mới thực sự chạy
        return [
            SidebarLoader::class,
            SidebarService::class
        ];
    }
}
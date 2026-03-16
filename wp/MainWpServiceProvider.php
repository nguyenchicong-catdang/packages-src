<?php

namespace Vendorpath\Wp;

use Illuminate\Support\AggregateServiceProvider;

class MainWpServiceProvider extends AggregateServiceProvider
{
    /**
     * Danh sách các Provider mặc định (Luôn chạy)
     */
    protected $providers = [
        \Vendorpath\Wp\WpServiceProvider::class,
        // \Vendorpath\Wp\Components\Sidebars\SidebarServiceProvider::class,
        // \Corcel\Laravel\CorcelServiceProvider::class,
    ];

    /**
     * Ghi đè hàm register để nạp thêm các Provider Dev nếu ở Local
     */
    public function register(): void
    {
        // 1. Thêm các Provider cho môi trường DEV
        if (app()->isLocal()) {
            $this->providers = array_merge($this->providers, [
                \Vendorpath\Wp\DevFrontend\DevFrontendServiceProvider::class,
                \Vendorpath\Wp\MockData\MockDataServiceProvider::class
            ]);
        }

        // 2. Gọi hàm register của cha (AggregateServiceProvider) để thực thi đăng ký
        parent::register();
    }
}

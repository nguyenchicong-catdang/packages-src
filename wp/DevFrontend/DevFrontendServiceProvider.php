<?php
namespace Vendorpath\Wp\DevFrontend;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DevFrontendServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (app()->isLocal()) {
            $this->loadRoutesFrom(__DIR__ . '/routeFrontend.php');
            $this->loadViewsFrom(__DIR__ . '/views', 'dev-view');
            Blade::anonymousComponentPath(__DIR__ . '/views/components', 'dev-comp');
            Blade::anonymousComponentPath(__DIR__ . '/views/esi', 'dev-esi');
        }
    }
}
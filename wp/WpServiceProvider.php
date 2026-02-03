<?php
namespace Vendorpath\Wp;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class WpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routesWp.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'wp-view');
        Blade::anonymousComponentPath(__DIR__ . '/views/components', 'wp-comp');
        Blade::componentNamespace('Vendorpath\\Wp\\Components', 'wp-compName');
    }
}
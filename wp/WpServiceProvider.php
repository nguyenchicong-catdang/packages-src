<?php
namespace Vendorpath\Wp;

use Illuminate\Support\ServiceProvider;

class WpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routesWp.php');
    }
}
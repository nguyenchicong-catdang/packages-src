<?php
namespace Vendorpath\Wp;

use Illuminate\Support\AggregateServiceProvider;

class MainWpServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        \Vendorpath\Wp\WpServiceProvider::class,
        \Corcel\Laravel\CorcelServiceProvider::class,
        // \Vendorpath\Wp\Components\Sidebars\SidebarServiceProvider::class,
        \Vendorpath\Wp\Categories\CategoryServiceProvider::class
    ];
}
<?php
namespace Vendorpath\Wp;

use Illuminate\Support\AggregateServiceProvider;

class MainWpServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        \Vendorpath\Wp\WpServiceProvider::class,
        \Vendorpath\Wp\Components\Sidebars\SidebarServiceProvider::class,
        \Corcel\Laravel\CorcelServiceProvider::class,
    ];
}
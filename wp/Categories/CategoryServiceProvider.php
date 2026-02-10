<?php
namespace Vendorpath\Wp\Categories;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public $singletons = [
        Interface\CategoryLoaderInterface::class => Loader\CategoryLoader::class
    ];
}
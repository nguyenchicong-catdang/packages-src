<?php

namespace Vendorpath\Wp\Esi\Categories;

class CategoryService
{
    public function __construct(
        protected CategoryLoader $loader
    ) {}
    public function serviceIds()
    {
        $dataLoader = $this->loader->loaderIds();
        return $dataLoader;
    }
}

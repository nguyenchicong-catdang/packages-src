<?php

namespace Vendorpath\Wp\Esi\Categories;

class CategoryService
{
    public function __construct(
        protected CategoryLoader $loader
    ) {}
    public function service($slug = null)
    {
        return $this->loader->loader($slug);
    }
}

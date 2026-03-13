<?php

namespace Vendorpath\Wp\Esi\Categories;

class CategoryService
{
    public function __construct(
        protected CategoryLoader $loader,
        protected CategoryActionParseDescription $actionParseDescription
    ) {}
    public function service($slug = null)
    {
        $dataLoader = $this->loader->loader($slug);
        $description = $this->actionParseDescription->action($dataLoader['description']);
        $dataLoader['description'] = $description;
        // dd($description['first_image_src']);
        $dataLoader['seo_img'] = $description['first_image_src'];
        // dd($description);
        // dd($dataLoader['description']);
        return $dataLoader;
    }
}

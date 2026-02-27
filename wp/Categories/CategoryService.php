<?php
namespace Vendorpath\Wp\Categories;

class CategoryService
{
    public function __construct(
        protected Interface\CategoryLoaderInterface $loader
    ) {}
    public function show($slug)
    {
        $data_loader = $this->loader->getCategory($slug);
        // dd($data_loader);
        $data_cache = CategoryCacheArray::cache($data_loader);
        dd($data_cache);
        return CategoryData::fromLoader($data_cache);
    }
}
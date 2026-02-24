<?php
namespace Vendorpath\Wp\Categories;

class CategoryService
{
    public function __construct(
        protected Interface\CategoryLoaderInterface $loader
    ) {}
    public function show($slug)
    {
        $data = $this->loader->getCategory($slug);
        CategoryData::dev($data); // for debugging
        $data_cache = CategoryData::prepare($data);
        return CategoryData::fromLoader($data_cache);

        // return $data;
    }
}
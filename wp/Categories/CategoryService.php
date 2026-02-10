<?php
namespace Vendorpath\Wp\Categories;

class CategoryService
{
    public function __construct(
        protected Interface\CategoryLoaderInterface $loader
    ) {}
    public function show($slug): CategoryData
    {
        $data = $this->loader->getCategory($slug);
        return CategoryData::fromLoader($data);
    }
}
<?php
// Categories/CategoryService.php
namespace Vendorpath\Wp\Categories;

class CategoryService
{
    public function toArray($slug)
    {
        return app(CategoryLoader::class)->getCategory($slug);
    }
}
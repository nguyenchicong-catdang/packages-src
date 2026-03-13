<?php

namespace Vendorpath\Wp\Esi\Categories;

class CategoryService
{
    public function __construct(
        protected CategoryDataCat $dataCat,
        protected CategoryDataIds $dataIds
    ) {}
    public function getDataCat($slug = "")
    {
        return $this->dataCat->getData($slug);
    }

    public function getDataIds($slug = "")
    {
        return $this->dataIds->getData($slug);
    }
}

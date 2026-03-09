<?php
namespace Vendorpath\Wp\Esi\Categories;

use Corcel\Model\Taxonomy;
class CategoryLoader extends Taxonomy
{
    public function loader()
    {
        return self::slug('thung-rac')->firstOrFail();
    }

    public function loaderIds()
    {
        $posts = $this->loader()->posts()
            ->status('publish')
            ->toBase()
            ->pluck('ID');
        return $posts;
    }
}
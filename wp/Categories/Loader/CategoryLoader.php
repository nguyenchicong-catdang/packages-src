<?php
namespace Vendorpath\Wp\Categories\Loader;

use Vendorpath\Wp\Categories\Interface\CategoryLoaderInterface;
use Corcel\Model\Taxonomy;
class CategoryLoader extends Taxonomy implements CategoryLoaderInterface 
{
    public function getCategory(string $slug): array|object
    {
        $category = self::slug($slug)
         ->firstOrFail();

        $posts = $category->posts()
            ->status('publish')
            ->paginate(5);

        return [
            'category' => $category,
            'posts' => $posts
        ];
    }
}
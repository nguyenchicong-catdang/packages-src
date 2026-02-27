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

        $paginator = $category->posts()
            ->select(['posts.ID', 'posts.post_name'])
            ->status('publish')
            // ->with(['thumbnail'])
            ->paginate(2);

        return [
            'category' => $category,
            'paginator' => $paginator
        ];
    }
}
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

        // Chuyển đổi các Model nặng nề thành mảng/DTO phẳng
        $cleanItems = $posts->getCollection()->map(function ($post) {
            return [
                'id'    => $post->ID,
                'title' => $post->post_title,
                'slug'  => $post->post_name,
                // Chỉ lấy những gì cần thiết cho Blade
            ];
        });

        // "Đè" danh sách Model bằng danh sách mảng phẳng
        $posts->setCollection($cleanItems);
        return [
            'category' => $category,
            'posts' => $posts
        ];
    }
}
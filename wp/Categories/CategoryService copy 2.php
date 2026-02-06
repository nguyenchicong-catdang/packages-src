<?php
// Categories/CategoryService.php
namespace Vendorpath\Wp\Categories;

use Illuminate\Support\Str;


class CategoryService
{
    public function toArray($slug)
    {
        $data = app(CategoryLoader::class)->getCategory($slug);
        $paginator = $data['posts']; // Đây là đối tượng LengthAwarePaginator

        // viet lai cat
        $cat = $this->formatCat($data['cat']);
        
        // Biến đổi từng item bên trong nhưng không làm hỏng Paginator
        $paginator->getCollection()->transform(function ($post) {
            return $this->formatPost($post);
        });

        return [
            'cat' => $cat,
            'posts'    => $paginator // Trả về Paginator đã được "làm sạch"
        ];
    }

    public function formatCat($cat)
    {
        return (object)[
            'name' => $cat->name,
            'description' => $cat->description
        ];
    }

    public function formatPost($post)
    {
        // Đây chính là nơi bạn "gạn đục khơi trong"
        return (object)[
            'title'         => $post->title,
            'slug'          => $post->slug,
            'excerpt'       => Str::limit($post->excerpt, 120),
            'featured_image_url' => $post->thumbnail?->attachment?->url ?? '/uploads/no-image.png',
            'featured_image_alt' => $post->thumbnail?->attachment?->alt ?? $post->title,
            'published_at'  => $post->post_date->format('d/m/Y'),
        ];
    }
}
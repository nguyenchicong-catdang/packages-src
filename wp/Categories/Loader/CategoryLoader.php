<?php

namespace Vendorpath\Wp\Categories\Loader;

use Vendorpath\Wp\Categories\Interface\CategoryLoaderInterface;
use Corcel\Model\Taxonomy;
use Corcel\Model\Post;

class CategoryLoader extends Taxonomy implements CategoryLoaderInterface
{
    public function getCategory(string $slug): array|object
    {
        // 1. Lấy thông tin Category trước
        $category = self::slug($slug)->firstOrFail();

        // 2. Truy vấn thẳng từ Model Post dựa trên Taxonomy ID
        // Cách này giúp select() hoạt động chính xác vì nó không bị vướng logic pivot của belongsToMany
        $paginator = Post::status('publish')
            ->whereHas('taxonomies', function ($q) use ($category) {
                // Chỉ định rõ bảng để tránh lỗi ambiguous
                // Lưu ý: Corcel mặc định dùng bảng 'term_relationships' làm pivot
                $q->where('term_relationships.term_taxonomy_id', $category->term_taxonomy_id);
            })
            ->select(['ID', 'post_name'])
            ->latest()
            ->paginate(2);

        return [
            'category' => $category,
            'paginator' => $paginator
        ];
    }
}
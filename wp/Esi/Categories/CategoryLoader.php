<?php
namespace Vendorpath\Wp\Esi\Categories;

use Corcel\Model\Taxonomy;

class CategoryLoader extends Taxonomy
{
    public function loader($slug = null)
    {
        return self::category()->slug($slug)
        ->with(['meta'])
        ->firstOrFail();
    }

    // Accessor: Cho phép gọi $category->ids
    public function getIdsAttribute()
    {
        return $this->posts()
            ->status('publish')
            ->toBase()
            ->pluck('ID')
            ->toArray();
    }

    public function getDataCatAttribute()
    {
        // Xóa các biến Rank Math cơ bản để tránh hiển thị rác
        // $cleaned = str_replace(['%title%', '%sep%', '%sitename%', '%page%'], '', $text);
        $description = $this->description ?? '';
        $name = $this->term->name ?? '';
        return [
            'dev' => $this,
            'id' => $this->term_id,
            'title' => $name,
            'name' => $name,
            'image' => $this->seo_image,
            'description' => $description,
            'seo_title'   => $this->meta->rank_math_title ?? $name,
            'seo_description' => $this->meta->rank_math_description ?? $description,
        ];
    }

    public function getSeoImageAttribute()
    {
        // Lấy bài viết mới nhất (Dùng first thay vì firstOrFail để tránh sập trang)
        $latestPost = $this->posts()
            ->status('publish')
            ->orderBy('ID', 'desc')
            ->first();

        if ($latestPost && $latestPost->thumbnail) {
            // Corcel: thumbnail trả về object Attachment hoặc null
            // Ta lấy URL từ thuộc tính 'url' hoặc 'guid' của Attachment
            return $latestPost->thumbnail;
        }

        // Trả về ảnh mặc định nếu không có bài viết hoặc bài viết không có thumbnail
        return asset('images/default-category.jpg');
    }

}
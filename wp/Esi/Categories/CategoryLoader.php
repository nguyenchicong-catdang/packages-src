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

    public function getCardAttribute()
    {
        // Xóa các biến Rank Math cơ bản để tránh hiển thị rác
        // $cleaned = str_replace(['%title%', '%sep%', '%sitename%', '%page%'], '', $text);
        $description = $this->description ?? '';
        $name = $this->term->name ?? '';
        return [
            'dev' => $this,
            'id' => $this->term_id,
            'name' => $name,
            'description' => $description,
            'seo_title'   => $this->meta->rank_math_title ?? $name,
            'seo_description' => $this->meta->rank_math_description ?? $description,
        ];
    }

}
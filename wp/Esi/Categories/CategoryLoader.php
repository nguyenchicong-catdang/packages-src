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
    public function getDataIdsAttribute()
    {
        return $this->posts()
            ->status('publish')
            // ->get();
            ->toBase()
            ->orderBy('post_date', 'desc')
            // ->pluck('ID')
            // ->pluck('post_name', 'post_modified' )
            ->pluck('post_name')
            ->take(120)
            // pluck('ID')->take(100)
            ->toArray();
    }

    public function getDataCatAttribute()
    {
        // Xóa các biến Rank Math cơ bản để tránh hiển thị rác
        // $cleaned = str_replace(['%title%', '%sep%', '%sitename%', '%page%'], '', $text);
        // $description = $this->description ?? '';
        // $name = $this->term->name ?? '';
        return [
            'dev' => $this,
            'id' => $this->term_id ?? '',
            'name' => $this->term->name ?? '',
            'description' => $this->description ?? '',
            // 'name' => $name,
            // 'description' => $description,
            'seo_title'   => $this->meta->rank_math_title ?? '',
            'seo_description' => $this->meta->rank_math_description ?? '',
        ];
    }

    

}
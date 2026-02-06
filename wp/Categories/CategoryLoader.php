<?php
// Categories/CategoryLoader.php
namespace Vendorpath\Wp\Categories;
use Corcel\Model\Taxonomy;
// use Corcel\Model\Term;
class CategoryLoader extends Taxonomy
{
    protected $connection = 'wordpress';
    // Đảm bảo taxonomy là category
    //protected $taxonomy = 'category';
    
    public function getCategory($slug)
    {
        // // $data = CategoryLoader::slug($slug)->with('term')->firstOrFail();
        // $data = self::whereHas('term', function ($query) use ($slug) {
        //     $query->where('slug', $slug);
        // })
        //     ->with('term') // Eager loading để tránh query thứ 2
        //     ->firstOrFail();
        // return [
        //     'name' => $data?->term->name
        // ];
        // Sử dụng Join để gộp 2 bảng ngay trong SQL
        // $data = self::query()
        //     ->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id')
        //     ->where('terms.slug', $slug)
        //     ->select('terms.name', 'term_taxonomy.*')
        //     ->firstOrFail();

        // return [
        //     'name' => $data->name // Lúc này name đã nằm sẵn trong đối tượng $data
        // ];
        // $data = self::slug($slug)->with('term')->firstOrFail();
        // return [
        //     'name' => $data->term->name
        // ];
        // $category = self::slug($slug)
        //     ->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id')
        //     // ->where('wp_term_taxonomy.term_id', 'wp_terms.term_id')
        //     // ->where(`wp_term_taxonomy` . `term_id`, `wp_terms` . `term_id`)
        //     // ->with('term')
        //     ->firstOrFail();

        // $term = self::where('slug', $slug)
        //     ->with('taxonomy') // Eager load quan hệ sang taxonomy
        //     ->firstOrFail();

        // $category = $term->taxonomy;

        // Lấy bài viết có phân trang (ví dụ 10 bài mỗi trang)
        // $posts = $category->posts()
        //     ->with(['meta']) // QUAN TRỌNG: Gom tất cả meta vào 1 lần lấy
        //     ->where('post_status', 'publish')
        //     ->paginate(10);

        // return [
        //     'cat' => $category,
        //     'posts' => $posts->getCollection()
        // ];
        // $category = self::query()
        //     ->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id')
        //     ->where('terms.slug', $slug)
        //     ->where('term_taxonomy.taxonomy', 'category')
        //     ->select('term_taxonomy.*', 'terms.name', 'terms.slug as term_slug')
        //     ->firstOrFail();

        // $category = self::slug($slug)
        //     // ->select('*')
        //     // ->where('taxonomy', 'category')
        //     // ->with(['term'])
        //     ->firstOrFail();
        // Lấy bài viết có phân trang

        // $category = self::query() // Khởi tạo builder
        //     ->join('terms', 'term_taxonomy.term_id', '=', 'terms.term_id')
        //     ->where('terms.slug', $slug)
        //     ->where('term_taxonomy.taxonomy', 'category')
        //     ->select([
        //         'term_taxonomy.term_id',
        //         'term_taxonomy.term_taxonomy_id',
        //         'terms.name',      // <--- Bây giờ bạn đã select được nó!
        //         'terms.slug'       // <--- Và cả cái này nữa
        //     ])
        //     ->firstOrFail();

        $category = self::slug($slug)
            ->firstOrFail();

        $posts = $category
        ->posts()
        ->status('publish')
            // ->with(['thumbnail.attachment'])
            // ->published()
            // ->where('post_status', 'publish')
            // ->with(['meta', 'thumbnail.attachment.meta']) // Thêm 'thumbnail' vào đây để lấy thông tin ảnh luôn
            // Lọc: Chỉ lấy những post có meta_key là _thumbnail_id
            // ->hasMeta('_thumbnail_id')
            // Eager load luôn để tránh N+1 khi hiển thị
            ->with(['thumbnail'])
            ->paginate(2)
            // ->withQueryString()
            ;

        return [
            'cat' => $category,
            'posts' => $posts // Đừng dùng ->getCollection() nếu bạn muốn giữ lại thanh phân trang (links)
        ];
    }

    
}
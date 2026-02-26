<?php
// Categories/CategoryData.php
namespace Vendorpath\Wp\Categories;
use Vendorpath\Wp\Abstract\BaseDTO;

class CategoryData extends BaseDTO
{
    public function __construct(
        public readonly object $dev,
        public readonly array $category,
        public readonly array $paginator,
        // public readonly array $posts,
        // public readonly array $cat_card,
    ) {}

    protected static function map(object|array $data): array|object
    {
        // dd($data);
        return [
            'dev' => data_get($data, 'dev', []),
            'category' => data_get($data, 'category', []),
            'paginator' => data_get($data, 'paginator', []),
            // 'posts' => data_get($data, 'posts', []),
            // 'cat_card' => DTO\CatCard::map($data),
        ];
    }   

    public static function prepare(array|object $data): array
    {
        $cat = data_get($data, 'category', []);
        // LengthAwarePaginator
        $postsPaginator = data_get($data, 'posts', []); // Đây là đối tượng LengthAwarePaginator

        return [
            'dev' => $data,
            'category' => DTO\CatData::map($cat),
            'posts' => $postsPaginator->getCollection()->map(fn($post) => DTO\CatPosts::map($post))->toArray(),
            'pagination' => DTO\CatPagination::map($postsPaginator),
        ];
    }
}
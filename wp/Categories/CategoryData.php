<?php
// Categories/CategoryData.php
namespace Vendorpath\Wp\Categories;


class CategoryData
{
    public function __construct(
        public readonly object $category,
        public readonly object $paginator,
        public readonly object $catCard,
        public readonly object $catPosts,
    ) {}

    public static function fromLoader(array $loader): self
    {
        return new self(
            category: (object) ($loader['category'] ?? []),
            paginator: (object) ($loader['paginator'] ?? []),
            catCard: DTO\CatCardDTO::DTO((object) ($loader['category'] ?? [])),
            catPosts: collect(data_get($loader, 'paginator.items', []))->map(function ($post) {
                return DTO\CatPostsDTO::DTO((object) $post);
            }),
        );
    }
}
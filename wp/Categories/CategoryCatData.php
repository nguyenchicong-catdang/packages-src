<?php
// Categories/CategoryCatData.php
namespace Vendorpath\Wp\Categories;

class CategoryCatData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description
    ) {}

    public static function fromModel($cat): self
    {
        return new self(
            name: (string) $cat->name,
            description: (string) $cat->description
        );
    }
}
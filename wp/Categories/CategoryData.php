<?php
namespace Vendorpath\Wp\Categories;
use Vendorpath\Wp\Abstract\BaseDTO;
class CategoryData extends BaseDTO
{
    public function __construct(
        public readonly string $name
    ) {}
    
    // public static function fromLoader(object $cat): self
    // {
    //     return new self(
    //         title: (string) data_get($cat, 'name'),
    //     );
    // }
}
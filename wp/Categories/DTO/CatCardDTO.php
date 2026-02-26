<?php
namespace VendorPath\Wp\Categories\DTO;

class CatCardDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
    ) {}

    public static function DTO(object|array $cat): self
    {
        // dd($cat);
        return new self(
            name: $cat->name ?? '',
            description: $cat->description ?? '',
        );
    }
}
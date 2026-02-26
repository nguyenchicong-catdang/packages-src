<?php

namespace Vendorpath\Wp\Categories\DTO;

class CatPostThumbnailDTO
{
    public function __construct(
        public readonly string $src,
        public readonly string $alt,
        public readonly string $srcset,
        public readonly string $sizes = '(max-width: 540px) 33vw, 180px',

        // public readonly string $sizes = '(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 400px',
    ) {}

    public static function DTO(object|array $thumbnail): self
    {
        // 1. Parse Metadata
        $metadata = data_get($thumbnail, 'metadata');
        if (is_string($metadata)) {
            $metadata = @unserialize($metadata);
        }

        // 2. Xử lý Base URL
        $baseUrl = data_get($thumbnail, 'url', '');
        if ($baseUrl) {
            $baseUrl = rtrim(dirname($baseUrl), '/') . '/';
        }

        $src = data_get($thumbnail, 'url', '');
        $srcsetArray = [];

        // 3. Thêm ảnh gốc vào mảng với key là width để sắp xếp
        if ($src && isset($metadata['width'])) {
            $width = (int) $metadata['width'];
            $srcsetArray[$width] = $src . ' ' . $width . 'w';
        }

        // 4. Duyệt các size phụ và cũng dùng width làm key
        $sizesMeta = data_get($metadata, 'sizes', []);
        foreach ($sizesMeta as $size) {
            if (isset($size['file'], $size['width'])) {
                $width = (int) $size['width'];
                $srcsetArray[$width] = $baseUrl . $size['file'] . ' ' . $width . 'w';
            }
        }

        // 5. SẮP XẾP TĂNG DẦN theo Key (chiều rộng)
        ksort($srcsetArray);

        return new self(
            src: $src,
            alt: data_get($thumbnail, 'alt', ''),
            srcset: implode(', ', $srcsetArray), // Bây giờ chuỗi sẽ là "150w, 300w, 768w..."
        );
    }
}

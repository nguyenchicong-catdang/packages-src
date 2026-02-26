<?php

namespace Vendorpath\Wp\Categories\DTO;

class CatPostThumbnailDTO
{
    public function __construct(
        public readonly string $src,
        public readonly string $alt,
        public readonly string $srcset,
        public readonly string $sizes = '(max-width: 768px) 100vw, (max-width: 1200px) 33vw, 400px',
    ) {}

    public static function DTO(object|array $thumbnail): self
    {
        // 1. Lấy và parse Metadata từ chuỗi serialized
        $metadata = data_get($thumbnail, 'metadata');
        if (is_string($metadata)) {
            $metadata = @unserialize($metadata);
        }

        // 2. Xử lý Base URL từ đường dẫn bạn đã dd() ra (/uploads/2026/02)
        // Đảm bảo luôn có dấu "/" ở cuối để nối file
        $baseUrl = data_get($thumbnail, 'url', '');
        if ($baseUrl) {
            $baseUrl = rtrim(dirname($baseUrl), '/') . '/';
        }

        // 3. Khởi tạo mảng srcset
        $src = data_get($thumbnail, 'url', '');
        $srcsetArray = [];

        // Thêm ảnh gốc (kích thước đầy đủ) vào srcset
        if ($src && isset($metadata['width'])) {
            $srcsetArray[] = $src . ' ' . $metadata['width'] . 'w';
        }

        // 4. Duyệt qua các kích thước phụ trong metadata (medium, thumbnail...)
        $sizes = data_get($metadata, 'sizes', []);
        foreach ($sizes as $size) {
            if (isset($size['file'], $size['width'])) {
                // Nối: /uploads/2026/02/ + tên-file-size.jpg
                $srcsetArray[] = $baseUrl . $size['file'] . ' ' . $size['width'] . 'w';
            }
        }

        return new self(
            src: $src,
            alt: data_get($thumbnail, 'alt', ''),
            srcset: implode(', ', $srcsetArray),
        );
    }
}

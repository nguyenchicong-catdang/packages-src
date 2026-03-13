<?php

namespace Vendorpath\Wp\Esi\Categories;

class CategoryActionParseDescription
{
    public function action(string $data = '')
    {
        $patternCaption = '/\[caption(.*?)\](.*?)\[\/caption\]/s';

        $firstImageSrc = null;
        $firstImageAlt = null;
        $contentInside = '';

        // 1. Trích xuất thông tin trước khi xóa
        if (preg_match($patternCaption, $data, $matches)) {
            $contentInside = $matches[0];

            // Lấy URL ảnh
            if (preg_match('/src="([^"]+)"/', $contentInside, $imgSrc)) {
                $firstImageSrc = $imgSrc[1];
            }

            // Lấy Alt ảnh
            if (preg_match('/alt="([^"]+)"/', $contentInside, $imgAlt)) {
                $firstImageAlt = $imgAlt[1];
            }
        }

        // 2. Thay thế nguyên khối caption bằng chuỗi rỗng
        // Hàm này sẽ tìm tất cả các khối [caption] và thay bằng ""
        $cleanContent = preg_replace($patternCaption, '', $data);

        return [
            // 'caption_block'   => $contentInside,
            'featured_image_src' => $firstImageSrc,
            'featured_image_alt' => $firstImageAlt,
            'description'   => trim($cleanContent), // Nội dung sau khi đã xóa caption
            'seo_image' => $firstImageSrc,
        ];
    }
}

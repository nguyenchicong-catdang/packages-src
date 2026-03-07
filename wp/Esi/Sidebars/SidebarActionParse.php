<?php

namespace Vendorpath\Wp\Esi\Sidebars;

class SidebarActionParse
{
    public function action(?string $data): array
    {
        if (empty($data)) return [];

        // 1. Tách dòng và loại bỏ các dòng chỉ chứa khoảng trắng/rỗng
        $lines = array_values(array_filter(
            explode("\n", $data),
            fn($line) => trim($line) !== ''
        ));

        if (empty($lines)) return [];

        // 2. TÌM MỐC THỤT LỀ NHỎ NHẤT (Base Indent)
        // Điều này giúp xử lý việc fakeData bị thụt lề do format code
        $minIndent = 999;
        foreach ($lines as $line) {
            $currentIndent = strlen($line) - strlen(ltrim($line));
            if ($currentIndent < $minIndent) {
                $minIndent = $currentIndent;
            }
        }

        $result = [];
        $lastParentIndex = -1;

        foreach ($lines as $line) {
            // 3. Tính toán Indent dựa trên mốc Min đã tìm được
            $trimmedLine = ltrim($line);
            $currentIndent = strlen($line) - strlen($trimmedLine);
            $relativeIndent = $currentIndent - $minIndent;

            $parts = explode('|', $trimmedLine);
            if (count($parts) !== 2) continue;

            $item = [
                'label' => trim($parts[0]),
                'slug'  => trim($parts[1]),
                'children' => []
            ];

            // 4. Nếu relativeIndent == 0 -> Chắc chắn là CHA (Cấp 1)
            if ($relativeIndent <= 0) {
                $result[] = $item;
                $lastParentIndex = count($result) - 1;
            }
            // Nếu thụt vào sâu hơn -> Là CON (Cấp 2)
            else {
                if ($lastParentIndex >= 0) {
                    $result[$lastParentIndex]['children'][] = $item;
                } else {
                    // Phòng thủ nếu data dòng đầu bị lệch
                    $result[] = $item;
                    $lastParentIndex = count($result) - 1;
                }
            }
        }

        return $result;
    }
}

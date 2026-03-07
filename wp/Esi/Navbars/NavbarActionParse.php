<?php

namespace Vendorpath\Wp\Esi\Navbars;

class NavbarActionParse
{
    public function action(?string $data): array
    {
        if (empty($data)) return [];

        // 1. Tách dòng và làm sạch
        $lines = array_filter(explode("\n", $data), fn($l) => trim($l) !== '');
        if (empty($lines)) return []; // Chống lỗi cho hàm min()

        // Tìm khoảng cách min
        $indents = array_map(fn($n) => strlen($n) - strlen(ltrim($n)), $lines);
        $minIndent = min($indents);

        $result = [];
        $lastParentIdx = -1;

        foreach ($lines as $line) {
            $trimmedLine = ltrim($line);
            $indent = strlen($line) - strlen($trimmedLine);
            $parts = array_map(fn($l) => trim($l), explode('|', $trimmedLine));

            if (count($parts) < 2) continue;

            $item = [
                'label'    => $parts[0],
                'slug'     => $parts[1],
                'type'     => $parts[2] ?? 'link',
                'children' => []
            ];

            // Nếu indent bằng minIndent -> Đây là Cha
            if ($indent <= $minIndent) {
                $result[] = $item;
                $lastParentIdx = count($result) - 1;
            }
            // Nếu là Con (indent > minIndent) và PHẢI có Cha trước đó
            elseif ($lastParentIdx >= 0) {
                $result[$lastParentIdx]['children'][] = $item;
            }
            // Trường hợp dòng đầu thụt lề nhưng chưa có cha -> Tự đôn lên làm cha
            else {
                $result[] = $item;
                $lastParentIdx = count($result) - 1;
            }
        }
        return $result;
    }
}

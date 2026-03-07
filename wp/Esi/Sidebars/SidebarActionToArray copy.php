<?php
namespace Vendorpath\Wp\Esi\Sidebars;

class SidebarActionToArray
{
    public function action(?string $data): array
    {
        // Chuyển đổi dữ liệu thành mảng nếu cần thiết
        $lines = explode("\n", $data);
        $result = [];
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) === 2) {
                $result[] = [
                    'label' => trim($parts[0]),
                    'slug' => trim($parts[1]),
                ];
            }
        }
        return $result;
    }
}
<?php
namespace Vendorpath\Wp\MockData;

use Illuminate\Support\Str;

class MocDataArray
{
    private static function fakeArray(): array
    {
        return [
            'thùng rác',
            'xe thu gom rác'
        ];
    }

    private static function arrayItem(string $item): array
    {
        return [
            'label' => ucfirst($item),
            'slug'  => Str::slug($item)
        ];
    }

    private static function makeData()
    {
        $fakeData = self::fakeArray();
        $data = [];
        foreach( $fakeData as $item) {
            $data[] = self::arrayItem($item);
        }
        return $data;
    }

    public static function mockData()
    {
        return self::makeData();
    }
}

// \Vendorpath\Wp\MockData\MocDataArray::mockData();
<?php

namespace Vendorpath\Wp\Abstract;

abstract class BaseDTO
{
    protected static array $reflectionCache = [];

    // Lớp con có thể override cái này để map field
    protected static function map(object|array $loader): object|array
    {
        return $loader;
    }

    public static function fromLoader(object|array $loader): static
    {
        $class = static::class;
        if (!isset(self::$reflectionCache[$class])) {
            self::$reflectionCache[$class] = (new \ReflectionClass($class))->getConstructor()->getParameters();
        }

        // Chuyển đổi object thành array theo map của lớp con
        $data = static::map($loader);
        $parameters = self::$reflectionCache[$class];

        $resolvedData = [];

        foreach ($parameters as $param) {
            $name = $param->getName();
            // Lấy dữ liệu từ $data, nếu không có thì lấy giá trị mặc định của Constructor

            // Nếu vẫn không có nữa thì gán null hoặc chuỗi rỗng tùy kiểu dữ liệu
            // $value = $data->$name ?? ($param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
            // $value = $data[$name] ?? ($param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
            $value = data_get($data, $name, $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
            // "Ép" kiểu dữ liệu để không bao giờ bị TypeError
            $resolvedData[$name] = self::sanitize($value, $param->getType()?->getName());
        }
        return new static(...$resolvedData);
    }

    private static function sanitize($value, ?string $type)
    {
        return match ($type) {
            'string' => (string) ($value ?? ''),
            'int'    => (int) ($value ?? 0),
            'array'  => (array) ($value ?? []),
            'object' => (object) ($value ?? new \stdClass()),
            default  => $value,
        };
    }
}

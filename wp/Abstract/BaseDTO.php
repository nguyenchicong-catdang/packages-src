<?php

namespace Vendorpath\Wp\Abstract;

abstract class BaseDTO
{
    protected static array $reflectionCache = [];

    public static function fromLoader(object $loader): static
    {
        $class = static::class;
        if (!isset(self::$reflectionCache[$class])) {
            self::$reflectionCache[$class] = (new \ReflectionClass($class))->getConstructor()->getParameters();
        }

        $parameters = self::$reflectionCache[$class];

        $resolvedData = [];

        foreach ($parameters as $param) {
            $name = $param->getName();
            // Lấy dữ liệu từ $data, nếu không có thì lấy giá trị mặc định của Constructor

            // Nếu vẫn không có nữa thì gán null hoặc chuỗi rỗng tùy kiểu dữ liệu
            $value = $loader->$name ?? ($param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
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
            default  => $value,
        };
    }
}

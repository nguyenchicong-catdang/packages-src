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

        $data = static::map($loader);
        $parameters = self::$reflectionCache[$class];
        $resolvedData = [];

        foreach ($parameters as $param) {
            $name = $param->getName();
            $isNullable = $param->getType()?->allowsNull();
            $hasDefault = $param->isDefaultValueAvailable();

            // Lấy dữ liệu
            $value = data_get($data, $name);

            // KIỂM TRA "NÓI CHUYỆN KHÔNG ĐƯỢC VỚI NHAU"
            $isEmptyString = is_string($value) && trim($value) === '';
            $isEmptyArray = is_array($value) && empty($value);
            if (($value === null || $isEmptyString || $isEmptyArray) && !$isNullable && !$hasDefault) {
                // throw new \InvalidArgumentException(
                //     sprintf(
                //         "DTO Error: Field [%s] trong lớp [%s] là bắt buộc nhưng dữ liệu từ Loader/Admin nhập vào đang bị THIẾU hoặc NULL. Check lại Database hoặc hàm map()!",
                //         $name,
                //         $class
                //     )
                // );
                // Ghi log âm thầm
                // error_log(sprintf("⚠️ DTO Missing Data: %s::%s", $class, $name));
                static $loggedFields = [];
                $logKey = "{$class}::{$name}";

                if (!isset($loggedFields[$logKey])) {
                    error_log("⚠️ DTO Missing Data: $logKey");
                    $loggedFields[$logKey] = true;
                }
                $value = null;
            }

            // Nếu null mà có giá trị mặc định thì lấy giá trị mặc định
            if ($value === null && $hasDefault) {
                $value = $param->getDefaultValue();
            }

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
            'bool'   => (bool) ($value ?? false),
            default  => $value,
        };
    }
}

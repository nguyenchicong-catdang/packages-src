<?php
abstract class BaseDTO
{
    public static function fromArray(array $data): static
    {
        // Lấy danh sách các tham số của Constructor
        $reflection = new \ReflectionClass(static::class);
        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();

        $resolvedData = [];

        foreach ($parameters as $param) {
            $name = $param->getName();

            // Lấy dữ liệu từ $data, nếu không có thì lấy giá trị mặc định của Constructor
            // Nếu vẫn không có nữa thì gán null hoặc chuỗi rỗng tùy kiểu dữ liệu
            $value = $data[$name] ?? ($param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);

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

/**
 * bug
abstract class BaseDTO {
    public static function fromArray(array $data): static {
        try {
            return new static(...$data);
        } catch (\TypeError $e) {
            // Khi team back-end thiếu trường hoặc sai kiểu
            throw new \Exception("DTO Mapping Error in " . static::class . ": " . $e->getMessage());
        }
    }
}

if ($value === null && !$param->isOptional()) {
    \Log::warning("DTO Warning: Missing field '{$name}' in " . static::class);
}
 */
<?php
declare(strict_types=1);

namespace Kata\Enum;

abstract class Enum
{
    private static array $constantCache = [];

    private function __construct()
    {
        throw new \RuntimeException('Cannot to be instantiated');
    }

    final public static function all(): array
    {
        if (!isset(self::$constantCache[static::class])) {
            self::$constantCache[static::class] = iterator_to_array(self::getPublicConstants(static::class));
        }

        return self::$constantCache[static::class];
    }

    final public static function hasValue($value): bool
    {
        foreach (self::all() as $existingValue) {
            if ($existingValue === $value) {
                return true;
            }
        }

        return false;
    }

    public static function throwIfDoesNotContainValue($value): void
    {
        if (self::hasValue($value)) {
            return;
        }

        throw new \RuntimeException(sprintf('The value "%s" does not exist in the enum %s.', $value, static::class));
    }

    private static function getPublicConstants($enumClassName): \Generator
    {
        $reflector = new \ReflectionClass($enumClassName);

        foreach ($reflector->getConstants() as $name => $value) {
            if ($reflector->getReflectionConstant($name)->isPublic()) {
                yield $name => $value;
            }
        }
    }
}

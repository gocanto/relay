<?php declare(strict_types=1);

namespace Gocanto\Attributes\Support;

class Arr
{
    /**
     * @param array<int|string, mixed> $array
     * @param string $key
     * @return bool
     */
    public static function exists(array $array, string $key): bool
    {
        return array_key_exists($key, $array);
    }

    /**
     * @param array<int|string, mixed> $array
     * @param string $key
     * @return array<int|string, mixed>|mixed
     */
    public static function get(array $array, string $key)
    {
        if (static::exists($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? null;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return null;
            }
        }

        return $array;
    }

    /**
     * @param array<int|string, mixed> $array
     * @param string $prepend
     * @return array<int|string, mixed>
     */
    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }
}

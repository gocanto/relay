<?php declare(strict_types=1);

namespace Gocanto\Attributes\Support;

use ArrayAccess;

class Arr
{
    /**
     * @param $array
     * @return bool
     */
    public static function accessible($array): bool
    {
        return is_array($array) || $array instanceof ArrayAccess;
    }

    /**
     * @param array|ArrayAccess $array
     * @param string $key
     * @return bool
     */
    public static function exists($array, string $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * @param array|ArrayAccess $array
     * @param string $key
     * @return array|mixed
     */
    public static function get($array, string $key)
    {
        if (!static::accessible($array)) {
            return null;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? null;
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return null;
            }
        }

        return $array;
    }

    /**
     * @param array $array
     * @param string $prepend
     * @return array
     */
    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (static::accessible($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }
}

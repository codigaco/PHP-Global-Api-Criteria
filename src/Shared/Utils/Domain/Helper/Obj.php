<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Utils\Domain\Helper;

use QuiqueGilB\GlobalApiCriteria\Shared\Utils\Domain\Exception\KeyNotDefinedException;
use ReflectionClass;
use ReflectionException;
use stdClass;
use TypeError;

class Obj
{
    /**
     * @param object|array $element
     * @param string $key
     * @return mixed|null
     * @throws ReflectionException
     */
    public static function getOrNull($element, string $key)
    {
        try {
            return self::get($element, $key);
        } catch (KeyNotDefinedException $e) {
            return null;
        }
    }

    /**
     * @param object|array $element
     * @param string $key
     * @return mixed|null
     * @throws ReflectionException
     */
    public static function get($element, string $key)
    {
        foreach (explode('.', $key) as $item) {
            if (is_array($element)) {
                if (!isset($element[$item])) {
                    throw new KeyNotDefinedException($key);
                }
                $element = $element[$item];
                continue;
            }

            if (!is_object($element)) {
                throw new TypeError(gettype($element));
            }

            if (get_class($element) === stdClass::class) {
                if (!isset($element->{$item})) {
                    throw new KeyNotDefinedException($key);
                }
                $element = $element->{$item};
                continue;
            }

            $reflection = new ReflectionClass(get_class($element));
            if (!$reflection->hasProperty($item)) {
                throw new KeyNotDefinedException($key);
            }
            $property = $reflection->getProperty($item);
            $property->setAccessible(true);
            $element = $property->getValue($element);
        }

        return $element;
    }

}

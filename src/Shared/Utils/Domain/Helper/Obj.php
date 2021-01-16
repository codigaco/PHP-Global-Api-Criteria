<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Utils\Domain\Helper;

use ReflectionClass;
use stdClass;
use TypeError;

class Obj
{

    public static function get($object, string $key)
    {
        foreach (explode('.', $key) as $item) {
            if (null === $object) {
                return null;
            }

            if (is_array($object)) {
                $object = $object[$item] ?? null;
                continue;
            }

            if(!is_object($object)) {
                throw new TypeError(gettype($object));
            }

            if (get_class($object) === stdClass::class) {
                $object = $object->{$item} ?? null;
                continue;
            }

            $reflection = new ReflectionClass(get_class($object));
            if (!$reflection->hasProperty($item)) {
                return null;
            }
            $property = $reflection->getProperty($item);
            $property->setAccessible(true);
            $object = $property->getValue($object);
        }

        return $object;

    }

}

<?php

namespace QuiqueGilB\GlobalApiCriteria\SharedModule\Utils\Domain\Helper;

class StringHelper
{
    public static function split(string $text, $delimiter = ','): array
    {
        $length = strlen($text);
        $parts = [];
        $charQuoted = null;

        $lastAppend = 0;

        for ($i = 0; $i < $length; $i++) {
            $char = $text[$i];

            if ('\\' === $char) {
                $i++;
                continue;
            }

            if ("'" === $char || '"' === $char) {
                $charQuoted = $charQuoted === $char ? null : $char;
            }

            if (null !== $charQuoted) {
                continue;
            }

            if ($char === $delimiter) {
                $parts[] = trim(substr($text, $lastAppend, $i - $lastAppend));
                $lastAppend = $i + 1;
            }
        }

        $parts[] = trim(substr($text, $lastAppend));

        return array_filter($parts,
            static function ($item) {
                return $item !== '';
            });
    }

    public static function unquote(string $value): string
    {
        return '"' === $value[0]
            ? trim($value, '"')
            : trim($value, "'");
    }

}

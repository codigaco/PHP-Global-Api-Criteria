<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository
{

    /**
     * @param Model|Model[] $result
     * @return object|object[]
     */
    protected function castResult($result)
    {
        if ($result instanceof Model) {
            return $result->cast();
        }

        $collection = [];
        foreach ($result as $item) {
            $collection[] = $item->cast();
        }

        return $collection;
    }
}

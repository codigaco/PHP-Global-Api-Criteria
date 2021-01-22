<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Shared\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;
use QuiqueGilB\GlobalApiCriteria\Shared\Shared\Domain\Castable;

abstract class EloquentRepository
{
    /**
     * @param Model|Model[] $result
     * @return object|object[]
     */
    protected function castResult($result)
    {
        if ($result instanceof Castable) {
            return $result->cast();
        }

        $collection = [];
        foreach ($result as $item) {
            $collection[] = $this->castResult($item);
        }

        return $collection;
    }
}

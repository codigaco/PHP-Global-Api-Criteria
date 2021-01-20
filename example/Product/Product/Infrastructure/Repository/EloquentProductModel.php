<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Model\Product;

class EloquentProductModel extends Model
{
    protected $table = 'product';

    public function cast(): Product
    {
        return new Product(
            $this->id,
            $this->name,
            $this->price,
            $this->stock
        );
    }
}

<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\Product;
use QuiqueGilB\GlobalApiCriteria\Shared\Shared\Domain\Castable;

class EloquentProductModel extends Model implements Castable
{
    protected $table = 'product';

    public function categories()
    {
        return $this->belongsToMany(
            EloquentCategoryModel::class,
            'category_product'
        );
    }

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

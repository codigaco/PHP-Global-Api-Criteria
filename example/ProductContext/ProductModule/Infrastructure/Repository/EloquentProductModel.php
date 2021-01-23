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
            'category_product',
            'product_id',
            'category_id',
        );
    }

    public function cast(): Product
    {
        $categories = [];
        foreach ($this->categories as $category) {
            $categories[] = $category->cast();
        }

        return new Product(
            $this->id,
            $this->name,
            $this->price,
            $this->stock,
            ...$categories
        );
    }
}

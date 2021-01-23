<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\Category;

class EloquentCategoryModel extends Model
{
    protected $table = 'category';

    public function products()
    {
        return $this->belongsToMany(EloquentProductModel::class,
            'category_product',
            'category_id',
            'product_id',
        );
    }

    public function cast(): Category
    {
        return new Category(
            $this->id,
            $this->name
        );
    }
}

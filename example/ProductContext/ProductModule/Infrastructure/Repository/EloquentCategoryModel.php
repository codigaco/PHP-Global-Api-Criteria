<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\Category;

class EloquentCategoryModel extends Model
{
    protected $table = 'category';


    public function cast(): Category
    {
        return new Category(
            $this->id,
            $this->name
        );
    }
}

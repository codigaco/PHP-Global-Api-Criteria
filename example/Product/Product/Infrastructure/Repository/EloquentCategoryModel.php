<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;
use QuiqueGilB\GlobalApiCriteria\Example\Product\Product\Domain\Model\Category;

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

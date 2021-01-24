<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\CriteriaModule\Criteria\Application\Apply;

use Illuminate\Database\Capsule\Manager;
use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply\EloquentApplyCriteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject\Paginate;

class EloquentApplyCriteriaTest extends TestCase
{
    private $databaseManager;

    protected function setUp(): void
    {
        $capsule = new Manager();

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => __DIR__ . '/storage.db',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->databaseManager = $capsule->getDatabaseManager();
    }

    /** @test */
    public function createQuery(): void
    {
        $criteria = Criteria::create()
            ->withFilter(FilterGroup::deserialize('category.name = Home'))
            ->withPaginate(Paginate::create(0, 1));

        $builder = $this->databaseManager->table('product');
        $builder->select('product.*');

        if ($criteria->hasField('category')) {
            $builder->join('category_product',
                'product.id',
                '=',
                'category_product.product_id',
                'left'
            );
            $builder->join('category',
                'category.id',
                '=',
                'category_product.category_id',
                'left'
            );
        }

        EloquentApplyCriteria::apply($builder, $criteria);

        $result = $builder->get();

        self::assertCount(1, $result);
        self::assertEquals(2, $result[0]->id);
    }
}

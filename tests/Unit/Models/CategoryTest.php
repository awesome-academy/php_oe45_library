<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Category();

        $this->assertEquals(
            ['cate_name',
            'cate_desc',
            'parent_id',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Category::unguard();
        $initial = [
            'cate_name' => 'Truyện trinh thám',
            'cate_desc' => 'Các bộ truyện trinh thám hấp dẫn',
            'parent_id' => 2,
        ];
        $m = new Category($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testBooksRelation()
    {
        $m = new Category();
        $relation = $m->books();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('books.cate_id', $relation->getQualifiedForeignKeyName());
    }

    public function testSubCategoriesRelation()
    {
        $m = new Category();
        $relation = $m->subCategories();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('categories.parent_id', $relation->getQualifiedForeignKeyName());
    }

    public function testParentCategoryRelation()
    {
        $m = new Category();
        $relation = $m->parentCategory();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('cate_id', $relation->getOwnerKeyName());
    }
}

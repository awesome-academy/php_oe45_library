<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Borrow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Borrow();

        $this->assertEquals(
            ['user_id',
            'book_id',
            'borrow_status',
            'borrow_date',
            'return_date',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Borrow::unguard();
        $initial = [
            'user_id' => 1,
            'book_id' => 2,
            'borrow_status' => 1,
            'borrow_date' => '2021-07-05',
            'return_date' => '2021-07-10',
        ];
        $m = new Borrow($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testUserRelation()
    {
        $m = new Borrow();
        $relation = $m->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
        $this->assertEquals('user_id', $relation->getOwnerKeyName());
    }

    public function testBookRelation()
    {
        $m = new Borrow();
        $relation = $m->book();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('book_id', $relation->getForeignKeyName());
        $this->assertEquals('book_id', $relation->getOwnerKeyName());
    }
}

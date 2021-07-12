<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Review;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Review();

        $this->assertEquals(
            ['user_id',
            'book_id',
            'comment',
            'rating',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Review::unguard();
        $initial = [
            'user_id' => '1',
            'book_id' => '2',
            'comment' => 'Sách rất hay',
            'rating' => '5'
        ];
        $m = new Review($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testUserRelation()
    {
        $m = new Review();
        $relation = $m->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
        $this->assertEquals('user_id', $relation->getOwnerKeyName());
    }

    public function testBookRelation()
    {
        $m = new Review();
        $relation = $m->book();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('book_id', $relation->getForeignKeyName());
        $this->assertEquals('book_id', $relation->getOwnerKeyName());
    }
}

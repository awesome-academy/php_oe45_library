<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Bookfollow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookfollowTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Bookfollow();

        $this->assertEquals(
            ['user_id',
            'book_id',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Bookfollow::unguard();
        $initial = [
            'user_id' => '1',
            'book_id' => '2',
        ];
        $m = new Bookfollow($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testUserRelation()
    {
        $m = new Bookfollow();
        $relation = $m->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
        $this->assertEquals('user_id', $relation->getOwnerKeyName());
    }

    public function testBookRelation()
    {
        $m = new Bookfollow();
        $relation = $m->book();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('book_id', $relation->getForeignKeyName());
        $this->assertEquals('book_id', $relation->getOwnerKeyName());
    }
}

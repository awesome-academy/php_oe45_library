<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Like;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LikeTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Like();

        $this->assertEquals(
            ['book_id',
            'user_id',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Like::unguard();
        $initial = [
            'book_id' => '1',
            'user_id' => '2',
        ];
        $m = new Like($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testBookRelation()
    {
        $m = new Like();
        $relation = $m->book();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('book_id', $relation->getForeignKeyName());
        $this->assertEquals('book_id', $relation->getOwnerKeyName());
    }

    public function testUserRelation()
    {
        $m = new Like();
        $relation = $m->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
        $this->assertEquals('user_id', $relation->getOwnerKeyName());
    }
}

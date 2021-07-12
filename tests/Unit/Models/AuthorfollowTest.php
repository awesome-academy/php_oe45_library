<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Authorfollow;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorfollowTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Authorfollow();

        $this->assertEquals(
            ['user_id',
            'author_id',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Authorfollow::unguard();
        $initial = [
            'user_id' => '1',
            'author_id' => '2',
        ];
        $m = new Authorfollow($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testUserRelation()
    {
        $m = new Authorfollow();
        $relation = $m->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
        $this->assertEquals('user_id', $relation->getOwnerKeyName());
    }

    public function testAuthorRelation()
    {
        $m = new Authorfollow();
        $relation = $m->author();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('author_id', $relation->getForeignKeyName());
        $this->assertEquals('author_id', $relation->getOwnerKeyName());
    }
}

<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new User();

        $this->assertEquals(
            ['name',
            'email',
            'password'],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        User::unguard();
        $initial = [
            'name' => 'Tung Hoang',
            'email' => 'minhtungg2504@gmail.com',
            'password' => md5('123456'),
        ];
        $m = new User($initial);
        $m->setHidden(
            [
                'password' => md5('123456'),
                'remember_token' => Str::random(20),
            ]
        );
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testAuthorfollowsRelation()
    {
        $m = new User();
        $relation = $m->authorfollows();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('authorfollows.user_id', $relation->getQualifiedForeignKeyName());
    }

    public function testBookfollowsRelation()
    {
        $m = new User();
        $relation = $m->bookfollows();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('bookfollows.user_id', $relation->getQualifiedForeignKeyName());
    }

    public function testBorrowsRelation()
    {
        $m = new User();
        $relation = $m->borrows();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('borrows.user_id', $relation->getQualifiedForeignKeyName());
    }
    
    public function testLikesRelation()
    {
        $m = new User();
        $relation = $m->likes();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('likes.user_id', $relation->getQualifiedForeignKeyName());
    }

    public function testReviewsRelation()
    {
        $m = new User();
        $relation = $m->reviews();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('reviews.user_id', $relation->getQualifiedForeignKeyName());
    }
}

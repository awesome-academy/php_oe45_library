<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Book();

        $this->assertEquals(
            ['book_title',
            'book_img',
            'cate_id',
            'author_id',
            'pub_id',
            'quantity',
            'book_desc'],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Book::unguard();
        $initial = [
            'book_title' => 'Mat Ma Davinci',
            'book_img' => 'matmadavinci.jpg',
            'cate_id' => '2',
            'author_id' => '1',
            'pub_id' => '1',
            'quantity' => '4',
            'book_desc' => 'Best book ever',
        ];
        $m = new Book($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testAuthorRelation()
    {
        $m = new Book();
        $relation = $m->author();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('author_id', $relation->getForeignKeyName());
        $this->assertEquals('author_id', $relation->getOwnerKeyName());
    }

    public function testPublisherRelation()
    {
        $m = new Book();
        $relation = $m->publisher();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('pub_id', $relation->getForeignKeyName());
        $this->assertEquals('pub_id', $relation->getOwnerKeyName());
    }

    public function testCategoryRelation()
    {
        $m = new Book();
        $relation = $m->category();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('cate_id', $relation->getForeignKeyName());
        $this->assertEquals('cate_id', $relation->getOwnerKeyName());
    }

    public function testBorrowsRelation()
    {
        $m = new Book();
        $relation = $m->borrows();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('borrows.book_id', $relation->getQualifiedForeignKeyName());
    }

    public function testLikesRelation()
    {
        $m = new Book();
        $relation = $m->likes();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('likes.book_id', $relation->getQualifiedForeignKeyName());
    }

    public function testReviewsRelation()
    {
        $m = new Book();
        $relation = $m->reviews();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('reviews.book_id', $relation->getQualifiedForeignKeyName());
    }

    public function testBookfollowsRelation()
    {
        $m = new Book();
        $relation = $m->bookfollows();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('bookfollows.book_id', $relation->getQualifiedForeignKeyName());
    }
}

<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuthorTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Author();

        $this->assertEquals(
            ['author_name',
            'author_desc',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Author::unguard();
        $initial = [
            'author_name' => 'J.K. Rowling',
            'author_desc' => 'An author of Harry Potter series',
        ];
        $m = new Author($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testBooksRelation()
    {
        $m = new Author();
        $relation = $m->books();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('books.author_id', $relation->getQualifiedForeignKeyName());
    }

    public function testAuthorfollowsRelation()
    {
        $m = new Author();
        $relation = $m->authorfollows();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('authorfollows.author_id', $relation->getQualifiedForeignKeyName());
    }
}

<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PublisherTest extends TestCase
{
    public function testContainsValidFillableProperties()
    {
        $m = new Publisher();

        $this->assertEquals(
            ['pub_name',
            'pub_desc',],
            $m->getFillable()
        );
    }

    public function testPropertiesHaveValidValues()
    {
        Publisher::unguard();
        $initial = [
            'pub_name' => 'NXB Nhã Nam',
            'pub_desc' => 'Nhà xuất bản dành cho giới trẻ',
        ];
        $m = new Publisher($initial);
        $m->setHidden([]);
        $this->assertEquals($initial, $m->attributesToArray());
    }

    public function testBooksRelation()
    {
        $m = new Publisher();
        $relation = $m->books();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('books.pub_id', $relation->getQualifiedForeignKeyName());
    }
}

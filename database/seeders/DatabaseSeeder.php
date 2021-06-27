<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(AuthorsSeeder::class);
        $this->call(PublishersSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(BorrowsSeeder::class);
        $this->call(LikesSeeder::class);
        $this->call(ReviewsSeeder::class);
        $this->call(AuthorFollowsSeeder::class);
        $this->call(BookFollowsSeeder::class);
    }
}

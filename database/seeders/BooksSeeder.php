<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Book::create([
                'author_id' => $faker->numberBetween($min = 1, $max = 10),
                'pub_id' => $faker->numberBetween($min = 1, $max = 10),
                'cate_id' => $faker->numberBetween($min = 1, $max = 3),
                'book_title' => 'Kính vạn hoa ' . $i,
                'book_desc' => 'Kính vạn hoa tập hợp những câu chuyện vui nhộn, hồn nhiên của tuổi học trò',
                'quantity' => $faker->numberBetween($min = 50, $max = 100),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bookfollow;

class BookFollowsSeeder extends Seeder
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
            Follow::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'book_id' => $faker->numberBetween($min = 1, $max = 10),
            ]);
        }
    }
}

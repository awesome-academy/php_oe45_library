<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Borrow;

class BorrowsSeeder extends Seeder
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
            Borrow::create([
                'user_id' => $faker->numberBetween($min = 1, $max = 10),
                'book_id' => $faker->numberBetween($min = 1, $max = 10),
                'borrow_status' => $faker->numberBetween($min = 0, $max = 1),
                'borrow_date' => $faker->dateTime($max = 'now', $timezone = null),
                'return_date' => $faker->dateTime($max = 'now', $timezone = null),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Author::create([
                'author_name' => 'Nguyễn Nhật Ánh '. $i,
                'author_desc' => 'Cây bút dành cho tuổi học trò ' . $i,
            ]);
        }
    }
}

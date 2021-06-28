<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Publisher::create([
                'pub_name' => 'Nhà xuất bản ' . $i,
                'pub_desc' => 'Nhà xuất bản phục vụ cho mọi đối tượng bạn đọc từ thiếu nhi cho tới thanh thiếu niên',
            ]);
        }
    }
}

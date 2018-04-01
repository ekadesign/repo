<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Forum\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($i = 0; $i < 40; $i++){
            Message::create([
                'text' => $faker->paragraph(5),
                'topic_id' => random_int(1, 35),
                'user_id' => 1,
            ]);
        }
        for($i = 0; $i < 200; $i++){
            Message::create([
                'text' => $faker->paragraph(5),
                'parent_id' => random_int(1, 40),
                'topic_id' => random_int(1, 35),
                'user_id' => 1,
            ]);
        }
        for($i = 0; $i < 200; $i++){
            Message::create([
                'text' => $faker->paragraph(5),
                'parent_id' => random_int(40, 200),
                'topic_id' => random_int(1, 35),
                'user_id' => 1,
            ]);
        }
        for($i = 0; $i < 200; $i++){
            Message::create([
                'text' => $faker->paragraph(5),
                'parent_id' => random_int(200, 400),
                'topic_id' => random_int(1, 35),
                'user_id' => 1,
            ]);
        }
        for($i = 0; $i < 400; $i++){
            Message::create([
                'text' => $faker->paragraph(5),
                'parent_id' => random_int(400, 800),
                'topic_id' => random_int(1, 35),
                'user_id' => 1,
            ]);
        }
    }
}

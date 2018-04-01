<?php

use Illuminate\Database\Seeder;
use \App\Models\Forum\Topic;
use \Faker\Factory;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://www.cryptocompare.com/api/data/coinlist/');
        $response = $request;
        $items = json_decode($response->getBody()->getContents());
        foreach ($items->Data as $item){
            Topic::create([
                'name' => $faker->word . ' ' . $faker->word . ' ' . $faker->word,
                'symbol' => $item->Symbol,
                'tags' => implode(', ', (array)$faker->words(5)),
                'views' => random_int(20, 120),
                'user_id' => 1,
                'text' => $faker->paragraph(5),
                'category_id' => 2,
            ]);
        }

        for($i = 0; $i < 35; $i++){
            Topic::create([
                'name' => $faker->word . ' ' . $faker->word . ' ' . $faker->word,
                'tags' => implode(', ', (array)$faker->words(5)),
                'views' => random_int(20, 120),
                'user_id' => 1,
                'text' => $faker->paragraph(5),
                'category_id' => 2,
            ]);
        }
    }
}


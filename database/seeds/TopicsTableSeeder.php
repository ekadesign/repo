<?php

use Illuminate\Database\Seeder;
use \App\Models\Forum\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $client = new \GuzzleHttp\Client();
        $request = $client->get('https://www.cryptocompare.com/api/data/coinlist/');
        $response = $request;
        $items = json_decode($response->getBody()->getContents());
        foreach ($items->Data as $item){
            Topic::create([
                'name' => "{$item->CoinName} forum",
                'symbol' => $item->Symbol,
                'tags' => implode(', ', ["{$item->CoinName}", "coins"]),
                'views' => random_int(20, 120),
                'user_id' => 1,
                'text' => "Here you can talk about {$item->CoinName} and discuss news related to it",
                'category_id' => 2,
            ]);
        }
    }
}


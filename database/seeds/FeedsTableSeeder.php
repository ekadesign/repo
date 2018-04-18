<?php

use Illuminate\Database\Seeder;
use App\Models\RssFeed;

class FeedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RssFeed::create([
            'name' => 'newbtc', 'link' => 'https://www.newsbtc.com/feed/'
        ]);

        RssFeed::create([
            'name' => 'coindesk', 'link' => 'https://www.coindesk.com/feed/'
        ]);

        RssFeed::create([
            'name' => 'ccn', 'link' => 'https://www.ccn.com/feed/'
        ]);

        RssFeed::create([
            'name' => 'cointelegraph', 'link' => 'https://cointelegraph.com/feed'
        ]);
    }
}

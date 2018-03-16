<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\RssFeed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use willvincent\Feeds\Facades\FeedsFacade;

class RssFeedSync extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync rss feeds with database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        //getLinks
        $feeds = RssFeed::all();


        //fetch links
        foreach ($feeds as $feed) {

            $currentFeed = FeedsFacade::make($feed->link);

            if (!$currentFeed) {
                Log::info('not correct feed ' . $feed->link);
                continue;
            }


            //get full data of rss feed
            $data = array(
                'title' => $currentFeed->get_title(),
                'permalink' => $currentFeed->get_permalink(),
                'items' => $currentFeed->get_items(),
            );

            //save news
            foreach ($data['items'] as $item) {
                if (News::where('link', $item->get_permalink())->first()) {
                    continue;
                }
                $res = [
                    'title' => $item->get_title(),
                    'link' => $item->get_permalink(),
                    'description' => $item->get_description(),
                    'time' => (int)strtotime($item->get_date()),
                ];

                News::create($res);
            }
        }
    }
}

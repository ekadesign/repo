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
            foreach ($data['items'] as  $key => $item) {

                if (News::where('link', $item->get_permalink())->first()) {
                    continue;
                }
                //get_tags
                $tags = [];
                foreach ($item->get_categories() as $category){
                    $tags [] = $category->get_label();
                }

                //get images
                if($item->get_enclosure()){
                    $img = $item->get_enclosure()->get_link();
                }
                if(!$img) {
                    $dom = new \DOMDocument();
                    @$dom->loadHTML($item->get_content());
                    $res = $dom->getElementsByTagName('img')->item(0);
                    if ($res) {
                        $img = $res->getAttribute('src');
                    }
                }

                //trim tags, new lines, etc
                $descriptionWithOutHtml = trim(preg_replace('/\s+/', ' ', strip_tags($item->get_description())));

                $description = substr($descriptionWithOutHtml, 0, 600);


                $res = [
                    'title' => $item->get_title(),
                    'image' => $img ?? null,
                    'link' => $item->get_permalink(),
                    //if description > 200 symbols trim string and add ... else show full description
                    'description' => strlen($description) === 600 ? substr($description, 0,strrpos($description, ' ')).'...' : $description,
                    'time' => (int)strtotime($item->get_date()),
                    'tags' => serialize(array_slice($tags, 0, 7)),
                ];

                News::create($res);
                $this->info('item created ' . $item->get_title());
            }
        }
    }
}

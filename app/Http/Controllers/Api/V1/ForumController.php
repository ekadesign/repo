<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\MessageResource;
use App\Http\Resources\TopicResource;
use App\Models\Forum\Category;
use App\Models\Forum\Message;
use App\Models\Forum\Topic;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ForumController extends Controller {
    public function index() {
        return response()->json(Category::paginate(5));
    }
    // category {cryptos}
    public function getTopicsByCategoryName($name) {
        return response()->json(Category::where('name', $name)->first()->topics()->paginate(5));
    }
    // category/cryptos {xmr}
    public function getTopicByTopicName($name) {
        return new TopicResource(Topic::where('symbol', strtoupper($name))->first());
    }
    // topic/18
    public function getMessagesByTopicId($id) {
        $collection = Topic::find($id)->messages()->where('parent_id', 0)->with('user')->get();
        return $this->paginateWithPrepend($collection, $id);
    }

    public function getHotTopics(Request $request){
        $topics = (new Topic())->newQuery();
        $collection = $topics->get()->sortByDesc(function ($topic) {
            return count($topic->messages);
        });
        return response()->json($collection->take(5)->values()->toArray());
    }

    public function getAllTopics(Request $request) {
        $topics = (new Topic())->newQuery();

        switch ($request->input('sort')) {
            case 'newest' :
                $collection = $topics->get()->sortByDesc('updated_at');
                break;
            case 'oldest' :
                $collection = $topics->get()->sortBy('updated_at');
                break;
            case 'top' :
                $collection = $topics->get()->sortByDesc(function ($topic) {
                    return count($topic->messages);
                });
                break;
            default:
                $collection = Topic::get();
        }

        $collection->map(function ($item) {
            $item->last_reply_date =  $item->messages()->count() ? $item->messages()->latest()->first()->created_at : null;
            $item->last_reply_name = $item->messages()->count() ? $item->messages()->latest()->first()->user()->first()->name : null;
            return $item;
        });

        return response()->json($this->paginate($collection->values()->toArray(), 5));
        //return TopicResource::collection($this->paginate($collection->values(), 5));
    }

    public function getAllCategories() {
        return response()->json(Category::paginate(5));
    }

    public function reply(Request $request) {

        $jwt = mb_substr($request->header('Authorization'), 7);

        $user = (new UserRepository())->getUserByDecodedJWT($jwt);


        $input = [
            'text' => $request->input('text'),
            'parent_id' => $request->input('parent_id'),
            'topic_id' => $request->input('topic_id'),
            'user_id' => $user->id,
        ];
        Message::create($input);
        return response()->json(['success' => true], 200);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, $options);
    }

    public function paginateWithPrepend($items, $topicId, $perPage = 15, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage)->values()->prepend([new MessageResource(Topic::find($topicId))]), $items->count(), $perPage, $page, $options);
    }
}


<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Forum\Category;
use App\Models\Forum\Message;
use App\Models\Forum\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ForumController extends Controller {
    public function index() {
        return response()->json(Category::paginate(5));
    }

    public function getTopicsByCategoryName($name) {
        return response()->json(Category::where('name', $name)->first()->topics()->paginate(5));
    }

    public function getTopicByTopicName($name) {
        return response()->json(Topic::where('symbol', $name)->first()->with('user', 'messages')->first());
    }

    public function getMessagesByTopicId($id) {
        return response()->json(Topic::find($id)->messages()->with('user')->paginate(15));
    }

    public function getHotTopics(Request $request){
        $topics = (new Topic())->newQuery();
        $collection = $topics->get()->sortByDesc(function ($topic) {
            return count($topic->messages);
        });
        return response()->json($collection->take(5));
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
                $collection = Topic::all();
        }

        return response()->json($this->paginate($collection, 5));
    }

    public function getAllCategories() {
        return response()->json(Category::paginate(5));
    }

    public function reply(Request $request) {
        Message::create($request->all());
        return response()->json(['success' => true], 200);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = []) {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}


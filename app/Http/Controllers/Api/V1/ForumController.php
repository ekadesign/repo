<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Forum\Category;
use App\Models\Forum\Message;
use App\Models\Forum\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumController extends Controller
{
    public function index (){
        return response()->json(Category::paginate(5));
    }

    public function getTopicsByCategoryId($id){
        return response()->json(Category::find($id)->topics()->paginate(5));
    }

    public function getMessagesByTopicId($id){
        return response()->json(Topic::find($id)->messages()->with('user')->paginate(15));
    }

    public function reply(Request $request){
        Message::create($request->all());
        return response()->json(['success' => true], 200);
    }
}

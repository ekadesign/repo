<?php

namespace App\Http\Controllers\Forum;

use App\Models\Forum\Category;
use App\Models\Forum\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function index(){
        $topics = Topic::paginate(10);
        return view('pages.forum.topics.index', compact('topics'));
    }

    public function create(){
        $categories = Category::all();
        return view('pages.forum.topics.create', compact('categories'));
    }

    public function store(Request $request){

        (new Topic($request->all()))->save();

        return redirect()->route('topics.index');
    }

    public function edit($id){
        $categories = Category::all();
        $topic = Topic::findOrFail($id);
        return view('pages.forum.topics.edit', compact('topic', 'categories'));
    }

    public function update(Request $request, $id){

        (Topic::find($id))->update($request->all());

        return redirect()->route('topics.index');

    }

    public function destroy($id){

        Topic::destroy($id);

        return redirect()->route('topics.index');
    }
}

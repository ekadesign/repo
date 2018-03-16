<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedRequest;
use App\Models\RssFeed;

class FeedController extends Controller
{
    public function index(){
        $feeds = RssFeed::paginate(5);
        return view('pages.rss.index', compact('feeds'));
    }

    public function create(){
        return view('pages.rss.create');
    }

    public function store(FeedRequest $request){

        RssFeed::create($request->all());

        return redirect()->route('feed.index');
    }

    public function edit($id){
        $feed = RssFeed::findOrFail($id);
        return view('pages.rss.edit', compact('feed'));
    }

    public function update(FeedRequest $request, $id){

        RssFeed::find($id)->update($request->all());

        return redirect()->route('feed.index');

    }

    public function destroy($id){

        RssFeed::destroy($id);

        return redirect()->route('feed.index');
    }
}

<?php

namespace App\Http\Controllers\Forum;

use App\Models\Forum\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::paginate(10);
        return view('pages.forum.categories.index', compact('categories'));
    }

    public function create(){
        return view('pages.forum.categories.create');
    }

    public function store(Request $request){

        Category::create($request->all());

        return redirect()->route('categories.index');
    }

    public function edit($id){
        $category = Category::findOrFail($id);
        return view('pages.forum.categories.edit', compact('category'));
    }

    public function update(Request $request, $id){

        Category::find($id)->update($request->all());

        return redirect()->route('categories.index');

    }

    public function destroy($id){

        Category::destroy($id);

        return redirect()->route('categories.index');
    }
}

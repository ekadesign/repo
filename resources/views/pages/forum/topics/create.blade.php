@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('topics.store')}}" method="post">
            @method('post')
            @csrf
            <div class="form-group">
                <label for="formGroupExampleInput">name</label>
                <input type="text" class="form-control" name="name" placeholder="Pls insert name of topic">
                <label for="formGroupExampleInput">tags</label>
                <input type="text" class="form-control" name="tags" placeholder="Pls insert tags of topic">
                <label for="formGroupExampleInput">text</label>
                <input type="text" class="form-control" name="text" placeholder="Pls insert text of topic">
                <label for="formGroupExampleInput">category</label>
                <select class="form-control" name="category_id" id="">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" class="btn btn-info" value="Submit">
        </form>
    </div>
    @endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('categories.store')}}" method="post">
            @method('post')
            @csrf
            <div class="form-group">
                <label for="formGroupExampleInput">name</label>
                <input type="text" class="form-control" name="name" placeholder="Pls insert name of category">
            </div>
            <input type="submit" class="btn btn-info" value="Submit">
        </form>
    </div>
    @endsection
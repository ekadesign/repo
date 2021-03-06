@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('feed.update', ['id' => $feed->id])}}" method="post">
            @method('put')
            @csrf
            <div class="form-group">
                <label for="formGroupExampleInput">name</label>
                <input type="text" class="form-control" name="name" value="{{ $feed->name}}" placeholder="Pls insert name of feed">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">link</label>
                <input type="text" class="form-control" name="link" value="{{ $feed->link}}" placeholder="Pls paste rss link">
            </div>
            <input type="submit" class="btn btn-info" value="Submit">
        </form>
    </div>
    @endsection
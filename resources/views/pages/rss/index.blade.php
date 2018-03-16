@extends('layouts.app')

@section('content')
    <div class="container">
    <a class="btn btn-info float-right" href="{{route('feed.create')}}">Create</a>

    @foreach($feeds as $feed)
        <ul>
            <li>{{$feed->name}}</li>
            <li>{{$feed->link}}</li>
            <li><a class="btn btn-info" href="{{route('feed.edit', ['id' => $feed->id])}}">edit</a></li>
            <li>
                <form class="form-inline" action="{{route('feed.destroy', ['id' => $feed->id])}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" class="btn btn-danger" value="delete"></input>
                </form></li>
        </ul>
    @endforeach
    </div>
@endsection
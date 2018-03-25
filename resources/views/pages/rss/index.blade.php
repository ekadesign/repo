@extends('layouts.app')

@section('content')
    <div class="container">
    <a class="btn btn-info float-right" href="{{route('feed.create')}}">Create</a>
    <table class="table">
        <thead>
        <th>name</th>
        <th>link</th>
        <th colspan="2">actions</th>
        </thead>
        <tbody>
    @foreach($feeds as $feed)
        <tr>
            <td>{{$feed->name}}</td>
            <td>{{$feed->link}}</td>
            <td><a class="btn btn-info" href="{{route('feed.edit', ['id' => $feed->id])}}">edit</a></td>
            <td>
                <form class="form-inline" action="{{route('feed.destroy', ['id' => $feed->id])}}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" class="btn btn-danger" value="delete"></input>
                </form></td>
        </tr>
    @endforeach
        </tbody>
    </table>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-info float-right" href="{{route('topics.create')}}">Create</a>

        <table class="table">
            <thead>
            <th>name</th>
            <th>symbol</th>
            <th>author</th>
            <th>tags</th>
            <th>views</th>
            <th>category</th>
            <th colspan="2">actions</th>
            </thead>
            <tbody>
        @foreach($topics as $topic)
            <tr>
                <td>{{$topic->name}}</td>
                <td>{{$topic->symbol}}</td>
                <td>{{$topic->user->name ?? ''}}</td>
                <td>{{$topic->human_tags}}</td>
                <td>{{$topic->views}}</td>
                <td>{{$topic->category->name}}</td>
                <td><a class="btn btn-info" href="{{route('topics.edit', ['id' => $topic->id])}}">edit</a></td>
                <td>
                    <form class="form-inline" action="{{route('topics.destroy', ['id' => $topic->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" class="btn btn-danger" value="delete"></input>
                    </form></td>
            </tr>
        @endforeach
            </tbody>
        </table>
        {{$topics->links()}}
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-info float-right" href="{{route('categories.create')}}">Create</a>
        <table class="table">
            <thead>
            <th>name</th>
            <th colspan="2">actions</th>
            </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{$category->name}}</td>
                <td><a class="btn btn-info" href="{{route('categories.edit', ['id' => $category->id])}}">edit</a></td>
                <td>
                    <form class="form-inline" action="{{route('categories.destroy', ['id' => $category->id])}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" class="btn btn-danger" value="delete"></input>
                    </form></td>
            </tr>
        @endforeach
        </tbody>
        </table>
        {{$categories->links()}}
    </div>
@endsection
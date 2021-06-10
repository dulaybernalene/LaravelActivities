@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a class="btn button btn-info" href="/posts/create">Create New</a></div>
                <div class="card-body">
                    <table style="width: 100%" class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $value)
                            <tr>
                                <td>{{$value->id}}</td>
                                <td>{{$value->title}}</td>
                                <td>{{$value->description}}</td>
                                <td><a href="/posts/{{$value->id}}" class="btn btn-info">View</a></td>
                                <td><a href="/posts/{{$value->id}}/edit" class="btn btn-warning">Edit</a></td>
                                <td> 
                                    <form action="{{ route('posts.destroy', $value->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Delete </button>

                                    </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
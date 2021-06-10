@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a class="btn button btn-info" href="/posts">Back</a></div>
                <div class="card-body">
                   Title: {{ $posts->title }}<br>
                   Description: {{ $posts->description }}<br>
                   Creted At: {{ $posts->created_at }}<br>
                   Image: 

                   <img src="{{ asset('/storage/img/'.$posts->img) }}">
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
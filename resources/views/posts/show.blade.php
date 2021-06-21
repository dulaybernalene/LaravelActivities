@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a class="btn button btn-info" href="/posts">Back</a></div>
                <div class="card-body">
                   Title: {{ $post->title }}<br>
                   Description: {{ $post->description }}<br>
                   Creted At: {{ $post->created_at }}<br>
                   @if ($post->img != '')
                   Image: 

                   <img src="{{ asset('/storage/img/'.$post->img) }}">
                   @endif
                   @if ($comments)
                   @foreach ($comments as $comment)
                       <div class="display-comment" >

                           <p>{{ $comment->description }}</p>
                           <a href="" id="reply"></a>
                           <form method="post" action="{{ route('comments.store') }}">
                               @csrf
                               <div class="form-group">
                                   <input type="text" name="description" class="form-control" />
                                   <input type="hidden" name="post_id" value="{{ $comment->post_id }}" />
                                   <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                               </div>
                               <div class="form-group">
                                   <input type="submit" class="btn btn-warning" value="Reply" />
                               </div>
                           </form>
                       </div>
                   @endforeach                            
               @endif
                   <h4>Add Comment </h4>
                        <form method="post" action="{{ route('comments.store') }}">  
                            @csrf
                            <div class="form-group">    
                                <textarea name="description" id="description" class="form-control"></textarea>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">                        
                            </div>
                            <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Add Comment">
                            </div>
            
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
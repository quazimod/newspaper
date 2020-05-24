@extends('layouts.app')

@section('scripts')
<script src="{{ asset('js/post.js') }}" defer></script>
@endsection

@section('content')
<div id="app">
    <div class="d-flex">
        <div class="post-container col-md-6">
            <div class="post-body card pl-2">
                <div class="card-body pb-0 flex-grow-0">
                    <h3 class="card-title">{{$post->title}}</h4>
                </div>
                @if ($post->image_url)
                    <img class="card-body card-img pt-0" src="{{$post->image_url}}" alt="">
                @endif
                <div class="card-body flex-grow-1">
                    <p class="card-text">{{$post->content}}</p>
                    <a href="{{$post->source_url}}" class="btn btn-primary">
                        {{$post->author->name}}
                    </a>
                </div>
                <div class="card-body flex-grow-1">
                    <div class="post-item-activities">
                        <div class="post-item-activity like-activity">
                            {{ $post->likes->count() }}
                        </div>
                        <div class="post-item-activity comment-activity">
                            {{ $post->comments->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <input hidden value="{{$post->author->id}}" ref="post_author_id">
        </div>
        <div class="author-posts-container d-inline-flex flex-column">
            <h4 class="card-title pl-4 pt-2 ">
                More by
                <a href="{{$post->author->url}}">
                    {{$post->author->name}}
                </a> :
            </h4>
            <div>
                <post-item v-for="(author_post, id) in posts" 
                    :key="id" :post="author_post" :author="author">
                </post-item>
            </div>
        </div>
    </div>
</div>
@endsection
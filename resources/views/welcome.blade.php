@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/welcome.js') }}" defer></script>
@endsection

@section('content')
    <div id="app" class="content container newspaper-container">
        <div class="post-items-container row justify-content-between">
            <post-item v-for="post in posts"
                :key="post.id"
                :post="post"
                :author="post.author">
            </post-item>
        </div>
    </div>
@endsection

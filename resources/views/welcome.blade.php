@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('content')
    <div id="app" class="content container newspaper-container">
        <div class="newspaper-page row">
            <post-item v-for="post in posts"
                       v-bind:key="post.id"
                       v-bind:post="post"></post-item>
        </div>
    </div>
@endsection

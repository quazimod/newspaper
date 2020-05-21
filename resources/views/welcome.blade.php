@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        html, body {
            background-color: #ffffff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        img {
            max-width: 100%;
            max-height: 100%;
        }

        /*.full-height {
            height: 100vh;
        }*/

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('content')
    <div id="app" class="content container">
        <div class="newspaper-page row">
            <post-item v-for="post in posts"
                       v-bind:key="post.id"
                       v-bind:post="post"></post-item>
        </div>
    </div>
@endsection

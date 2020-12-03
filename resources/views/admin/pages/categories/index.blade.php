@extends("layouts.app")
@section("content")
    <div id="app">
        @{{ message }}
    </div>
@endsection
@section("scripts")
    <script href="{{ asset('js/categories.js') }}"></script>
@endsection

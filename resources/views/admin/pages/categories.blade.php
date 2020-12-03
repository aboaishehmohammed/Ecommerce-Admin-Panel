@extends("layouts.app")
@section("content")


    <div id="categoryApp" style="margin-top: 50px">


        <router-view></router-view>

    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/adminApp/categories.js') }}" defer></script>
@endsection

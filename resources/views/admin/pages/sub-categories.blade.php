@extends("layouts.app")
@section("content")
    <div id="subCategoryApp" style="margin-top: 50px">




        <router-view></router-view>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/adminApp/sub-categories.js') }}" defer></script>
@endsection

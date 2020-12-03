@extends("layouts.app")
@section("content")


    <div id="reportApp" style="margin-top: 50px">


        <router-view></router-view>

    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/adminApp/reports.js') }}" defer></script>
@endsection

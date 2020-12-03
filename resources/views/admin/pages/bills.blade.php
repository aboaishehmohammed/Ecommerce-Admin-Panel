@extends("layouts.app")
@section("content")


    <div id="billApp" style="margin-top: 50px">


        <router-view></router-view>

    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/adminApp/bills.js') }}" defer></script>
@endsection

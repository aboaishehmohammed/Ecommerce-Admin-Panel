@extends("layouts.app")
@section("content")


    <div id="productApp" style="margin-top: 50px">


        <router-view></router-view>

    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/adminApp/products.js') }}" defer></script>
@endsection

@extends("layouts.app")

@section("styles")

    @stack("home-styles")
@endsection

@section("scripts")
    @stack("home-scripts")
@endsection

@section("content")

    @include("home.layouts.svg")
    @include("home.layouts.style")

    @include("home.layouts.header")

    <main>
        @yield("home-content")
    </main>    

    <hr class="mt-5 text-secondary" />

    @include("home.layouts.footer")

@endsection
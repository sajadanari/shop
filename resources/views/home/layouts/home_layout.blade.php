@extends("layouts.app")

@push("styles")

    @stack("home-styles")
@endpush

@push("scripts")
    @stack("home-scripts")
@endpush

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
@extends('home.layouts.home_layout')

@push("home-styles")
    
    @stack("user-styles")
@endpush

@push("home-scripts")

    @stack("user-scripts")
@endpush

@section("home-content")

    <main class="pt-90">

        <div class="mb-4 pb-4"></div>

        <section class="my-account container">

            <h2 class="page-title">@yield("user-page-title")</h2>
            <div class="row">

                @include("user.layouts.sidebar")

                <div class="col-lg-9">
                    @yield("user-content")
                </div>

            </div>
        </section>
    </main>    

@endsection

@extends("home.layouts.home_layout")

@section('home-content') 

    @include("home.layouts.slider")

    <div class="container mw-1620 bg-white border-radius-10">
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

        @include("home.index.you_might_like")
  
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
  
        @include("home.index.hot_deals")
  
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
  
        @include("home.index.cat")
  
        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
  
        @include("home.index.featured_products")
        
      </div>

@endsection

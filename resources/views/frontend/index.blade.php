@extends('frontend.master_dashboard')
@section('main')

<!-- Home Slider -->
@include('frontend.home.home_slider')
<!-- End Home Slider-->

<!-- Home Feature Categories Slider -->
@include('frontend.home.home_feature_categories')
<!-- End Home Feature Categories Slider -->

<!-- Home Banner -->
@include('frontend.home.home_banner')
<!-- End Home Banner -->

<!-- Home New Products -->
@include('frontend.home.home_new_products')
<!-- End Home New Products -->

<!-- Home Feature Products -->
@include('frontend.home.home_feature_products')
<!-- End Home Feature Products -->

<!-- Home TV Category -->
@include('frontend.home.home_tv_category')
<!-- End Home TV Category -->

<!-- Home Tshirt Category -->
@include('frontend.home.home_tshirt_category')
<!-- End Home Tshirt Category -->

<!-- Home Computer Category -->
@include('frontend.home.home_computer_category')
<!-- End Home Computer Category -->

<!-- Home Hot Deals -->
@include('frontend.home.home_hot_deals')
<!-- End Home Hot Deals -->

<!-- Home Vendor List -->
@include('frontend.home.home_vendor_list')
<!-- End Home Vendor List -->

@endsection
<!-- End Section -->
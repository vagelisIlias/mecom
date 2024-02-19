<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>E-shop | Become Vendor Register</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg')}}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3')}}" />
    <!-- Toaster CSS -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>
<body>
    
    <!-- Quick view -->
    {{-- @include('frontend.body.quickview') --}}
    <!-- End Quick view -->

    <!-- Header -->
    @include('frontend.body.header')
    <!-- End Header -->

    <!-- Main Area -->
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Become Vendor</a>
                    <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-5">Become Vendor</h1>
                                            <p class="mb-30">Already have a Vendor account? <a href="{{ route('vendor.login') }}">Vendor Login</a></p>
                                        </div>
                                        {{-- Form starts here --}}
                                        <form method="post" action="{{ route('vendor.register') }}">
                                            @csrf
                                            
                                            <div class="form-group col-md-12">
                                                <label>Firstname<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                                    name="firstname" id="firstname"/>
                                                    @error('firstname')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- end row -->

                                            <div class="form-group col-md-12">
                                                <label>Lastname<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                                    name="lastname" id="lastname"/>
                                                    @error('lastname')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Username<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                                    name="username" id="username"/>
                                                    @error('username')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Shop Name<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('vendor_shop_name') is-invalid @enderror" 
                                                    name="vendor_shop_name" id="vendor_shop_name"/>
                                                    @error('vendor_shop_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Address<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                                    name="address" id="address"/>
                                                    @error('address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Post Code<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('postcode') is-invalid @enderror" 
                                                    name="postcode" id="postcode"/>
                                                    @error('postcode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Contact Number<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                    name="phone" id="phone"/>
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Email<span class="required">*</span></label>
                                                <input type="text" class="form-control @error('email') is-invalid @enderror" 
                                                    name="email" id="email"/>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Password<span class="required">*</span></label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                    name="password" id="password"/>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->

                                            <div class="form-group col-md-12">
                                                <label>Password Confirmation<span class="required">*</span></label>
                                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                    name="password_confirmation" id="password_confirmation"/>
                                                    @error('password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <!-- End row-->
                                            
                                            <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox12" value="" />
                                                        <label class="form-check-label" for="exampleCheckbox12"><span>I agree to terms &amp; Policy.</span></label>
                                                    </div>
                                                </div>
                                                <a href="page-privacy-policy.html"><i class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                            </div>
                                            <div class="form-group mb-30">
                                                <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="login">Submit &amp; Register</button>
                                            </div>
                                            <p class="font-xs text-muted"><strong>Note:</strong>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy</p>
                                        </form>
                                        {{-- Forms end here --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Area -->
   
    <!-- Footer -->
    @include('frontend.body.footer')
    <!-- End Footer -->

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/imgs/theme/loading.gif')}}" alt="" />
                </div>
            </div>
        </div>
    </div>
    
    <!-- Vendor JS-->
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>

    <!-- Toaster JS -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	
	<!-- Toaster JS cases-->
	<script>
		@if(Session::has('message'))
		var type = "{{ Session::get('alert-type','info') }}"
		switch(type){
		   case 'info':
		   toastr.info(" {{ Session::get('message') }} ");
		   break;
	   
		   case 'success':
		   toastr.success(" {{ Session::get('message') }} ");
		   break;
	   
		   case 'warning':
		   toastr.warning(" {{ Session::get('message') }} ");
		   break;
	   
		   case 'error':
		   toastr.error(" {{ Session::get('message') }} ");
		   break; 
		}
		@endif 
	   </script>
</body>
</html>
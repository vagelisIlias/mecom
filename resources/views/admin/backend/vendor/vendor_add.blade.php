@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<!-- Image Reload JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <a href="{{ route('all.vendor.status')}}"class="breadcrumb-title pe-3">Vendor Status</a>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendor Create Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22"></i></div>
                                    <h5 class="mb-0 ">Vendor Registration</h5>
                                </div>
                                {{-- Form starts here --}}
                                <form class="row g-3" id="myForm" method="post" action="{{ route('store.vendor.profile') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <hr>
                                    {{-- Firstname --}}
                                    <div class="form-group col-md-6">
                                        <label for="inputLastName1" class="form-label">First Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-user"></i></span>
                                            <input type="text" name="firstname" class="form-control border-start-0" id="inputLastName1" placeholder="First Name">
                                        </div>
                                    </div>

                                    {{-- Lastname --}}
                                    <div class="form-group col-md-6">
                                        <label for="inputLastName2" class="form-label">Last Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-user"></i></span>
                                            <input type="text" name="lastname" class="form-control border-start-0" id="inputLastName2" placeholder="Last Name">
                                        </div>
                                    </div>

                                    {{-- Username --}}
                                    <div class="form-group col-12">
                                        <label for="inputPhoneNo" class="form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-user-tie"></i></span>
                                            <input type="text" name="username" class="form-control border-start-0" id="inputPhoneNo" placeholder="Username">
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="form-group col-12">
                                        <label for="inputEmail" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control border-start-0" id="inputEmail" placeholder="Email">
                                        </div>
                                    </div>

                                    {{-- Vendor Shop Name --}}
                                    <div class="form-group col-12">
                                        <label for="inputShopName" class="form-label">Vendor Shop Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-shop"></i></span>
                                            <input type="text" name="vendor_shop_name" class="form-control border-start-0" id="inputShopName" placeholder="Vendor Shop Name">
                                        </div>
                                    </div>

                                    {{-- Contact Number --}}
                                    <div class="col-12">
                                        <label for="inputPhoneNumber" class="form-label">Contact Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="bx bxs-phone"></i></span>
                                            <input type="text" name="phone" class="form-control border-start-0" id="inputPhoneNumber" placeholder="Contact Number">
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-location-dot"></i></span>
                                            <input type="text" name="address" class="form-control border-start-0" id="inputAddress" placeholder="Address">
                                        </div>
                                    </div>

                                    {{-- Post Code --}}
                                    <div class="col-12">
                                        <label for="inputPostCode" class="form-label">Post Code</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-location-dot"></i></i></span>
                                            <input type="text" name="postcode" class="form-control border-start-0" id="inputPostCode" placeholder="Postcode">
                                        </div>
                                    </div>

                                    {{-- Vendor Join Date --}}
                                    <div class="col-12">
                                        <label for="inputPostCode" class="form-label">Join Date</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="fa-solid fa-calendar-days"></i></i></span>
                                            <input type="date" name="vendor_join" class="form-control border-start-0" id="inputPostCode" placeholder="Join Date">
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="form-group col-12">
                                        <label for="inputPassword" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="bx bxs-lock-alt"></i></span>
                                            <input type="password" name="password" class="form-control border-start-0" id="inputPassword" placeholder="Password">
                                        </div>
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="col-12">
                                        <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent"><i class="bx bxs-lock-alt"></i></span>
                                            <input type="password" name="password_confirmation" class="form-control border-start-0" id="inputConfirmPassword" placeholder="Confirm Password">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" id="submit-button" class="btn btn" style="background-color: rgb(202, 18, 177); color: white;">Create Vendor Profile</button>
                                    </div>

                            {{-- Form ends here --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End page-content --}}

{{-- JS --}}
<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

{{-- Validation min.JS, creating validation for inputs --}}
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                username: {
                    required: true,
                },
                email: {
                    required: true,
                },
                vendor_shop_name: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                firstname: {
                    required: 'Please Add First Name',
                },
                lastname:{
                    required: 'Please Add Last Name',
                },
                username: {
                    required: 'Please Add Username',
                },
                email: {
                    required: 'Please Add Email Address',
                },
                vendor_shop_name: {
                    required: 'Please Add Vendor Shop Name',
                }, 
                password : {
                    required: 'Please Add Password',
                } 
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
                
            },
            highlight: function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
                console.log('Highlighting:', element.name);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
                console.log('Unhighlighting:', element.name);
            },
        });
    });
</script>

@endsection
{{-- End Section --}}


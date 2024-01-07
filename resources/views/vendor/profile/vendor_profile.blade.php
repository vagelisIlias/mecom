@extends('vendor.vendor_dashboard')
{{-- Start Section --}}
@section('vendor')

<!-- Image Reload JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

{{-- <div class="page-wrapper"> --}}
    <div class="page-content"> 
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <a href="{{ route('vendor.dashboard') }}" class="breadcrumb-title pe-3">Dashboard</a>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Vendor Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">
                                    </label>
                                    <div class="col-sm-10">
                                        <img id="showImage" class="rounded-circle"
                                                src="{{ empty($user->photo) ?
                                                url('upload/vendor_profile_image/'. $user->photo) : url('upload/no_image.jpg') }}" 
                                                alt="Card image cap"        
                                        >
                                    </div>
                                    
                                    <div class="mt-3">
                                        <h4>{{ $user->vendor_shop_name }}</h4>
                                        <p class="text-secondary mb-1">{{ $user->email }}</p>
                                        <p class="text-muted font-size-sm">{{ $user->address }}</p>
                                    </div>
                                </div>
                                <hr class="my-4" />
                                <ul class="list-group list-group-flush">
                                    {{-- Website --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ $user->website }}" class="text-decoration-none" target="_blank">
                                        <h6 class="mb-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="feather feather-globe me-2 icon-inline">
                                            <circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12">
                                                </line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>Website</h6>
                                                <span class="text-secondary"></span>
                                            </h6>
                                        </a>    
                                    </li>
                                    {{-- Facebook --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ $user->facebook }}" class="text-decoration-none" target="_blank">
                                            <h6 class="mb-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 64 64" aria-labelledby="title"
                                                    aria-describedby="desc" role="img" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>Facebook</title>
                                                    <path data-name="layer1"
                                                        d="M39.8 12.2H48V0h-9.7C26.6.5 24.2 7.1 24 14v6.1h-8V32h8v32h12V32h9.9l1.9-11.9H36v-3.7a3.962 3.962 0 0 1 3.8-4.2z"
                                                        fill="#1877f2"></path>
                                                </svg> Facebook
                                            </h6>
                                        </a>
                                    </li>
                                    {{-- Instagram --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ $user->instagram }}" class="text-decoration-none" target="_blank">
                                            <h6 class="mb-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram me-2 icon-inline text-danger">
                                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                                </svg>Instagram
                                            </h6>
                                        </a>
                                    </li>
                                    {{-- Linkedin --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ $user->linkedin }}" class="text-decoration-none" target="_blank">
                                            <div class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" style="fill: rgba(53, 136, 223, 1);">
                                                    <path d="M20 3H4a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM8.339 18.337H5.667v-8.59h2.672v8.59zM7.003 8.574a1.548 1.548 0 1 1 0-3.096 1.548 1.548 0 0 1 0 3.096zm11.335 9.763h-2.669V14.16c0-.996-.018-2.277-1.388-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248h-2.667v-8.59h2.56v1.174h.037c.355-.675 1.227-1.387 2.524-1.387 2.704 0 3.203 1.778 3.203 4.092v4.71z"></path>
                                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                                </svg>
                                                <h6 class="mb-0 ms-1">Linkedin</h6>
                                            </div>
                                        </a>
                                    </li>  
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <!-- Forms Starts Here -->
                                <form class="row g-3" id="myForm" method="POST" action="{{ route('vendor.profile.update', ['user' => $user]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                   
                                <!-- Vendor Shop Name -->
                                <div class="form-group col-md-6">
                                    <label class="form-label">Vendor Shop Name</label>
                                    <div class="input-group">
                                        <input type="text" name="vendor_shop_name"
                                            class="form-control"
                                            value="{{ $user->vendor_shop_name }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Vendor Shop Name -->

                                <!-- First Name -->
                                <div class="form-group col-md-6">
                                    <label class="form-label">Firstname <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="firstname"
                                            class="form-control"
                                            value="{{ $user->firstname }}"
                                        >
                                    </div>
                                    @error('firstname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End First Name -->

                                <!-- Last Name -->
                                <div class="form-group col-12">
                                    <label class="form-label">Lastname <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="lastname"
                                            class="form-control"
                                            value="{{ $user->lastname }}"
                                        >
                                    </div>
                                    @error('lastname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Last Name -->

                                <!-- User Name -->
                                <div class="form-group col-12">
                                    <label class="form-label">Username <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="username"
                                            class="form-control"
                                            value="{{ $user->username }}"
                                        >
                                    </div>
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End User Name -->

                                <!-- Email -->
                                <div class="form-group col-12">
                                    <label class="form-label">Email <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="email"
                                            class="form-control"
                                            value="{{ $user->email }}"
                                        >
                                    </div>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- End Email -->

                                <!-- Instagram -->
                                <div class="form-group col-12">
                                    <label class="form-label">Instagram</label>
                                    <div class="input-group">
                                        <input type="text" name="instagram"
                                            class="form-control"
                                            value="{{ $user->instagram }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Instagram -->

                                <!-- Facebook -->
                                <div class="form-group col-12">
                                    <label class="form-label">Facebook</label>
                                    <div class="input-group">
                                        <input type="text" name="facebook"
                                            class="form-control"
                                            value="{{ $user->facebook }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Facebook -->

                                <!-- Website -->
                                <div class="form-group col-12">
                                    <label class="form-label">Website</label>
                                    <div class="input-group">
                                        <input type="text" name="website"
                                            class="form-control"
                                            value="{{ $user->website }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Website -->

                                <!-- Linkedin -->
                                <div class="form-group col-12">
                                    <label class="form-label">Linkedin</label>
                                    <div class="input-group">
                                        <input type="text" name="linkedin"
                                            class="form-control"
                                            value="{{ $user->linkedin }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Linkedin -->

                                <!-- Contact Number -->
                                <div class="form-group col-12">
                                    <label class="form-label">Contact Number</label>
                                    <div class="input-group">
                                        <input type="text" name="phone"
                                            class="form-control"
                                            value="{{ $user->phone }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Contact Number -->

                                <!-- Address -->
                                <div class="form-group col-12">
                                    <label class="form-label">Address</label>
                                    <div class="input-group">
                                        <input type="text" name="address"
                                            class="form-control"
                                            value="{{ $user->address }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Address -->

                                <!-- Postcode -->
                                <div class="form-group col-12">
                                    <label class="form-label">Postcode</label>
                                    <div class="input-group">
                                        <input type="text" name="postcode"
                                            class="form-control"
                                            value="{{ $user->postcode }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Postcode -->

                                <!-- Role -->
                                <div class="form-group col-12">
                                    <label class="form-label">Role</label>
                                    <div class="input-group">
                                        <input type="text" name="role"
                                            class="form-control"
                                            value="{{ $user->role }}" disabled
                                        >
                                    </div>
                                </div>
                                <!-- End Role -->

                                <!-- Job Title -->
                                <div class="form-group col-12">
                                    <label class="form-label">Job Title</label>
                                    <div class="input-group">
                                        <input type="text" name="job_title"
                                            class="form-control"
                                            value="{{ $user->job_title }}"
                                        >
                                    </div>
                                </div>
                                <!-- End Job Title -->

                                <!-- Vendor Join Date -->
                                <div class="form-group col-12">
                                    <label class="form-label">Vendor Join Date</label>
                                    <div class="input-group">
                                        <input type="text" name="created_at"
                                            class="form-control"
                                            value="{{ $user->created_at }}" disabled
                                        >
                                    </div>
                                </div>
                                <!-- End Vendor Join Date -->

                                <!-- Vendor Update Date -->
                                <div class="form-group col-12">
                                    <label class="form-label">Vendor Join Date</label>
                                    <div class="input-group">
                                        <input type="text" name="updated_at"
                                            class="form-control"
                                            value="{{ $user->updated_at }}" disabled
                                        >
                                    </div>
                                </div>
                                <!-- End Vendor Update Date -->

                                <!-- Vendor Short Info -->
                                <div class="form-group col-12">
                                    <label class="form-label">Vendor Short Info</label>
                                    <div class="input-group">
                                        <textarea type="text" name="vendor_short_info"
                                            class="form-control"
                                            rows="3"
                                            style="height: 142px;">{{ $user->vendor_short_info }}
                                        </textarea>
                                    </div>
                                </div>
                                <!-- End Vendor Short Info -->

                                <!-- Profile Image -->
                                <div class="form-group col-12">
                                    <label class="form-label">Profile Image</label>
                                    <div class="input-group">
                                        <input type="file" name="photo"
                                            id="image"
                                            class="form-control"
                                        >
                                    </div>
                                </div>
                                <!-- End Profile Image -->

                                <!-- Update Prfile Button -->
                                <div class="col-12">
                                    <button type="submit" 
                                            id="submit-button" 
                                            class="submit-button" 
                                            >
                                            Update Profile
                                    </button>
                                </div>
                                <!-- End Update Profile Button -->
                            </div>
                        </form>
                    <!-- Forms Ends Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- </div> --}}

<!-- Image preview -->
<script src="{{ asset('adminbackend/assets/js/image-preview.js') }}"></script>

@endsection
{{-- End Section --}}


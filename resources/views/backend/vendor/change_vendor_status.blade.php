
@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <a href="{{ route('all.vendor.status') }}" class="breadcrumb-title pe-3">Vendor Status Details</a>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendor Status Details</li>
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
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>                                  
                                    <div class="col-sm-10">
                                        <img id="showImage" class="rounded-circle avatar-lg" src="{{ (!empty($checkVendorDetails->photo)) ? 
                                        url('upload/vendor_profile_image/'. $checkVendorDetails->photo) : url('upload/no_image.jpg') }}" 
                                        alt="Card image cap" style="width: 200px; height: 200px; border: 5px solid rgba(138, 60, 221, 0.729);">
                                    </div>
                                    <div class="col-sm-12">
                                        <label style="margin-top: 20px; font-size: 20px; color: black; font-weight: 500">
                                            Vendor Shop Name: {{ $checkVendorDetails->vendor_shop_name }}
                                        </label>
                                    </div>  
                                <div class="mt-3">
                                    <p class="text-secondary mb-1">{{ $checkVendorDetails->job_title }}</p>
                                    <p class="text-muted font-size-sm">Email: {{ $checkVendorDetails->email }}</p>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                           {{-- Form starts here --}}
                            <form method="post" action="{{ route('change.vendor.status') }}">
                                @csrf

                                <input type="hidden" name="id" value="{{ $checkVendorDetails->id }}">

                                <!-- Display different form fields based on vendor status -->
                                @if ($checkVendorDetails->status == 'inactive')
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">FirstName</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="firstname" value="{{ $checkVendorDetails->firstname }}" />
                                        </div>
                                    </div>
                                    <!-- end row -->

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">LastName</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="lastname" value="{{ $checkVendorDetails->lastname }}" />
                                        </div>
                                    </div>
                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-danger px-4" value="Activate Vendor"/>
                                        </div>
                                    </div>
                                {{-- Else Display Active Vendors--}}
                                @else
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">FirstName</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="firstname" value="{{ $checkVendorDetails->firstname }}" />
                                        </div>
                                    </div>
                                    <!-- end row -->

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">LastName</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="lastname" value="{{ $checkVendorDetails->lastname }}" />
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="submit" class="btn btn-danger px-4" value="Deactivate Vendor"/>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            </form>
                            {{-- Form ends here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
{{-- End Section --}}

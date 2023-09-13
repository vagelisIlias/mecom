@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<!-- Image Reload JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Inactive Vendor Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Inactive Vendor Details</li>
                </ol>
            </nav>
        </div>
        {{-- <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div> --}}
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
                                        <img id="showImage" class="rounded-circle avatar-lg" src="{{ (!empty($inactiveVendorDetails->photo)) ? 
                                        url('upload/vendor_profile_image/'. $inactiveVendorDetails->photo) : url('upload/no_image.jpg') }}" 
                                        alt="Card image cap" style="width: 200px; height: 200px; border: 5px solid rgba(138, 60, 221, 0.729);">
                                    </div>
                                    <div class="col-sm-12">
                                        <label style="margin-top: 20px; font-size: 20px; color: black; font-weight: 500">
                                            Vendor Shop Name: {{ $inactiveVendorDetails->vendor_shop_name }}
                                        </label>
                                    </div>  
                                <div class="mt-3">
                                    <p class="text-secondary mb-1">{{ $inactiveVendorDetails->job_title }}</p>
                                    <p class="text-muted font-size-sm">Email: {{ $inactiveVendorDetails->email }}</p>
                                    {{-- <button class="btn btn-primary">Follow</button>
                                    <button class="btn btn-outline-primary">Message</button> --}}
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
                            <form method="post" action="{{ route('approve.inactive.vendor') }}">
                                @csrf
                                
                            <input type="hidden" name="id" value="{{ $inactiveVendorDetails->id }}"> 

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">FirstName</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="firstname" value="{{ $inactiveVendorDetails->firstname }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Lastname</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="lastname" value="{{ $inactiveVendorDetails->lastname }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Username</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="username" value="{{ $inactiveVendorDetails->username }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="email" value="{{ $inactiveVendorDetails->email }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="phone" value="{{ $inactiveVendorDetails->phone }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="address" value="{{ $inactiveVendorDetails->address }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Postcode</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="postcode" value="{{ $inactiveVendorDetails->postcode }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Role</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="role" value="{{ $inactiveVendorDetails->role }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Shop Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="email" value="{{ $inactiveVendorDetails->vendor_shop_name }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor Join Date</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="email" value="{{ $inactiveVendorDetails->vendor_join }}" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Vendor info</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <textarea class="form-control" name="vendor_join">{{ $inactiveVendorDetails->vendor_short_info }}</textarea>
                                </div>
                            </div>
                            <!-- end row -->
                    
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-danger px-4" value="Active Vendor"/>
                                </div>
                            </div>
                        </div>
                    </form>
                {{-- Form ends here --}}
                </div>
                
                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="d-flex align-items-center mb-3">Project Status</h5>
                                    <p>Web Design</p>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p>Website Markup</p>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p>One Page</p>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p>Mobile Template</p>
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p>Backend API</p>
                                    <div class="progress" style="height: 5px">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>


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

@endsection
{{-- End Section --}}
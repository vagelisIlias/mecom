@extends('vendor.vendor_dashboard')
<!-- Start Section -->
@section('vendor')

<div class="page-content"> 
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <a href="{{ route('vendor.dashboard') }}" class="breadcrumb-title pe-3">Dashboard</a>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--End Breadcrumb -->
    <div class="container">
        <div class="main-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                        <!-- Form Start Here -->
                        <form class="row g-3" method="POST" action="{{ route('vendor.update.password') }}" 
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <!-- Old Password -->
                            <div class="form-group col-md-6">
                                <label class="form-label">Old Password</label>
                                <div class="input-group">
                                    <input type="password" name="old_password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                    >
                                </div>
                                    @error('old_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <!-- End Old Password -->
                            
                            <!-- New Password -->
                            <div class="form-group col-md-6">
                                <label class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                    >         
                                </div>
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>
                            <!-- End New Password -->

                            <!-- New Confirm Password -->
                            <div class="form-group col-md-12">
                                <label class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation"
                                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                    >
                                </div>
                                @error('new_password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- End Confirm Password -->
                        
                            <!-- Update Password Button -->
                            <div class="col-12">
                                <button type="submit" 
                                        id="submit-button" 
                                        class="submit-button" 
                                        >
                                        Update Password
                                </button>
                            </div>
                            <!-- End Update Password Button -->
                        </form>
                       <!-- End Form Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<!-- End Section -->

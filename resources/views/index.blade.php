@extends('dashboard')
@section('user')

<!-- Image Reload JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

{{-- This is the user dashboard index page --}}
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> My Account
        </div>
    </div>
</div>
<div class="page-content pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="row">
                    <div class="col-md-3">
                        <div class="dashboard-menu">
                            <ul class="nav flex-column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="change-password-tab" data-bs-toggle="tab" href="#change-password" role="tab" aria-controls="change-password" aria-selected="true"><i class="fi-rs-key mr-10"></i>Change Password</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.logout')}}"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content account dashboard-content pl-50">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Hello {{ Auth::user()->firstname }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>,<br />
                                            manage your <a href="#">shipping and billing addresses</a> and <a href="#">edit your password and account details.</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Your Orders</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Order</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>#1357</td>
                                                        <td>March 45, 2020</td>
                                                        <td>Processing</td>
                                                        <td>$125.00 for 2 item</td>
                                                        <td><a href="#" class="btn-small d-block">View</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>#2468</td>
                                                        <td>June 29, 2020</td>
                                                        <td>Completed</td>
                                                        <td>$364.00 for 5 item</td>
                                                        <td><a href="#" class="btn-small d-block">View</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>#2366</td>
                                                        <td>August 02, 2020</td>
                                                        <td>Completed</td>
                                                        <td>$280.00 for 3 item</td>
                                                        <td><a href="#" class="btn-small d-block">View</a></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Orders tracking</h3>
                                    </div>
                                    <div class="card-body contact-from-area">
                                        <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <form class="contact-form-style mt-30 mb-50" action="#" method="post">
                                                    <div class="input-style mb-20">
                                                        <label>Order ID</label>
                                                        <input name="order-id" placeholder="Found in your order confirmation email" type="text" />
                                                    </div>
                                                    <div class="input-style mb-20">
                                                        <label>Billing email</label>
                                                        <input name="billing-email" placeholder="Email you used during checkout" type="email" />
                                                    </div>
                                                    <button class="submit submit-auto-width" type="submit">Track</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card mb-3 mb-lg-0">
                                            <div class="card-header">
                                                <h3 class="mb-0">Billing Address</h3>
                                            </div>
                                            <div class="card-body">
                                                <address>
                                                    3522 Interstate<br />
                                                    75 Business Spur,<br />
                                                    Sault Ste. <br />Marie, MI 49783
                                                </address>
                                                <p>New York</p>
                                                <a href="#" class="btn-small">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Shipping Address</h5>
                                            </div>
                                            <div class="card-body">
                                                <address>
                                                    4299 Express Lane<br />
                                                    Sarasota, <br />FL 34249 USA <br />Phone: 1.941.227.4444
                                                </address>
                                                <p>Sarasota</p>
                                                <a href="#" class="btn-small">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Account Details --}}
                            <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Account Details</h5>
                                    </div>
                                    <div class="card-body">
                                        {{-- Forms Starts Here --}}
                                        <form method="POST" action="{{ route('user.profile.update', ['user' => $user]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <div class="row">
                                                
                                                <div class="form-group col-md-6">
                                                    <label>First Name <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="firstname" type="text" value="{{ $user->firstname }}"/>
                                                </div>
                                                <!-- end row -->

                                                <div class="form-group col-md-6">
                                                    <label>Last Name <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="lastname" value="{{ $user->lastname }}"/>
                                                </div>
                                                <!-- end row -->

                                                <div class="form-group col-md-12">
                                                    <label>User Name <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="username" type="text" value="{{ $user->username }}"/>
                                                </div>
                                                <!-- end row -->

                                                <div class="form-group col-md-12">
                                                    <label>Email Address <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="email" type="email" value="{{ $user->email }}"/>
                                                </div>
                                                <!-- end row -->

                                                <div class="form-group col-md-12">
                                                    <label>Cell Phone <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="phone" type="text" value="{{ $user->phone }}"/>
                                                </div>
                                                <!-- end row -->

                                                <div class="form-group col-md-12">
                                                    <label>Address <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="address" type="text" value="{{ $user->address }}"/>
                                                </div>
                                                <!-- end row -->

                                                <div class="form-group col-md-12">
                                                    <label>Postcode <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="postcode" type="text" value="{{ $user->postcode }}"/>
                                                </div>
                                                <!-- end row -->

                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    {{-- End Form Here --}}
                                    </div>
                                </div>
                            </div>
                            {{-- Change Password --}}
                            <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        {{-- Forms Starts Here --}}
                                        <form method="POST" action="{{ route('user.password.update') }}">
                                            @csrf
                                            @method('PATCH')

                                            <div class="row">
                                                <div class="form-group col-md-8">
                                                    <label>Old Password <span class="required">*</span></label>
                                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password"/>
                                                    @error('old_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <!-- end row -->
                                                
                                                <div class="form-group col-md-8">
                                                    <label>New Password <span class="required">*</span></label>
                                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password"/>
                                                    @error('new_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <!-- end row -->
                                                
                                                <div class="form-group col-md-8">
                                                    <label>Confirm Password <span class="required">*</span></label>
                                                    <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation"/>
                                                    @error('new_password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <!-- end row -->
                                            </div>
                                            <!-- end row -->
                                            </div>
                                            <!-- end row -->
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Update Password</button>
                                            </div>
                                            </div>
                                        </form>
                                    {{-- End Form Here --}}
                                    </div>
                                </div>
                            </div>
                            {{-- End Change Password --}}
                        </div>
                    </div>
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
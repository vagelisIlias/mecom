@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Vendor Status</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendor Status Details</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.vendor') }}" class="btn btn" style="background-color: rgb(202, 18, 177); color: white;">Add Vendor</a>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Vendor Shop Name</th>
                            <th>Vendor Username</th>
                            <th>Vendor Email</th>
                            <th>Join Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- All Vendor Users --}}
                        @foreach ($allVendorStatus as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->vendor_shop_name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->vendor_join)->format('d-m-Y H:i:s') }}</td>
                            <td>
                                @if($item->status == 'inactive')
                                    <span style="font-size: 14px; background-color: #ea5252; border-radius: 50px; color: white; display: inline-block; padding: 5px 12px;">
                                        {{ $item->status }}
                                    </span>
                                @else
                                    <span style="font-size: 14px; background-color: #7A9D54; border-radius: 50px; color: white; display: inline-block; padding: 5px 12px;">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('change.vendor.status', $item->id) }}"  
                                    style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative; margin-right: 5px;">
                                    @if ($item->status == 'active')
                                        <i class="fa-regular fa-thumbs-up" style="color: #7A9D54;" title="Inactive Product Status"></i>
                                    @else
                                        <i class="fa-regular fa-thumbs-down" style="color: #ea5252;" title="Active Product Status"></i>
                                    @endif
                                </a>
                                <a href="{{ route('edit.vendor.details', $item->id) }}"
                                    style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative; margin-right: 5px;" title="Edit Vendor">
                                    <i class="fa-solid fa-pen-to-square" style="color: #4D4C7D"></i>
                                </a>
                                <a href="{{ route('delete.vendor.details', $item->id) }}" id="delete" 
                                    style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative;" title="Delete Vendor">
                                    <i class="fa-solid fa-trash" style="color: #db5a6b"></i>
                                </a>
                            </td>
                            
                        </tr>
                        @endforeach
                        {{-- End ForEach Loop --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Vendor Shop Name</th>
                            <th>Vendor Username</th>
                            <th>Vendor Email</th>
                            <th>Join Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
{{-- End Section --}}






@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">All Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Active Product: 
                        <span class="badge rounded-pill bg-success"> {{ $allProduct->where('product_status', 'active')->count() }} </span>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Inactive Product: 
                        <span class="badge rounded-pill bg-danger"> {{ $allProduct->where('product_status', 'inactive')->count() }} </span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.product') }}" class="btn btn" style="background-color: rgb(202, 18, 177); color: white;">Add Product</a>
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
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product QTY</th>
                            <th>Product Discunt</th>
                            <th>Product Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allProduct as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td><img src="{{ asset($item->product_thambnail) }}" style="width: 60px; height: 50px;"></td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->product_price }}</td>
                                <td>{{ $item->product_qty }}</td>
                                <td>
                                    <div style="font-size: 14px; border-radius: 50px; color: whitesmoke; display: inline-block; padding: 3px 10px;
                                        background-color: {{ ($item->product_discount == '') ? 'grey' : 'green' }};">
                                        {{ ($item->product_discount !== '') ? round(($item->product_discount / $item->product_price) * 100) . '%' : 'No Discount' }}
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size: 14px; border-radius: 50px; color: white; display: inline-block; padding: 5px 12px;
                                        background-color: {{ $item->product_status == 'active' ? 'green' : 'rgb(185, 21, 24)' }}">
                                        {{ $item->product_status }}
                                    </span>
                                </td>  
                                <td> 
                                    <a href="{{ route('edit.subcategory', $item->id) }}" 
                                        style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative; margin-right: 5px;" title="Product Details">
                                        <i class="fa-solid fa-eye" style="color: #1267a4;"></i>
                                    </a>
                                    <a href="{{ route('edit.product', $item->id) }}" 
                                        style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative; margin-right: 5px;" title="Edit Product">
                                        <i class="fa-solid fa-pen-to-square" style="color: #800fd7;"></i>
                                    </a>
                                    <a href="{{ route('delete.subcategory', $item->id) }}" id="delete" 
                                        style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative;" title="Delete Product">
                                        <i class="fa-solid fa-trash"  style="color: #ca4983;" ></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Product QTY</th>
                            <th>Product Discunt</th>
                            <th>Product Status</th>
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
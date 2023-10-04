@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">All SubCategory</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All SubCategory</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.subcategory') }}" class="btn btn-primary">Add SubCategory</a>
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
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allSubCategory as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item->category_id }}</td>
                                <td>{{ $item->category->category_name }}</td>
                                <td>{{ $item->sub_category_name }}</td>
                                <td>
                                    <a href="{{ route('edit.subcategory', $item->id) }}" 
                                        style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative; margin-right: 5px;" title="Edit Subcategory">
                                        <i class="fa-solid fa-pen-to-square" style="color: #800fd7;"></i>
                                    </a>
                                    <a href="{{ route('delete.subcategory', $item->id) }}" id="delete" 
                                        style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative;" title="Delete Subcategory">
                                        <i class="fa-solid fa-trash"  style="color: #ca4983;" ></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
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
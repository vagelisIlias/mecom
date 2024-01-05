@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">All Banner</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Banner</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.banner') }}" class="btn" style="background-color: rgb(202, 18, 177); color: white;">Add Banner</a>
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
                            <th>Banner Title</th>
                            <th>Banner Url</th>
                            <th>Banner Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allBanner as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item->banner_title }}</td>
                                <td>{{ $item->banner_url }}</td>
                                <td><img src="{{ asset($item->banner_image) }}" style="width: 60px; height: 50px;"></td>
                                <td>
                                    <a href="{{ route('edit.banner', $item->id) }}"
                                        style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative; margin-right: 5px;" title="Edit Category">
                                        <i class="fa-solid fa-pen-to-square" style="color: #4D4C7D"></i>
                                    </a>    
                                    <a href="{{ route('delete.banner', $item->id) }}" id="delete" 
                                        style="font-size: 30px; display: inline-flex; flex-direction: column; align-items: center; text-decoration: none; position: relative;" title="Delete Category">
                                        <i class="fa-solid fa-trash" style="color: #db5a6b"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Banner Title</th>
                            <th>Banner Url</th>
                            <th>Banner Image</th>
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
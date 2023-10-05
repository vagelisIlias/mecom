@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<!-- Validation min.JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content"> 
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add SubCategory</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add SubCategory</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            {{-- Form starts here --}}
                            <form id="myForm" method="post" action="{{ route('store.subcategory') }}">
                                @csrf
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Category name</h6>
                                </div>
                                <div class="form-group col-sm-9 text-secondary">
                                    <select class="form-select mb-3" name="category_id" id="category_id" aria-label="Default select example">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Sub Category name</h6>
                                </div>
                                <div class="form-group col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="sub_category_name" />
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn px-4" style="background-color: rgb(202, 18, 177); color: white;"value="Add SubCategory"/>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- Form ends here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Validation min.JS --}}
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                category_id: {
                    required : true,
                }, 
                sub_category_name: {
                    required : true,
                }, 
            },
            messages :{
                category_id: {
                    required : 'Please Select a Category',
                },
                sub_category_name: {
                    required : 'Please Enter Sub Category Name',
                },
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                if (element.attr("name") == "category_id") {
                    error.insertAfter("#category_id");
                } else {
                    element.closest('.form-group').append(error);
                }
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
{{-- End Section --}}
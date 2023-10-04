@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<!-- Image Reload JS & Validation min.JS Include jQuery and jQuery Validation -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Page Content -->
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <a href="{{ route('all.product') }}" class="breadcrumb-title pe-3">Edit Product</a>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                </ol>
            </nav>
        </div>
    </div>
<!--end breadcrumb-->

<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title">Edit Product</h5>
          <hr/>
            {{-- Form starts here --}}
            <form id="myForm" method="post" action="{{ route('store.product') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-body mt-4">
                <div class="row">
                <div class="col-lg-8">
                <div class="border border-3 p-4 rounded">

                {{-- Product Name --}}
                <div class="form-group mb-3">
                    <label for="inputProductTtitl" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="inputProductName" value="{{ $product->product_name }}" placeholder="Add product title">
                    <div id="product-exists-message" class="text-warning" style="margin-top: 10px;"> 
                        <!-- Preview The Name Existence here -->
                    </div>
                </div>
                {{-- Short Description --}}
                <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Short Description</label>
                    <textarea name="product_short_description" class="form-control" rows="2" placeholder="Add your short text here...">{{ $product->product_short_description }}</textarea>
                </div>
                {{-- Long Description --}}
                <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Long Description</label>
                    <textarea name="product_long_description" id="mytextarea" placeholder="Add your long text here...">{!! $product->product_long_description !!}</textarea>
                </div>


                {{-- Mutli Images --}}
                {{-- <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Multi Images</label> --}}

                    {{-- Display existing images --}}
                    {{-- @if ($product->images->count() > 0)
                        <div class="existing-images">
                            @foreach ($product->images as $image)
                                <div class="existing-image">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                                    <button class="remove-image" data-image-id="{{ $image->id }}">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    @endif --}}
                    
                    {{-- <input name="multi_image[]" type="file" multiple class="form-control" id="multi-image-input">
                    <small class="text-muted">Note: The images will be automatically resized with a total size of less than 2MB</small>
                </div>
                <div id="image-preview-container">
                    <!-- Preview and remove buttons for uploaded images will be inserted here -->
                </div> --}}
                {{-- Thambnail --}}
                {{-- <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Main Thumbnail</label>
                    <input name="product_thambnail" class="form-control" type="file" id="main-thumbnail-input" onchange="previewMainThumbnail(this)">
                    <div id="main-thumbnail-preview"></div>
                    <small class="text-muted">Note: The image will be automatically resized with a total size of less than 2MB</small>
                </div>
            </div> --}}


        </div>
        <div class="col-lg-4">
            <div class="border border-3 p-4 rounded">
                <div class="row g-3">
                {{--  Product Price --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Price</label>
                    <input name="product_price" type="text" class="form-control" placeholder="Add Product Price" value="{{ $product->product_price }}">
                </div>
                {{-- Product Discount --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Discount</label>
                    <input name="product_discount" type="text" class="form-control" placeholder="Add Product Discount" value="{{ $product->product_discount }}">
                </div>
                {{--  Product Code --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Code</label>
                    <input name="product_code" type="text" class="form-control" placeholder="00.00 £" value="{{ $product->product_code }}">
                </div>
                {{-- Product Quantity --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Quantity</label>
                    <input name="product_qty" type="text" class="form-control" value="{{ $product->product_qty }}">
                </div>
                {{-- Product Brand --}}
                <div class="form-group col-12">
                    <label class="form-label">Product Brand</label>
                        <select name="product_brand_id" id="product_brand_id" class="form-select">
                            <option></option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                </div>
                {{-- Product Category --}}
                <div class="form-group col-12">
                <label class="form-label">Product Category</label>
                    <select name="product_category_id" id="product_category_id" class="form-select">
                        <option></option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                    </select>
                </div>
                {{-- Product Subcategory --}}
                <div class="form-group col-12">
                    <label class="form-label">Product SubCategory</label>
                        <select name="product_subcategory_id" id="product_subcategory_id" class="form-select">
                            <option></option>
                            @foreach($subcategories as $subcat)
                                <option value="{{ $subcat->id }}">{{ $subcat->sub_category_name }}</option>
                            @endforeach
                    </select>
                </div>
                {{-- Select Vendor --}}
                <div class="form-group col-12">
                <label class="form-label">Select Vendor</label>
                    <select name="product_vendor_id" id="product_vendor_id" class="form-select">
                        <option></option>
                            @foreach($activeVendor as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->vendor_shop_name }}</option>
                            @endforeach
                    </select>
                </div>
                {{-- Product Color --}}
                <div class="form-group col-12">
                    <label class="form-label">Product Color</label>
                    <input type="text" name="product_color" id="product_color" class="form-control" 
                        data-role="tagsinput" placeholder="Add Product Color" value="{{ $product->product_color }}">
                </div>
                {{-- Product Size --}}
                <div class="form-group col-12">
                    <label class="form-label">Product Size</label>
                    <input type="text" name="product_size" class="form-control visually-hidden" 
                        data-role="tagsinput" placeholder="Add Product Size" value="{{ $product->product_size }}">
                </div>
                {{-- Product Tags --}}
                <div class="form-group col-12">
                    <label class="form-label">Product Tags</label>
                    <input type="text" name="product_tags" class="form-control visually-hidden" 
                        data-role="tagsinput" placeholder="Add Product Tags" value="{{ $product->product_tags }}">
                </div>
                {{-- Deals --}}
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input name="product_hot_deals" class="form-check-input" type="checkbox" value="hot-deals">
                                <label>Hot Deals</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input name="product_featured" class="form-check-input" type="checkbox" value="featured">
                                <label>Featured</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input name="product_special_offer" class="form-check-input" type="checkbox" value="special-offer">
                                <label>Special Offer</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input name="product_special_deals" class="form-check-input" type="checkbox" value="special-deals">
                                <label>Special Deals</label>
                            </div>
                        </div>
                    </div>
                </div>
                <hr> 
                <div class="col-12">
                    <div class="d-grid">
                        <button type="submit" id="submit-button" class="btn btn-info px-4">Update Product</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div><!--end row-->
    </div><!-- form-body mt-4 -->
        </div><!--end card-body p-4 -->
            </form><!-- end form -->
                </div><!--end card -->
                    </div><!-- Page Content -->

<!-- Select category and subcategory dynamically -->
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="product_category_id"]').on('change', function() {
            var product_category_id = $(this).val() || '';
            $.ajax({
                url: `{{ url('/subcategory/ajax') }}/${product_category_id}`,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    const $subcategorySelect = $('select[name="product_subcategory_id"]').html('');
                    $.each(data, function(key, value) {
                        $subcategorySelect.append(`<option value="${value.id}">${value.sub_category_name}</option>`);
                    });
                },
                error: function(error) {
                    console.error('Error loading subcategories:', error);
                }
            });
        });
    });
</script>


{{-- Validation min.JS, creating validation for inputs --}}
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                product_name: {
                    required: true,
                },
                product_short_description: {
                    required: true,
                },
                product_thambnail: {
                    required: true,
                    accept: "image/jpeg,image/png,image/gif",
                    max: 2048,
                },
                product_price: {
                    required: true,
                },
                product_code: {
                    required: true,
                },
                product_qty: {
                    required: true,
                },
                product_brand_id: {
                    required: true,
                },
                product_category_id: {
                    required: true,
                },
                product_subcategory_id: {
                    required: true,
                }, 
                product_vendor_id: {
                    required: true,
                },
                'multi_image[]': {
                    required: true,
                    accept: "image/jpeg,image/png,image/gif",
                    max: 2048,
                }
            },
            messages: {
                product_name: {
                    required: 'Please Add Product Name',
                },
                product_short_description:{
                    required: 'Please Add Short Description',
                },
                product_thambnail:{
                    required: 'Please Add Thambnail Image',
                },
                product_price: {
                    required: 'Please Add Product Price',
                },
                product_code: {
                    required: 'Please Add Product Code',
                },
                product_qty: {
                    required: 'Please Add Product Quantity',
                },
                product_brand_id: {
                    required: 'Please Select Brand',
                },
                product_category_id: {
                    required: 'Please Select Category',
                },
                product_subcategory_id: {
                    required: 'Please Select Subacategory',
                },
                product_vendor_id: {
                    required: 'Please Select Vendor',
                },
                'multi_image[]': {
                    required: 'Please Add Multi Images',
                    accept: 'Only image files are allowed',
                }         
            },
            errorElement : 'span', 
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
                
            },
            highlight: function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
                console.log('Highlighting:', element.name);
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
                console.log('Unhighlighting:', element.name);
            },

        });
    });
</script>

<!-- Multi-Image Load -->
<script type="text/javascript">
    // Function to handle file input change
    function handleFileInputChange() {
        const input = document.getElementById('multi-image-input');
        const previewContainer = document.getElementById('image-preview-container');
        const files = input.files;

        // Clear existing previews
        previewContainer.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function (e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-image';
                img.width = 120; // Set the width
                img.height = 120; // Set the height

                const removeButton = document.createElement('button');
                removeButton.innerHTML = '<i class="fa-solid fa-delete-left"></i>'; // Use Font Awesome icon HTML
                removeButton.className = 'btn btn-sm remove-image custom-remove-button'; // Add a custom class
                removeButton.addEventListener('click', function () {
                    // Remove the corresponding image preview
                    previewContainer.removeChild(previewDiv);
                    // Clear the file input value for the removed image
                    input.value = '';
                });

                previewDiv.appendChild(img);
                previewDiv.appendChild(removeButton);
                previewContainer.appendChild(previewDiv);
            };

            reader.readAsDataURL(file);
        }
    }

    // Add event listener to the file input
    const multiImageInput = document.getElementById('multi-image-input');
    multiImageInput.addEventListener('change', handleFileInputChange);
</script>

<!-- Thumbnail Load Image -->
<script type="text/javascript">
    // Function to handle main thumbnail file input change
    function previewMainThumbnail(input) {
        const previewContainer = document.getElementById('main-thumbnail-preview');
        const file = input.files[0];

        // Clear existing preview
        previewContainer.innerHTML = '';

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'main-thumbnail-image';
                img.width = 120; // Set the width
                img.height = 120; // Set the height

                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    }
</script>

<!-- Checking if the product name already exists in database -->
<script type="text/javascript">
$(document).ready(() => {
    $('#inputProductName').on('keyup',() =>{
        const productName = $('#inputProductName').val().trim();

        // Send an AJAX request to check if the product name already exists in database
        $.ajax({
            url: '{{ route('check.product.existence') }}',
            method: 'POST',
            data: {
                product_name: productName,
                _token: '{{ csrf_token() }}',
            },
            success: (response) => {
                const message = response.exists ? `Note: This product name already exists from vendor: ${response.vendor_shop_name}` : '';
                // Dispaly a suggestion or message to the user
                $('#product-exists-message').html(message);
            },
            error: (error) => {
                console.error('Error checking product name existence');
            }
        });
    });
});
</script>

@endsection
{{-- End Section --}}

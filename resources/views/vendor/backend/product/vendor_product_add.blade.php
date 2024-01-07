@extends('vendor.vendor_dashboard')
{{-- Start Section --}}
@section('vendor')

<!-- Image Reload JS & Validation min.JS Include jQuery and jQuery Validation -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Page Content -->
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <a href="{{ route('all.vendor.product') }}" class="breadcrumb-title pe-3">All Vendor Product</a>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Vendor Product</li>
                </ol>
            </nav>
        </div>
    </div>
<!--end breadcrumb-->

<div class="card">
    <div class="card-body p-4">
        <h5 class="card-title">Add New Vendor Product</h5>
          <hr/>
            {{-- Form starts here --}}
            <form id="myForm" method="post" action="{{ route('vendor.store.product') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-body mt-4">
                <div class="row">
                <div class="col-lg-8">
                <div class="border border-3 p-4 rounded">

                {{-- Product Name --}}
                <div class="form-group mb-3">
                    <label for="inputProductName" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="inputProductName" placeholder="Add product title">
                    <div id="product-exists-message" class="text-warning" style="margin-top: 10px;"> 
                        <!-- Preview The Name Existence here -->
                    </div>
                </div>
                {{-- Short Description --}}
                <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Short Description</label>
                    <textarea name="product_short_description" class="form-control" rows="2" placeholder="Add your short text here..."></textarea>
                </div>
                {{-- Long Description --}}
                <div class="form-group mb-3">
                    <label for="inputProductDescription" class="form-label">Long Description</label>
                    <textarea name="product_long_description" id="mytextarea" placeholder="Add your long text here..."></textarea>
                </div>
                {{-- Mutli Images --}}
                <div class="form-group mb-3" style="border: 2px dashed #ccc; padding: 40px; text-align: center; position: relative;">
                    <input name="multi_image[]" id="multi_image" class="form-control" type="file" multiple style="display: none;" onchange="previewMultiImage(this)">
                    <label for="multi_image" style="font-size: 18px; font-weight: bold; cursor: pointer;">
                        <i class="fas fa-upload"></i> Click Here to Upload Your Multi Images
                    </label>
                    <div id="multi-image-preview-container" style="display: flex; flex-wrap: wrap; margin-top: 15px;"></div>
                </div>
                {{-- Thumbnail Image --}}
                <div class="form-group mb-3" style="border: 2px dashed #ccc; padding: 40px; text-align: center; position: relative;">
                    <input name="product_thambnail" id="product_thambnail" class="form-control" type="file" style="display: none;" onchange="previewThumbnailImage(this)">
                    <label for="product_thambnail" style="font-size: 18px; font-weight: bold; cursor: pointer;">
                        <i class="fas fa-upload"></i> Click Here to Upload Your Thambnail Image | Please Pick One Image
                    </label>
                    <div id="image-remove-button" style="margin-top: 15px;">
                        <img id="thumbnail-preview" src="" alt="Thumbnail Preview" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="border border-3 p-4 rounded">
                <div class="row g-3">
                {{--  Product Price --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Price</label>
                    <input name="product_price" type="text" class="form-control" placeholder="Add Product Price">
                </div>
                {{-- Product Discount --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Discount</label>
                    <input name="product_discount" type="text" class="form-control" placeholder="Add Product Discount">
                </div>
                {{--  Product Code --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Code</label>
                    <input name="product_code" type="text" class="form-control" placeholder="Add Product Code">
                </div>
                {{-- Product Quantity --}}
                <div class="form-group col-md-6">
                    <label class="form-label">Product Quantity</label>
                    <input name="product_qty" type="text" class="form-control" placeholder="Add Product Quantity">
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
                    </select>
                </div>
                {{-- Product Color --}}
                <div class="form-group col-12">
                    <label class="form-label">Product Color</label>
                    <input type="text" name="product_color" id="product_color" class="form-control" 
                        data-role="tagsinput" placeholder="Add Product Color">
                </div>
                {{-- Product Size --}}
                <div class="form-group col-12">
                    <label class="form-label">Product Size</label>
                    <input type="text" name="product_size" class="form-control visually-hidden" 
                        data-role="tagsinput" placeholder="Add Product Size">
                </div>
                {{-- Product Tags --}}
                <div class="form-group col-12">
                    <label class="form-label">Product Tags</label>
                    <input type="text" name="product_tags" class="form-control visually-hidden" 
                        data-role="tagsinput" placeholder="Add Product Tags">
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
                        <button type="submit" id="submit-button" class="submit-button">Add Product</button>
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

<!-- Mutli Image -->
<script type="text/javascript">
    function previewMultiImage(input) {
        var imageContainer = document.getElementById("multi-image-preview-container");

        for (var i = 0; i < input.files.length; i++) {
            var file = input.files[i];

            if (file) {
                var reader = new FileReader();

                reader.onload = (function (file) {
                    return function (e) {
                        var preview = document.createElement("img");
                        preview.src = e.target.result;
                        preview.style.width = "120px";
                        preview.style.height = "120px";
                        preview.style.borderRadius = "15px";
                   
                        var removeButton = document.createElement("button");
                        removeButton.innerHTML = '<i class="fa-solid fa-circle-xmark" style="color: #d51a1a; cursor: pointer; position: relative; bottom: 60px; right: 30px; font-size: 25px; z-index: 1;"></i>';
                        removeButton.style.backgroundColor = "transparent";
                        removeButton.style.border = "none"; 
                        removeButton.style.outline = "none"; 
                        removeButton.style.cursor = "pointer";
                        
                        var marginBetweenImages = "10px";
                        preview.style.marginRight = marginBetweenImages;
                        preview.style.marginBottom = marginBetweenImages;

                        removeButton.addEventListener("click", function () {
                            // Remove the image and the remove button
                            imageContainer.removeChild(preview);
                            imageContainer.removeChild(removeButton);
                        });

                        imageContainer.appendChild(preview);
                        imageContainer.appendChild(removeButton);
                    };
                })(file);
                reader.readAsDataURL(file);
            }
        }
        // Trigger a SweetAlert message when files are successfully uploaded
        Swal.fire({
            title: 'Success!',
            text: 'Images successfully loaded',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>

<!-- Thumbnail Image Load -->
<script type="text/javascript">
    function previewThumbnailImage(input) {
        var preview = document.getElementById("thumbnail-preview");
        var file = input.files[0];
        
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block"; 
                preview.style.width = "120px"; 
                preview.style.height = "120px"; 
                preview.style.borderRadius = "15px"; 
    
                // Create new Elements
                var removeButton = document.createElement("div");
                // removeButton.innerHTML = '<i class="fa-solid fa-circle-xmark" style="color: #d51a1a; cursor: pointer;  position: absolute; bottom: 140px; left: 140px; font-size: 25px; z-index: 1;"></i>';
    
                // Append the remove button to the container that holds the image
                var imageContainer = document.getElementById("image-remove-button");
                imageContainer.appendChild(removeButton);
    
                // Add an event listener to the remove button
                removeButton.addEventListener("click", function() {
                    // Remove the image
                    preview.src = "";
                    preview.style.display = "none";
    
                    // Remove the remove button
                    imageContainer.removeChild(removeButton);
                });
                // Trigger a SweetAlert message when files are successfully uploaded
                Swal.fire({
                    title: 'Success!',
                    text: 'Image successfully loaded',
                    icon: 'success',
                    timer: 2000, 
                    showConfirmButton: false
                });
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    }
</script>
    
<!-- Select Category and Subcategory Dynamically -->
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="product_category_id"]').on('change', function() {
            var product_category_id = $(this).val() || '';
            $.ajax({
                url: `{{ url('vendor/subcategory/ajax') }}/${product_category_id}`,
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
            },
            messages: {
                product_name: {
                    required: 'Please Add Product Name',
                },
                product_short_description:{
                    required: 'Please Add Short Description',
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
                product_thambnail: {
                    required: 'Please Add Image',
                },      
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

<!-- Checking if the product name already exists in database -->
<script type="text/javascript">
$(document).ready(() => {
    $('#inputProductName').on('keyup',() =>{
        const productName = $('#inputProductName').val().trim();

        // Send an AJAX request to check if the product name already exists in database
        $.ajax({
            url: '{{ route('check.vendor.product.existence') }}',
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

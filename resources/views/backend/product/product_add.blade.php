@extends('admin.admin_dashboard')
{{-- Start Section --}}
@section('admin')

<!-- Image Reload JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Page Content -->
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add New Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
                </ol>
            </nav>
        </div>
    </div>
<!--end breadcrumb-->

  <div class="card">
      <div class="card-body p-4">
          <h5 class="card-title">Add New Product</h5>
          <hr/>
           <div class="form-body mt-4">
            <div class="row">
               <div class="col-lg-8">
               <div class="border border-3 p-4 rounded">

                {{-- Product Name --}}
                <div class="mb-3">
                    <label for="inputProductTitle" class="form-label">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="inputProductTitle" placeholder="Enter product title">
                  </div>
                  {{-- Short Description --}}
                  <div class="mb-3">
                    <label for="inputProductDescription" class="form-label">Short Description</label>
                    <textarea name="product_short_desription" class="form-control" rows="2" placeholder="Add your short text..."></textarea>
                  </div>
                  {{-- Long Description --}}
                  <div class="mb-3">
                    <label for="inputProductDescription" class="form-label">Long Description</label>
                        <textarea id="mytextarea" name="product_long_desription" placeholder="Add your long text..."></textarea>
                  </div>
                  {{-- Mutli Images --}}
                  <div class="mb-3">
                    <label for="inputProductDescription" class="form-label">Multi Images</label>
                        <input name="multi_image[]" id="image-uploadify" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
                  </div>
                  {{-- Thambnail --}}
                  <div class="mb-3">
                    <label for="inputProductDescription" class="form-label">Main Thambnail</label>
                        <input name="product_thambnail" class="form-control" type="file" id="formFile" onChange = "mainThanmUrl(this)">
                        <img src="" id="mainThumbnail" alt="">
                  </div>
                </div>
               </div>
               <div class="col-lg-4">
                <div class="border border-3 p-4 rounded">
                  <div class="row g-3">
                    {{--  Product Price --}}
                    <div class="col-md-6">
                        <label for="inputPrice" class="form-label">Product Price</label>
                        <input name="product_price" type="text" class="form-control" id="inputPrice" placeholder="00.00">
                      </div>
                      {{-- Product Discount --}}
                      <div class="col-md-6">
                        <label for="inputCompareatprice" class="form-label">Product Discount</label>
                        <input name="product_discount" type="text" class="form-control" id="inputCompareatprice" placeholder="00.00">
                      </div>
                      {{--  Product Code --}}
                      <div class="col-md-6">
                        <label for="inputCostPerPrice" class="form-label">Product Code</label>
                        <input name="product_code" type="text" class="form-control" id="inputCostPerPrice" placeholder="00.00">
                      </div>
                      {{-- Product Quantity --}}
                      <div class="col-md-6">
                        <label for="inputStarPoints" class="form-label">Product Quantity</label>
                        <input name="product_qty" type="text" class="form-control" id="inputStarPoints" placeholder="00.00">
                      </div>
                      {{-- Product Brand --}}
                      <div class="col-12">
                        <label for="inputProductType" class="form-label">Product Brand</label>
                        <select name="brand_id" class="form-select" id="inputProductType">
                            <option>Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                          </select>
                      </div>
                      {{-- Product Category --}}
                      <div class="col-12">
                        <label for="inputProductType" class="form-label">Product Category</label>
                        <select name="category_id" class="form-select" id="inputProductType">
                            <option>Select Category</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                          </select>
                      </div>
                      {{-- Product Subcategory --}}
                      <div class="col-12">
                        <label for="inputProductType" class="form-label">Product SubCategory</label>
                        <select name="subcategory_id" class="form-select" id="inputProductType">
                            <option>Select SubCategory</option>
                            @foreach($subcategories as $subcat)
                                <option value="{{ $subcat->id }}">{{ $subcat->sub_category_name }}</option>
                            @endforeach
                          </select>
                      </div>
                      {{-- Select Vendor --}}
                      <div class="col-12">
                        <label for="inputProductType" class="form-label">Select Vendor</label>
                        <select name="vendor_id" class="form-select" id="inputProductType">
                            <option>Select Vendor</option>
                            @foreach($activeVendor as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->vendor_shop_name }}</option>
                            @endforeach
                          </select>
                      </div>
                      {{-- Product Color --}}
                      <div class="col-12">
                        <label for="inputProductTitle" class="form-label">Product Color</label>
                        <input type="text" name="product_color" class="form-control visually-hidden" 
                            data-role="tagsinput" id="inputProductTags" placeholder="Enter Product Color" value="Red,Blue,Green">
                      </div>
                      {{-- Product Size --}}
                      <div class="col-12">
                        <label for="inputProductTitle" class="form-label">Product Size</label>
                        <input type="text" name="product_size" class="form-control visually-hidden" 
                            data-role="tagsinput" id="inputProductTags" placeholder="Enter Product Size" value="Small,Medium,Large">
                      </div>
                      {{-- Product Tags --}}
                      <div class="col-12">
                        <label for="inputProductTitle" class="form-label">Product Tags</label>
                        <input type="text" name="product_tags" class="form-control visually-hidden" 
                            data-role="tagsinput" id="inputProductTags" placeholder="Enter Product Tags">
                      </div>
                      {{-- Deals --}}
                      <div class="col-12">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input name="product_hot_deals" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                                    <label for="form-check-label" for="flexCheckDefault">Hot Deals</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input name="product_featured" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                                    <label for="form-check-label" for="flexCheckDefault">Featured</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input name="product_special_offer" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                                    <label for="form-check-label" for="flexCheckDefault">Special Offer</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input name="product_special_deals" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                                    <label for="form-check-label" for="flexCheckDefault">Special Deals</label>
                                </div>
                            </div>
                        </div>
                      </div>
                      <hr>
                      <div class="col-12">
                          <div class="d-grid">
                             <button type="button" class="btn btn-primary">Add Product</button>
                          </div>
                      </div>
                  </div> 
              </div>
              </div>
           </div><!--end row-->
        </div>
      </div>
  </div>
</div>
<!-- Page Content -->

<!-- Thumbnail Load Image -->
<script type="text/javascript">
    function mainThanmUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
                $('#mainThumbnail').attr('src', e.target.result).width(120).height(120);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
{{-- End Section --}}
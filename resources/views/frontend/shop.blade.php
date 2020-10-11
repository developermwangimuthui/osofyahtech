@extends('layouts.main')
@section('content')
<!-- Start main-content -->
<div class="main-content">

  <!-- Section: inner-header -->
  <section class="inner-header divider parallax layer-overlay overlay-dark-5"
    data-bg-img="/front/images/macrolan/office1.jpeg">
    <div class="container pt-70 pb-20">
      <!-- Section Content -->
      <div class="section-content">
        <div class="row">
          <div class="col-md-12">
            <h2 class="title text-white text-center">Our Shop</h2>

          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="">
    <div class="container">
      <div class="section-content">
        <div class="row">
          <div class="col-sm-12 col-md-9">
            @foreach ($categories as $categoryProducts)
            <h2 class="title text-center">{{$categoryProducts->category}}</h2>
            <div class="row multi-row-clearfix">
              <div class="products owl-carousel-3col">
                @foreach ($categoryProducts->products as $product)

                <div class="item">
                  <a href="{{route('singleproduct',$product->id)}}">
                    <div class="product">
                      <div class="product-thumb">
                        <img class="img-responsive img-fullwidth"
                          src="{{ URL::to('/') }}/Macrolan_Products/{{$product->productphotos->where('type','main_image')->pluck('image_path')->first()}}"
                          alt="{{$product->product}}">                   
                      </div>
                      <div class="product-details text-center">
                        <a href="{{route('singleproduct',$product->id)}}">
                          <h6 class="product-title">{{$product->product}}</h6>
                        </a>
                      </div>
                    </div>
                  </a>
                </div>
                @endforeach
              </div>
            </div>
            @endforeach
          </div>
          <div class="col-sm-12 col-md-3">
            <div class="sidebar sidebar-right mt-sm-30">
              <div class="widget">
                <h5 class="widget-title line-bottom">Search for products</h5>
                <div class="search-form">
                  <form>
                    <div class="input-group">
                      <select class="form-group search-input product_search" name="product"
                        onchange="gotoProduct(this)">
                        <option value="" disabled selected>Macrolan Search for Products here</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
              <div class="widget">
                <h5 class="widget-title line-bottom">Categories</h5>
                <div class="categories">
                  <ul class="list list-border angle-double-right">
                    @foreach ($global_categories as $category)
                    <li><a
                        href="{{route('productCategory',$category->id)}}">{{$category->category}}</a>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="row justify-content-center mt-3">
            {{-- {{ $allProducts->links() }} --}}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- end main-content -->
<script>
  $(document).ready(function() {
  $('.product_search').select2();
   //select2 for product
   $('.product_search').select2({
      placeholder: 'Search Products',
      minimumInputLength: 2,
      ajax: {
        url: "{{route('search-products')}}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            search: params.term 
          };
        },
        processResults: function (response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });

	
  });

  
  function gotoProduct(selectObject){
	
    var product_id = selectObject.value;
    window.location.href = "/shop/product-details/"+product_id;

	}
</script>
@endsection
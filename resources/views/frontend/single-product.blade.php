@extends('layouts.main')
@section('content')
<!-- Start main-content -->
<div class="main-content">

  <!-- Section: inner-header -->
  <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="/front/images/macrolan/office1.jpeg">
    <div class="container pt-70 pb-20">
      <!-- Section Content -->
      @foreach ($single_products as $product)
      <div class="section-content">
        <div class="row">
          <div class="col-md-12">
            <h2 class="title text-white text-center">{{$product->product}}</h2>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section>
    <div class="container">
      <div class="section-content">
        <div class="row">
          <div class="product">
            <div class="col-md-5">
              <div class="product-image">
                <div class="zoom-gallery">
                  <a href="/front/images/products/lg1.jpg" title="Title Here 1"><img
                      src="{{ URL::to('/') }}/Macrolan_Products/{{$product->productphotos->pluck('image_path')->first()}}"
                      alt="{{$product->product}}"></a>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="product-summary">
                <h2 class="product-title">{{$product->product}}</h2>
                <div class="category"><strong>Category: </strong>{{$product->category->category}}</div>
                <div class="short-description">
                  <p><strong>Description: </strong>{{$product->description}}</p>
                </div>                

                {{-- <div class="price"><ins><span class="amount">KES &nbsp;{{number_format($product->price,0)}}</span></ins>
                </div> --}}                
               
                {{-- <div class="cart-form-wrapper mt-30">
                  @if (Auth::check())
                  <a class="single_add_to_cart_button btn btn-theme-colored add_to_cart" id="{{$product->id}}"
                    type="button">Add To Enquiry</a>
                  @else
                  <a class="single_add_to_cart_button btn btn-default btn-theme-colored" data-toggle="modal"     data-target="#registerModal" type="button">Add To Enquiry</a>
                  @endif
                
                </div> --}}
              </div>
            </div>

          </div>
          @endforeach
          <div class="col-md-12">
            <h3 class="line-bottom">Related Products</h3>
            <div class="row multi-row-clearfix">
              <div class="products related">
                @foreach ($related_products as $product)

                <div class="col-sm-6 col-md-3 col-lg-3 mb-sm-30">
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
                </div>

                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

<script>
 
</script>
@endsection
@extends('layouts.main')
@section('content')
<!-- Start main-content -->
<div class="main-content">
  <!-- Section: inner-header -->
  <section class="inner-header divider parallax layer-overlay overlay-dark-5"
    data-bg-img="/front/images/macrolan/office1.jpeg">
    <div class="container pt-90 pb-50">
      <!-- Section Content -->
      <div class="section-content">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title text-white">{{$singleService->service}}</h3>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Blog -->
  <section>
    <div class="container mt-30 mb-30 pt-30 pb-30">
      <div class="row">
        <div class="col-md-8 blog-pull-right">

          <div class="single-service">
            <img
              src="{{ URL::to('/') }}/ServiceImages/{{$singleService->servicephotos->where('type','main_image')->pluck('image_path')->first()}}"
              alt="">
            <h3 class="text-theme-colored">{{$singleService->service}}</h3>
            {!!$singleService->description!!}

          </div>
          {{-- <div class="section-content">
            <h5><span class="text-theme-color-2">Gallery</span></h5>
            <div class="row">
              <!-- Gallery Grid -->
              <div class="owl-carousel-4col" data-nav="true">
                @foreach ($singleService->servicephotos as $photo)

                <div class="item">
                  <div class="work-gallery">
                    <div class="gallery-thumb">
                      <img class="img-fullwidth" alt="" src="{{ URL::to('/') }}/ServiceImages/{{$photo->image_path}}">
                      <div class="gallery-overlay"></div>
                      <div class="gallery-contect">
                        <ul class="styled-icons icon-bordered icon-circled icon-sm">
                          <li><a data-rel="prettyPhoto"
                              href="{{ URL::to('/') }}/ServiceImages/{{$photo->image_path}}"><i
                                class="fa fa-arrows"></i></a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <!-- End Gallery Grid -->
            </div>

          </div> --}}
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="sidebar sidebar-left mt-sm-30 ml-40">
            <div class="widget">
              <h4 class="widget-title line-bottom">Our Services</h4>
              <div class="services-list">
                <ul class="list list-border angle-double-right">
                  @foreach ($services as $service)
                  <a href="{{route('singleService',$service->id)}}">
                    <li class="{{$singleService->id == $service->id  ? 'active text-white' : '' }}">
                      {{$service->service}}</li>
                  </a>
                  @endforeach

                </ul>
              </div>
            </div>
          </div>
        </div>
        @if (!$serviceProducts->isEmpty())
        <div class="col-md-12">
          <h3 class="line-bottom">{{$singleService->service}} PRODUCTS</h3>
          <div class="row multi-row-clearfix">
          <div class="products owl-carousel-3col">
                @foreach ($serviceProducts as $product)

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
        </div>
        @endif
      
      </div>
    </div>
  </section>

</div>
<!-- end main-content -->

<script>

</script>

@endsection
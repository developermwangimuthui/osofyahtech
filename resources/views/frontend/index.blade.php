@extends('layouts.main')
@section('content')
<!-- Start main-content -->
<div class="main-content">
  <!-- Section: home -->
  <section id="home">

    <!-- Slider Revolution Start -->
    <div class="rev_slider_wrapper">
      <div class="rev_slider" data-version="5.0">
        <ul>

          <!-- SLIDE 1 -->
          @foreach ($sliders as $slider)
          <!-- SLIDE 1 -->
          <li data-index="rs-{{$loop->index}}" data-transition="slidingoverlayhorizontal" data-slotamount="default"
            data-easein="default" data-easeout="default" data-masterspeed="default"
            data-thumb="{{ URL::to('/') }}/SliderImages/{{$slider->image_path}}" data-rotate="0"
            data-saveperformance="off" data-title="Slide {{$loop->index}}" data-description="">
            <!-- MAIN IMAGE -->
            <img src="{{ URL::to('/') }}/SliderImages/{{$slider->image_path}}" alt="{{$slider->title}}"
              data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg"
              data-bgparallax="10" data-no-retina>
            <!-- LAYERS -->

            <!-- LAYER NR. 1 -->
            <div
              class="tp-caption tp-resizeme text-uppercase  bg-theme-colored-transparent text-white font-raleway border-left-theme-color-2-6px border-right-theme-color-2-6px pl-30 pr-30"
              id="rs-{{$loop->index}}-layer-1" data-x="['center']" data-hoffset="['0']" data-y="['middle']"
              data-voffset="['-90']" data-fontsize="['28']" data-lineheight="['54']" data-width="none"
              data-height="none" data-whitespace="nowrap" data-transform_idle="o:1;s:500"
              data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
              data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
              data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
              data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on"
              style="z-index: 7; white-space: nowrap; font-weight:600; border-radius: 30px;">{{$slider->title}}
            </div>

            <!-- LAYER NR. 3 -->
            <div class="tp-caption tp-resizeme text-white bg-theme-colored-transparent text-center ml-0 mr-20"
              id="rs-{{$loop->index}}-layer-3" data-x="['center']" data-hoffset="['0']" data-y="['middle']"
              data-voffset="['50']" data-fontsize="['20']" data-lineheight="['28']" data-width="none" data-height="none"
              data-whitespace="nowrap" data-transform_idle="o:1;s:500"
              data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
              data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
              data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
              data-start="1400" data-splitin="none" data-splitout="none" data-responsive_offset="on"
              style="z-index: 5; white-space: nowrap; letter-spacing:0px; font-weight:600; border-radius: 20px; padding:10px">
              {{ \Illuminate\Support\Str::limit($slider->description,80, $end='...')}}
            </div>

            <!-- LAYER NR. 4 -->
            {{-- <div class="tp-caption tp-resizeme" id="rs-{{$loop->index}}-layer-4" data-x="['center']"
            data-hoffset="['0']"
            data-y="['middle']" data-voffset="['115']" data-width="none" data-height="none" data-whitespace="nowrap"
            data-transform_idle="o:1;"
            data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
            data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
            data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;" data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
            data-start="1400" data-splitin="none" data-splitout="none" data-responsive_offset="on"
            style="z-index: 5; white-space: nowrap; letter-spacing:1px;"><a
              class="btn btn-default btn-circled  pl-20 pr-20" href="{{route('about')}}">About Us</a>
      </div> --}}
      </li>
      @endforeach
      </ul>
    </div>
    <!-- end .rev_slider -->
</div>
<!-- end .rev_slider_wrapper -->
<script>
  $(document).ready(function(e) {
          $(".rev_slider").revolution({
            sliderType:"standard",
            sliderLayout: "auto",
            dottedOverlay: "none",
            delay: 5000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                },
              arrows: {
                style:"zeus",
                enable:true,
                hide_onmobile:true,
                hide_under:600,
                hide_onleave:true,
                hide_delay:200,
                hide_delay_mobile:1200,
                tmp:'<div class="tp-title-wrap">    <div class="tp-arr-imgholder"></div> </div>',
                left: {
                  h_align:"left",
                  v_align:"center",
                  h_offset:30,
                  v_offset:0
                },
                right: {
                  h_align:"right",
                  v_align:"center",
                  h_offset:30,
                  v_offset:0
                }
              },
              bullets: {
                enable:true,
                hide_onmobile:true,
                hide_under:600,
                style:"metis",
                hide_onleave:true,
                hide_delay:200,
                hide_delay_mobile:1200,
                direction:"horizontal",
                h_align:"center",
                v_align:"bottom",
                h_offset:0,
                v_offset:30,
                space:5,
                tmp:'<span class="tp-bullet-img-wrap">  <span class="tp-bullet-image"></span></span>'
              }
            },
            responsiveLevels: [1240, 1024, 778],
            visibilityLevels: [1240, 1024, 778],
            gridwidth: [1170, 1024, 778, 480],
            gridheight: [650, 768, 960, 720],
            lazyType: "none",
            parallax: {
                origo: "slidercenter",
                speed: 1000,
                levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 100, 55],
                type: "scroll"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: -1,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "0",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
          });
        });
</script>
<!-- Slider Revolution Ends -->

</section>



<!-- Section: About -->
<section id="about">
  <div class="container pb-sm-40 pb-70">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 col-sm-12 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
          <div class="row mt-20">
            <h2 class="mt-40 line-height-1 text-center"><span class="text-theme-color-1">Our</span> <span
                class="text-theme-color-2"> Services</span></h2>

            <div class="owl-carousel-3col our-services-gallery" data-dots="true">
              @foreach ($services as $service)
              <div class="gallery-item">
                <div class="thumb">
                  <img class="img-fullwidth"
                    src="{{ URL::to('/') }}/ServiceImages/{{$service->servicephotos->where('type','main_image')->pluck('image_path')->first()}}"
                    alt="{{$service->service}}">
                  <div class="overlay-shade"></div>
                  <div class="icons-holder">
                    <div class="icons-holder-inner">
                      <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                        <a data-lightbox="image"
                          href="{{ URL::to('/') }}/ServiceImages/{{$service->servicephotos->where('type','main_image')->pluck('image_path')->first()}}"><i
                            class="fa fa-plus"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="our-services-details">
                  <h4 class="title mb-5 "><a href="#">{{$service->service}}</a></h4>
                  @if ($service->service == 'CORPORATE PRINTING')
                  <p>{{\Illuminate\Support\Str::limit('we understand that different businesses’ needs are unique to their niche and we will work with each individual business basis to design and produce printed materials that meet its specific requirements and budget. We can make new business designs, re-design and do brand development. The final cost of such exercises is often less than what a business would incur to produce these items in-house.',150, $end='...')}}</p>
                  @else
                  <p>{{\Illuminate\Support\Str::limit($service->description,150, $end='...')}}</p>
                  @endif
                  <p>
                    <a href="{{route('singleService',$service->id)}}"
                      class="btn btn-theme-colored btn-flat mt-15 btn-sm" role="button">Read More</a>
                  </p>
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



<!-- Divider: why choose us 1 -->
<section class="divider parallax" data-bg-img="/front/images/macrolan/office1.jpeg" data-parallax-ratio="0.7">
  <div class="container pt-0 pb-0">
    <div class="row">
      <div class="col-md-8 col-md-offset-4">
        <div class="bg-white-transparent-9 pt-70 pb-30 p-50">
          <h2 class="mb-30 mt-0 line-height-1 pl-0"><span class="text-theme-color-1">Why</span> <span
              class="text-theme-color-2"> Choose Us?</span></h2>
          <p class="text-gray">Call us at <span class="text-theme-color-2">0722819877</span> and we'll help you find the
            system solution (ERP) that exactly fits your needs:</p>
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <div class="icon-box p-0 mb-30">
                <a
                  class="icon bg-theme-colored icon-circled icon-border-effect effect-circle icon-sm pull-left sm-pull-none flip">
                  <i class="pe-7s-like2 text-white"></i>
                </a>
                <div class="icon-box-details ml-sm-0">
                  <h5 class="icon-box-title mt-15 text-uppercase letter-space-2 mb-0">WE DESIGN</h5>
                  <p class="text-gray">We will listen carefully and design a solution that meets your needs.​</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="icon-box p-0 mb-30">
                <a
                  class="icon bg-theme-colored icon-circled icon-border-effect effect-circle icon-sm pull-left sm-pull-none flip">
                  <i class="pe-7s-like2 text-white"></i>
                </a>
                <div class="icon-box-details ml-sm-0">
                  <h5 class="icon-box-title mt-15 text-uppercase letter-space-2 mb-0">WE INSTALL
                  </h5>
                  <p class="text-gray">Quick, professional installation and training​.</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="icon-box p-0 mb-30">
                <a
                  class="icon bg-theme-colored icon-circled icon-border-effect effect-circle icon-sm pull-left sm-pull-none flip">
                  <i class="pe-7s-like2 text-white"></i>
                </a>
                <div class="icon-box-details ml-sm-0">
                  <h5 class="icon-box-title mt-15 text-uppercase letter-space-2 mb-0">WE MONITOR</h5>
                  <p class="text-gray">Peace of Mind, knowing that we are watching, even if you're not there.​
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="icon-box p-0 mb-30">
                <a
                  class="icon bg-theme-colored icon-circled icon-border-effect effect-circle icon-sm pull-left sm-pull-none flip">
                  <i class="pe-7s-like2 text-white"></i>
                </a>
                <div class="icon-box-details ml-sm-0">
                  <h5 class="icon-box-title mt-15 text-uppercase letter-space-2 mb-0">WE SUPPORT</h5>
                  <p class="text-gray">As your enterprise needs evolve, we be there. Just give us a call.​​
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Shop  -->
<section id="shop">
  <div class="container pb-30">
    <div class="section-title text-center mb-30">
      <div class="row">
        <div class="col-md-12">
          <h2 class="text-center mb-20">Our<span class="text-theme-color-2"> Products</span></h2>
        </div>
      </div>
    </div>
    <div class="row multi-row-clearfix">
      <div class="col-md-12">
        <div class="products owl-carousel-4col">
          @foreach ($categories as $category)
          <div class="item">
            <a href="{{route('productCategory',$category->id)}}">
              <div class="product">
                <div class="product-thumb">
                  <img src="{{ URL::to('/') }}/CategoryImages/{{$category->image_path}}" alt="{{$category->category}}"
                    class="img-responsive img-fullwidth">                  
                </div>
                <div class="product-details text-center">
                  <a href="{{route('productCategory',$category->id)}}">
                    <h6 class="product-title">{{$category->category}}</h6>
                  </a>
                </div>
              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Divider: Call To Action -->
<section class="bg-theme-color-2">
  <div class="container pt-0 pb-30">
    <div class="row">
      <div class="call-to-action pt-30 pb-20">
        <div class="col-md-1 text-right sm-text-center pr-0">
          <i class="pe-7s-cart text-white font-36 mr-10"></i>
        </div>
        <div class="col-md-9 pl-0">
          <h3 class="mt-5 text-white text-uppercase font-weight-600">Browse all time best products in our online store
          </h3>
        </div>
        <div class="col-md-2 text-right flip sm-text-center">
          <a class="btn btn-default btn-lg btn-circled mt-5" href="{{route('shop')}}">Shop Now<i
              class="fa fa-angle-double-right font-16 ml-10"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<!-- end main-content -->

</div>

<script>

</script>
@endsection
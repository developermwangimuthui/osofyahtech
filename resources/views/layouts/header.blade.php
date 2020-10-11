<!-- Header -->
<header id="header" class="header">
  {{-- <div class="header-top bg-lighter sm-text-center">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <div class="widget no-border m-0">
            <ul class="list-inline text-left flip sm-text-center mt-5">
              <li class="text-theme-colored">
                @if (Auth::check())
                {{Auth::user()->name}}, <a class="" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"> {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
                @else
                <a id="regissterBtn">Register/Login</a>
                @endif

              </li>
              <li class="text-theme-colored">|</li>
              <li>
                @if (Auth::check())
                <a class="top-cart-link has-dropdown" href="{{route('cart')}}"><i
                    class="fa fa-list font-18"></i> &nbsp;<span style="display: none" id="product_quantities"></span></a>
                @else
                <a class="top-cart-link has-dropdown" href="#" data-toggle="modal" data-target="#registerModal"><i
                    class="fa fa-list font-18"></i> &nbsp;<span style="display: none" id="product_quantities"
                    class="text-theme-colored"></span></a>
                @endif
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <div class="widget no-border m-0">
            <ul
              class="styled-icons icon-gray icon-circled icon-sm pull-right flip sm-pull-none sm-text-center mt-sm-15">
              <li><a href="https://www.facebook.com/macrolan.kenyaltd"><i class="fa fa-facebook text-theme-colored"></i></a></li>
              <li><a href="https://twitter.com/macrolankenyal1"><i class="fa fa-twitter text-theme-colored"></i></a></li>
              <li><a href="https://www.instagram.com/macrolankenyaltd/"><i class="fa fa-instagram text-theme-colored"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
  <div class="header-nav">
    <div class="header-nav-wrapper navbar-scrolltofixed bg-theme-colored border-bottom-theme-color-2-1px">
      <div class="container">
        <nav id="menuzord-right" class="menuzord blue no-bg"><a
            class="menuzord-brand pull-left flip xs-pull-center mb-15" href="{{route('index')}}"><img
              src="/front/images/macrolan/logo.png" alt=""></a>
          <ul class="menuzord-menu">
            <li class="{{ Route::currentRouteNamed('index') ? 'active' : '' }}"><a href="{{route('index')}}">Home</a>
            </li>
            <li class="{{ Route::currentRouteNamed('about') ? 'active' : '' }}"><a href="{{route('about')}}">About</a>
            </li>
            <li class="{{ Route::currentRouteNamed('singleService') ? 'active' : '' }}"><a href="#">Services</a>
              <ul class="dropdown">
                @foreach ($global_services as $service)
                <li><a href="{{route('singleService',$service->id)}}">{{$service->service}}</a></li>
                @endforeach
              </ul>
            </li>
            <li class="{{ Route::currentRouteNamed('shop') ? 'active' : '' }}"><a href="{{route('shop')}}">Shop</a>
            </li>
            <li class="{{ Route::currentRouteNamed('productCategory') ? 'active' : '' }}"><a href="#">Product
                Categories</a>
              <ul class="dropdown">
                @foreach ($global_categories as $category)
                <li><a href="{{route('productCategory',$category->id)}}">All {{$category->category}}</a></li>
                @endforeach
              </ul>
            </li>
            <li>
            <a href="{{route('enquiry')}}" class="btn btn-colored btn-flat bg-theme-color-2 text-white font-14  mt-0">Enquire Now</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</header>

<script>

var cartTotal = 0;

  $(function () {

  $("#loginform").on("submit", function (e) {
        e.preventDefault(),
        $(".loginoverlay").fadeIn();
            $.ajax({
                url: "{!! URL::to('/login') !!}",
                method: "post",
                data: new FormData(this),
                contentType: !1,
                cache: !1,
                processData: !1,
                dataType: "json",
                success: function (data) {
                  $(".loginoverlay").fadeOut();                 
                    var html = "";
                    if (data.errors) {
                        html =
                            '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" \
                        data-dismiss="alert">&times;</button><div class="alert-icon"><i class="icon-close"></i></div><div class="alert-message">\
                        <span><strong>Errors!</strong></span><br>';
                        for (
                            var count = 0;
                            count < data.errors.length;
                            count++
                        ) {
                            html +=
                                "<span>" +
                                data.errors[count] +
                                "</span><br>";
                        }
                        html += "</div></div>";
                    }
                    if (data.warning) {
                        html =
                            '<div class="alert alert-warning">' +
                            data.warning +
                            "</div>";
                    }
                    if (data.success) {
                        html =
                            '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" \
                        data-dismiss="alert">&times;</button><div class="alert-icon"><i class="icon-check"></i></div><div class="alert-message">\
                        <span><strong>Success!</strong> ' +
                            data.success +
                            "</span></div></div>";

                            $("#resultslogin").html(html);
                            Lobibox.notify("success", {
                                  pauseDelayOnHover: true,
                                  continueDelayOnInactiveTab: false,
                                  position: "top right",
                                  icon: "fa fa-times-circle",
                                  msg: data.success,
                              });
                              setTimeout(function () {
                                  $("#resultslogin").html("");
                                $("#registerModal").hide();
                                window.location.href = "/";
                              }, 2000);
                    }
                          
                    $("#resultslogin").html(html);
                              setTimeout(function () {
                                  $("#resultslogin").html("");
                              }, 2000);
                        
                },
            });
        });



   $("#registerform").on("submit", function (e) {
      e.preventDefault(),
        $(".registeroverlay").fadeIn();
          $.ajax({
              url: "{!! URL::to('/register') !!}",
              method: "post",
              data: new FormData(this),
              contentType: !1,
              cache: !1,
              processData: !1,
              dataType: "json",
              success: function (data) {
                $(".registeroverlay").fadeOut();
                        var html = "";
                  if (data.errors) {
                      html =
                          '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" \
                      data-dismiss="alert">&times;</button><div class="alert-icon"><i class="icon-close"></i></div><div class="alert-message">\
                      <span><strong>Errors!</strong></span><br>';
                      for (
                          var count = 0;
                          count < data.errors.length;
                          count++
                      ) {
                          html +=
                              "<span>" +
                              data.errors[count] +
                              "</span><br>";
                      }
                      html += "</div></div>";
                  }
                  if (data.warning) {
                      html =
                          '<div class="alert alert-warning">' +
                          data.warning +
                          "</div>";
                  }
                  if (data.success) {
                      html =
                          '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" \
                      data-dismiss="alert">&times;</button><div class="alert-icon"><i class="icon-check"></i></div><div class="alert-message">\
                      <span><strong>Success!</strong> ' +
                          data.success +
                          "</span></div></div>";
                          
                          $("#resultsregister").html(html);

                              Lobibox.notify("success", {
                                  pauseDelayOnHover: true,
                                  continueDelayOnInactiveTab: false,
                                  position: "top right",
                                  icon: "fa fa-times-circle",
                                  msg: data.success,
                              });
                            setTimeout(function () {
                                $("#resultsregister").html("");

                          $("#registerModal").hide();
                          window.location.href = "/";
                            }, 2000);
                  }
                        
                  $("#resultsregister").html(html);
                            setTimeout(function () {
                                $("#resultsregister").html("");
                            }, 2000);
                          
                    },
            });
    });

    $('#regissterBtn').click(function(){
      $('.modal-backdrop').remove();
          $('#registerModal').modal('show');
      });



  
  // var product_quantities = "{{ Session::get('product_quantities') }}";
  var product_quantities = "{{ $cartItemCount }}";
  // alert(product_quantities);

  $('#product_quantities').html(product_quantities);

  $('.add_to_cart').on('click', function() {
    var product_id = $(this).attr('id');
    $.ajax({
      url: '/cartItems/update',
      method: 'POST',
      data: {
        product_id: product_id,
        _token: '{{ csrf_token() }}'
      },
      success: function(data) {
        console.log(data.product_quantities);
        $('#product_quantities').empty();
        $('#product_quantities').html(data.product_quantities);
        Lobibox.notify("success", {
              pauseDelayOnHover: true,
              continueDelayOnInactiveTab: false,
              position: "top right",
              icon: "fa fa-times-circle",
              msg: data.message,
          });
      },
      error: function(data) {
        $('#product_quantities').html(data.product_quantities);
        Lobibox.notify("error", {
                      pauseDelayOnHover: true,
                      continueDelayOnInactiveTab: false,
                      position: "top right",
                      icon: "fa fa-times-circle",
                      msg: "An error occured! Please try again!",
                  });
      }
    });
  });


  $(document).on('click', '.deleteme', function() {

      // var cartDeletedItem = $(this).attr('id');
      // var existingTotal = $('.total_amount').attr('id');
      var cartproduct_id = $(this).data('id');
      // var newTotal = existingTotal - cartDeletedItem;

      console.log(cartproduct_id);
      // $('.total_amount').empty();
      // $('.total_amount').append(newTotal.toLocaleString('en-US', {
      //   style: 'currency',
      //   currency: 'KES'
      // }));
      $.ajax({
        url: '/cartItems/delete',
        method: 'POST',
        data: {
          // existingTotal: existingTotal,
          cartproduct_id: cartproduct_id,
          _token: "{{ csrf_token() }}"
        },
        success: function(data) {

          $('#product_quantities').empty();
          $('#product_quantities').html(data.product_quantities);
          $('#cart_table').DataTable().ajax.reload();
          Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.message,
                    });
        },
        error: function(data) {
          Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: "An error occured! Please try again!",
                    });
        }
      });
      });

});
</script>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

  <!-- Meta Tags -->
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="description"
    content="Macrolan is one of the leading solutions providers in the field of information Technology, Business Solutions & Security Solutions. Our vision is to be Africa’s leading provider of cutting-edge IT solutions, delivered with world-class service, providing utmost satisfaction for our valued customers. Our solutions are critical for our customers and that’s why we place great importance in providing reliable, state-of-the-art products. Our team of professionals possesses an exceptional set of talents, motivation, and a determination to excel to provide everything they commit to. The end result is our corporate clients’ absolute confidence in our professionalism and capabilities, which is demonstrated by the sustained and positive development of our collaboration with them, clearly identifying us a customer-centric company." />
  <meta name="keywords" content="Computer,Mobile,Pad,ict" />
  <meta name="author" content="MacroLan" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Page Title -->
  <title>Macrolan Kenya</title>

  <!-- Favicon and Touch Icons -->
  <link href="/front/images/macrolan/Macrolan Logo_New_Rectangle.png" rel="shortcut icon" type="image/png">
  <link href="/front/images/macrolan/Macrolan Logo_New_Rectangle.png" rel="apple-touch-icon">
  <link href="/front/images/macrolan/Macrolan Logo_New_Rectangle.png" rel="apple-touch-icon" sizes="72x72">
  <link href="/front/images/macrolan/Macrolan Logo_New_Rectangle.png" rel="apple-touch-icon" sizes="114x114">
  <link href="/front/images/macrolan/Macrolan Logo_New_Rectangle.png" rel="apple-touch-icon" sizes="144x144">

  <!-- Stylesheet -->
  <link href="/front/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="/front/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
  <link href="/front/css/animate.css" rel="stylesheet" type="text/css">
  <link href="/front/css/css-plugin-collections.css" rel="stylesheet" />
  <!-- CSS | menuzord megamenu skins -->
  <link id="menuzord-menu-skins" href="/front/css/menuzord-skins/menuzord-rounded-boxed.css" rel="stylesheet" />
  <!-- CSS | Main style file -->
  <link href="/front/css/style-main.css" rel="stylesheet" type="text/css">
  <!-- CSS | Preloader Styles -->
  <link href="/front/css/preloader.css" rel="stylesheet" type="text/css">
  <!-- CSS | Custom Margin Padding Collection -->
  <link href="/front/css/custom-bootstrap-margin-padding.css" rel="stylesheet" type="text/css">
  <!-- CSS | Responsive media queries -->
  <link href="/front/css/responsive.css" rel="stylesheet" type="text/css">
  <!-- CSS | Style css. This is the file where you can place your own custom css code. Just uncomment it and use it. -->
  <!-- <link href="/front/css/style.css" rel="stylesheet" type="text/css"> -->

  <!-- Revolution Slider 5.x CSS settings -->
  <link href="/front/js/revolution-slider/css/settings.css" rel="stylesheet" type="text/css" />
  <link href="/front/js/revolution-slider/css/layers.css" rel="stylesheet" type="text/css" />
  <link href="/front/js/revolution-slider/css/navigation.css" rel="stylesheet" type="text/css" />

  <!-- CSS | Theme Color -->
  <link href="/front/css/colors/theme-skin-color-set-1.css" rel="stylesheet" type="text/css">

  <!-- external javascripts -->
  <script src="/front/js/jquery-2.2.4.min.js"></script>
  <script src="/front/js/jquery-ui.min.js"></script>
  <script src="/front/js/bootstrap.min.js"></script>
  <!-- JS | jquery plugin collection for this theme -->
  <script src="/front/js/jquery-plugin-collection.js"></script>
  {{-- select2 --}}
  <script src="/front/js/select2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/front/css/select2.min.css">

  <!-- Revolution Slider 5.x SCRIPTS -->
  <script src="/front/js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
  <script src="/front/js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
{{-- <body class="boxed-layout bg-img-fixed bg-img-cover  pb-40 pt-sm-0" data-bg-img="/front/images/bg/bg2.jpg"> --}}

<link href="/backend/assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet"
  type="text/css">
<link href="/backend/assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet"
  type="text/css">
<!-- notifications css -->
<link rel="stylesheet" href="/backend/assets/plugins/notifications/css/lobibox.min.css" />
<script src="/backend/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
<script async data-id="51575" src="https://cdn.widgetwhats.com/script.min.js"></script>

<body>
  <div id="wrapper" class="clearfix">
    <!-- preloader -->
    {{-- <div id="preloader">
      <div id="spinner">
        <img alt="" src="/front/images/preloaders/5.gif">
      </div>
    </div> --}}

    <!-- Header -->
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')

    <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
    <div class="modal fade  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      id="registerModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <ul id="myTab" class="nav nav-tabs boot-tabs">
            <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
            <li><a href="#register" data-toggle="tab">Register</a></li>
          </ul><br>
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="login">
              <div class="heading-line-bottom">
                <h4 class="heading-title">Login Your Account</h4>
              </div>
              <form method="POST" id="loginform">
                <div id="overlay" style="display:none;" class="loginoverlay">
                  <div class="spinner"></div>
                  <br />
                  Login in...
                </div>
                <center style="margin-top:20px;"><span id="resultslogin"></span> </center>
                @csrf
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Email</label>
                    <input id="email" type="email"
                      class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email"
                      value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Password</label>

                    <input  type="password"
                      class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password"
                      required autocomplete="current-password" placeholder="Password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-default">Sign in</button>
                </div>
              </form>
            </div>
            <div class="tab-pane fade" id="register">
              <div class="heading-line-bottom">
                <h4 class="heading-title">Don't have an Account? Register Now</h4>
              </div>
              <form method="POST" id="registerform">
                <div id="overlay" style="display:none;" class="registeroverlay">
                  <div class="spinner"></div>
                  <br />
                  Registering...
                </div>
                <center style="margin-top:20px;"><span id="resultsregister"></span> </center>
                @csrf
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Name</label>
                    <input id="name" type="text"
                      class="form-control form-control-rounded @error('last_name') is-invalid @enderror" name="name"
                      value="{{ old('name') }}" required autocomplete="name" autofocus placeholder=" Name">

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Email Address</label>
                    <input id="email" type="email"
                      class="form-control form-control-rounded @error('email') is-invalid @enderror" name="email"
                      value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Choose Password</label>
                    <input  type="password"
                      class="form-control form-control-rounded @error('password') is-invalid @enderror" name="password"
                      required autocomplete="new-password" placeholder="Password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Re-enter Password</label>
                    <input id="password-confirm" type="password" class="form-control form-control-rounded"
                      name="password_confirmation" required autocomplete="new-password" placeholder="Retry Password" />
                    <div class="form-control-position">
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-default">Register Now</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

   
  </div>
  <!-- end wrapper -->

  <!-- Footer Scripts -->
  <!-- JS | Custom script for all pages -->
  <script src="/front/js/custom.js"></script>
  <script src="/front/js/addplugin.js"></script>

  <!-- SLIDER REVOLUTION 5.0 EXTENSIONS  
      (Load Extensions only on Local File Systems ! 
       The following part can be removed on Server for On Demand Loading) -->
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.actions.min.js">
  </script>
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.carousel.min.js">
  </script>
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js">
  </script>
  <script type="text/javascript"
    src="/front/js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.migration.min.js">
  </script>
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.navigation.min.js">
  </script>
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.parallax.min.js">
  </script>
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js">
  </script>
  <script type="text/javascript" src="/front/js/revolution-slider/js/extensions/revolution.extension.video.min.js">
  </script>


  <script src="/backend/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  {{-- <script src="/backend/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="/backend/assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="/backend/assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="/backend/assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="/backend/assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="/backend/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="/backend/assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="/backend/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script> --}}

  <!--notification js -->
  <script src="/backend/assets/plugins/notifications/js/lobibox.min.js"></script>
  <script src="/backend/assets/plugins/notifications/js/notifications.min.js"></script>
  <script src="/backend/assets/plugins/notifications/js/notification-custom-script.js"></script>




</body>

</html>
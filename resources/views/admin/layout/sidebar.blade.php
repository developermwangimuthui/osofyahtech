<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
  <div class="brand-logo">
    <a href="{{route('dashboard')}}">
      <img src="/front/images/macrolan/Macrolan Logo_New_Rectangle.png" class="logo-icon" alt="logo icon">
      <h5 class="logo-text">Macrolan</h5>
    </a>
  </div>
  <ul class="sidebar-menu do-nicescrol">
    <li class="sidebar-header">MAIN NAVIGATION</li>
    {{-- @can('view-dashboard') --}}
    <li>
      <a href="{{route('dashboard')}}" class="waves-effect">
        <i class="ti-home"></i> <span>Dashboard</span>
      </a>

    </li>
    <li>
      <a href="{{route('category.index')}}" class="waves-effect">
        <i class="ti-settings"></i>
        <span>Category Management</span>
      </a>

    </li>
    <li>
      <a href="{{route('product.index')}}" class="waves-effect">
        <i class="ti-settings"></i>
        <span>Product Management</span>
      </a>

    </li>
    <li>
      <a href="{{route('service.index')}}" class="waves-effect">
        <i class="icon-settings"></i>
        <span>Service Management</span>
      </a>

    </li>
    {{-- <li>
      <a href="{{route('serviceProduct.index')}}" class="waves-effect">
        <i class="icon-briefcase"></i>
        <span>Service Products</span>
      </a>

    </li> --}}
    <li>
      <a href="{{route('slider.index')}}" class="waves-effect">
        <i class="ti-settings"></i>
        <span>Slider Management</span>
      </a>

    </li>

    {{-- <li>
      <a href="{{route('order.index')}}" class="waves-effect">
        <i class="ti-settings"></i>
        <span>Order Management</span>
      </a>

    </li> --}}
    <li>
      <a href="{{route('enquiry.index')}}" class="waves-effect">
        <i class="ti-settings"></i>
        <span>Enquiries</span>
      </a>

    </li>

    {{-- <li>
      <a href="javaScript:void();" class="waves-effect">
        <i class="ti-user"></i>
        <span>User Management</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="sidebar-submenu">
        <li><a href=""><i class="fa fa-circle-o"></i>User Management</a></li>
        <li><a href=""><i class="fa fa-circle-o"></i>Role Management</a></li>
      </ul>
    </li> --}}



  </ul>

</div>
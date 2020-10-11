@extends('layouts.main')
@section('content')
    <!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="/front/images/bg/bg3.jpg">
    <div class="container pt-70 pb-20">
      <!-- Section Content -->
      <div class="section-content">
        <div class="row">
          <div class="col-md-12">
            <h2 class="title text-white">My orders</h3>
              <ul class="list-inline text-white">
                <li>Home /</li>
                <li><span class="text-gray">orders</span></li>
              </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container">
      <div class="section-content">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered tbl-shopping-cart">
                <thead>
                  <tr>
                    <th>Oder Tracking ID</th>
                    <th>Number Of Items</th>
                    <th>Total Order Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
{{-- {{dd($order)}} --}}
                    <tr class="cart_item">
                        <td class="product-remove">
                            {{$order->id}}
                        </td>
                        <td class="product-remove">
                            {{$order->cart->cartproducts->pluck('quantity')->sum()}}
                        </td>
                        <td class="product-remove">
                            {{$order->amount}}
                        </td>
                        <td class="product-remove">
                         @if ($order->status==2)
                             complete
                         @else
                             pending
                         @endif
                        </td>
                        <td class="product-remove">
                        <a class="btn btn-info" href="{{route('singleOrder',$order->id)}}" ><i class="fa fa-eye"></i></a>
                        </td>
                      </tr>
                    @endforeach

                 


                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end main-content -->
@endsection
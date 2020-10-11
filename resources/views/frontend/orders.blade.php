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
                    <th>Photo</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>    
                   <?php
                   
                   $totalamount= 0;
                   ?>
                    @foreach ($cart_products as $cart_product)
                    <?php

                    $product = App\Product::where('id',$cart_product->product_id)->first();
                    $totalamount += $product->price * $cart_product->quantity;
                    ?>
                    <tr class="cart_item">
                        <td class="product-remove"><img src="{{ URL::to('/') }}/Macrolan_Products/{{$product->productphotos->where('type','main_image')->pluck('image_path')->first()}}"
                            alt="{{$product->product}}" height='70' width='70' style='object-fit:contain;' /></td>
                        <td class="product-name"><a href="#">{{$product->product}}</a></td>
                        <td class="product-name"><a href="#">{{number_format($product->price,2)}}</a></td>
                   
                        <td class="product-name"><a href="#">{{$cart_product->quantity}}</a></td>
                        <td class="product-name"><a href="#">{{number_format($product->price * $cart_product->quantity,2)}}</a></td>
                      </tr>
                    @endforeach

                    <tr>
                        <td colspan="4"></td>
                    <td>{{number_format($totalamount,2)}}</td>
                    </tr>


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

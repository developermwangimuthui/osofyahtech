@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header">
                        <i class="fa fa-table"></i> Order Products
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush ">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
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
                                        <td><img src="{{ URL::to('/') }}/Macrolan_Products/{{$product->productphotos->where('type','main_image')->pluck('image_path')->first()}}"
                                                alt="{{$product->product}}" height='70' width='70'
                                                style='object-fit:contain;' /></td>
                                        <td><a href="#">{{$product->product}}</a></td>
                                        {{-- <td class="product-name"><a href="#">{{number_format($product->price,2)}}</a>
                                        </td> --}}

                                        <td class="product-name"><a href="#">{{$cart_product->quantity}}</a></td>
                                        {{-- <td class="product-name"><a
                                                href="#">{{number_format($product->price * $cart_product->quantity,2)}}</a>
                                        </td> --}}
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->
    </div>
</div>

@endsection
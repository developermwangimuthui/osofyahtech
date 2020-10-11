@extends('layouts.main')
@section('content')

<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="/front/images/macrolan/office1.jpeg">
  <div class="container pt-70 pb-20">
    <!-- Section Content -->
    <div class="section-content">
      <div class="row">
        <div class="col-md-12">
          <h2 class="title text-white">Inquiries</h3>
            
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
            <table class="table table-striped table-bordered tbl-shopping-cart" id="cart_table">
              <thead>
                <tr>
                  <th>Photo</th>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 mt-30">
          <div class="row">
            {{-- <div class="col-md-6">
              <h4>Cart Totals</h4>
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <td>Cart Total</td>
                    <td id="{{$totalamount}}" class="total_amount">KES {{number_format($totalamount,2)}}</td>
                  </tr>
                </tbody>
              </table>
            </div> --}}
            <div class="col-md-12">
              <h4>Fill the form below to submit your inquiries</h4>
              <div class="alert alert-success validation alert-dismissible fade show"
								style="display: none;" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<p class="text-left"></p>
							</div>
            <form class="form" action="{{route('order.place')}}" method="POST">
                @csrf
                <table class="table no-border">
                  <tbody>
                    <tr>
                      <td><select class="form-control" name="country">
                          <option value="">Select Country</option>
                          <option value="Kenya">Kenya</option>
                          <option value="Tanzania">Tanzania</option>
                          <option value="Uganda">Uganda</option>
                          <option value="Rwanda">Rwanda</option>
                        </select></td>
                    </tr>
                    <tr>
                    {{-- <input type="hidden" name="amount" value="{{$totalamount}}"> --}}
                      <td><input type="text" class="form-control" placeholder="City" value="" name="city" required></td>
                    </tr>
                    <tr>
                      <td><input type="text" class="form-control" placeholder="Description" value="" name="description" required></td>
                    </tr>
                    <tr>
                      <td><input type="text" class="form-control" placeholder="Phone" value="" name="phone" required></td>
                    </tr>
                    <tr>
                      @if (Session::get('product_quantities') > 0)
                      <td><button type="submit" class="btn btn-default">Submit Inquiry</button></td>
                      @else
                      <td><button type="button" class="btn btn-default" disabled>Submit Inquiry</button></td>
                      @endif
                     
                    </tr>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end main-content -->


<script>

$(function () {
    var table = $('#cart_table').DataTable({

      processing: true,
      serverSide: true,
      ajax: "{{ route('cart')}}",
      columns: [
        {data: 'image_path',name: 'image_path',render: function(data) {
            return "<img src={{ URL::to('') }}/Macrolan_Products/" + data + " height='70' width='70' style='object-fit:contain;' />";
          }},
        {data: 'product', name: 'product'},
        {data: 'quantity', name: 'quantity'},
        {data: 'action', name: 'action', orderable: false, searchable: false },
      ],

    });



  });





</script>
@endsection

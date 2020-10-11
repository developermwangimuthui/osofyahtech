@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Service Products
                        <a href="#" class="btn btn-info btn-round waves-effect waves-light m-1" data-toggle="modal"
                            data-target="#productmodal">Add Service Product</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="product_table" class="table table-bordered ">
                                <thead>

                                    <th>Name</th>
                                    <th>Service</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Action</th>

                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                    <th>Name</th>
                                    <th>Service</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Action</th>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->
    </div>
</div>



<!-- Modal -->
<div class="modal fade productmodal" id="productmodal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Service Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="overlay" style="display:none;" class="productoverlay">
                    <div class="spinner"></div>
                    <br />
                    Loading...
                </div>
                <span id="form_result"></span>
                <form id="product_add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="title">Service</label>
                            <select name="service_id" id="" class="form-control form-control-rounded" required>
                                <option value="">Select Product Service</option>
                                @foreach ($services as $service)

                                <option value="{{$service->id}}">{{$service->service}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Product</label>
                            <input type="text" class="form-control form-control-rounded" name="product"
                                placeholder="Enter Product Name" required>
                        </div>
                    </div>
                    {{-- <div class="row">
                       
                        <div class="form-group col-md-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control form-control-rounded" id="price"
                                placeholder="Enter Product Price" name="price" required>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="main_image">Description</label>
                            <textarea name="description" id="" cols="30" rows="5"
                                class="form-control form-control-rounded" required></textarea>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="main_image">Main Product Image</label>
                            <input type="file" class="form-control form-control-rounded" id="main_image"
                                placeholder="Enter Service Main Name" name="main_image">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gallery">Additional Images</label>
                            <input type="file" class="form-control form-control-rounded" id="gallery"
                                placeholder="Enter Service Additional Images" name="gallery[]" multiple required>
                        </div>
                    </div>



                    <div class="form-group">
                        <button type="submit" class="btn btn-primary shadow-primary btn-round px-5"><i
                                class="icon-checkbox3"></i> Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Large Size Modal -->

<script>
    var table = $('#product_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('serviceProduct.index')}}",
        columns:[
        {data: 'product', name: 'product'},
        {data: 'service.service', name: 'service.service'},
        {data: 'description', name: 'description'},
        {data: 'price', name: 'price',visible:false},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs:[
            {targets:2, render:function(data){
           var trimmedString = data.substring(0, 50);
             return trimmedString + '...';
            }
        },
        ]

        });




   function productdelete(service_product_id) {
    //    console.log(product_id);
    $.ajax({
           url:'/serviceProduct/destroy/',
           method:'delete',
           data:{
            service_product_id:service_product_id,
                 _token: "{{ csrf_token() }}",
           },
           success:function(data){
               if (data.errors) {
                    Lobibox.notify("error", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.errors,
                    });
                }
                if (data.success) {
                    Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-check-circle", //path to image
                        msg: data.success,
                     });
                     $('#product_table').DataTable().ajax.reload();
                }
               
            }

       });
    }



    $("#product_add").on("submit", function (event) {
        event.preventDefault();
         $(".productoverlay").fadeIn();
        $.ajax({
            url: "{{route('serviceProduct.store')}}",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",

            success:function(data){
                $(".productoverlay").fadeOut();
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
                        Lobibox.notify("success", {
                            pauseDelayOnHover: true,
                            continueDelayOnInactiveTab: false,
                            position: "top right",
                            icon: "fa fa-times-circle",
                            msg: data.success,
                         });
                     $('#product_add')[0].reset();
                    $('#productmodal').modal('hide');
                    $('#product_table').DataTable().ajax.reload();
                }
                     $("#form_result").html(html);
                    setTimeout(function () {
                        $("#form_result").html("");
                    }, 3000);


            },
            error:function (data) {
                $(".productoverlay").fadeOut();
            Lobibox.notify("error", {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: "top right",
                icon: "fa fa-times-circle",
                msg: "Something went wrong",
            });

            },
        });
    });

</script>


@endsection

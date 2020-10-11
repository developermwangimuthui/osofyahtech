@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Services
                        <a href="#" class="btn btn-info btn-round waves-effect waves-light m-1" data-toggle="modal"
                            data-target="#servicemodal">Add Service</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="service_table" class="table table-bordered ">
                                <thead>

                                    <th>Service</th>
                                    <th>Description</th>
                                    <th>Action</th>

                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                    <th>Service</th>
                                    <th>Description</th>
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
<div class="modal fade servicemodal" id="servicemodal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="overlay" style="display:none;" class="serviceoverlay">
                    <div class="spinner"></div>
                    <br />
                    Loading...
                </div>
                <span id="form_result"></span>
                <form id="service_add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="title">Service Name</label>
                            <input type="text" class="form-control form-control-rounded" id="service"
                                placeholder="Enter Service Name" name="service">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="summernoteEditor" cols="30" rows="5"
                            class="form-control form-control-rounded">

                        </textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="main_image">Main Sevirce Image</label>
                            <input type="file" class="form-control form-control-rounded" id="main_image"
                                placeholder="Enter Service Main Name" name="main_image">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gallery">Additional Images</label>
                            <input type="file" class="form-control form-control-rounded" id="gallery"
                                placeholder="Enter Service Additional Images" name="gallery[]" multiple>
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
    var table = $('#service_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('service.index')}}",
        columns:[
        {data: 'service', name: 'service'},
        {data: 'description', name: 'description'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs:[
            {targets:1, render:function(data){
           var trimmedString = data.substring(0, 50);
             return trimmedString + '...';
            }
        },
        ]

        });




   function servicedelete(service_id) {
       console.log(service_id);
    $.ajax({
           url:'/service/destroy/',
           method:'delete',
           data:{
               service_id:service_id,
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

                }
                $('#service_table').DataTable().ajax.reload();
            }

       });
    }



    $("#service_add").on("submit", function (event) {
        event.preventDefault();
        $(".serviceoverlay").fadeIn();
        $.ajax({
            url: "/service/store",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success:function(data){
                $(".serviceoverlay").fadeOut();
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
                     $('#service_add')[0].reset();
                    $('#servicemodal').modal('hide');
                    $('#service_table').DataTable().ajax.reload();
                }
                     $("#form_result").html(html);
                    setTimeout(function () {
                        $("#form_result").html("");
                    }, 3000);


            },
            error:function (data) {
                $(".serviceoverlay").fadeOut();
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

@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-uppercase">
                        Update Service
                    </div>
                    <div class="card-body">
                        @foreach ($services as $service)
                        <form id="service_add" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" value="{{$service->id}}" id="service_id">
                            <div class="form-group">
                                <label for="title">Service Name</label>
                                <input type="text" class="form-control form-control-rounded" id="title"
                                    placeholder="Enter Service Name" name="service" value="{{$service->service}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="summernoteEditor" cols="30" rows="5"
                                    class="form-control form-control-rounded"
                                    placeholder="">{{$service->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="main_image">Main Sevirce Image</label>
                                <input type="file" class="form-control form-control-rounded" id="main_image"
                                    placeholder="Enter Service Main Name" name="main_image">
                            </div>
                            <div class="form-group">
                                <label for="gallery">Additional Images</label>
                                <input type="file" class="form-control form-control-rounded" id="gallery"
                                    placeholder="Enter Service Additional Images" name="gallery[]" multiple>
                            </div>



                            <div class="form-group">
                                <button type="submit" class="btn btn-primary shadow-primary btn-round px-5"><i
                                        class="icon-checkbox3"></i> Save</button>
                            </div>
                        </form>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-uppercase">
                        Current Service Images
                    </div>
                    <div class="card-body">
                        @if (!$photos->count() > 0)
                        <p>No images Yet</p>
                        @else
                        <div class="list_image_gallery">
                            @foreach ($photos as $photo)
                            <div class="icon-remove blue delete" id="imgwrapper{{$photo->id}}">
                                <img class="thumbnail" src="{{url('/ServiceImages').'/'.$photo->image_path }}"
                                    alt="image" height="100" width="100" />
                                <a href="#" onclick="deletepic('{{$photo->id}}')" class="photodelete"
                                    id="{{$photo->id}}"><i class="delete-button fa fa-trash"></i></a>
                            </div>
                            @endforeach
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var service_id =$('#service_id').val();
    $("#service_add").on("submit", function (event) {
        event.preventDefault();
        console.log(service_id);
        $.ajax({
            url: '/service/update/'+service_id,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",

            success:function(data){
               if (data.errors) {
                    Lobibox.notify("error", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.message,
                    });
                }
                if (data.success) {
                    Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-check-circle", //path to image
                        msg: data.message,
                     });
                     $("#form_result").html(html);
                    setTimeout(function () {
                        $("#form_result").html("");
                        location.reload();
                    }, 3000);

                }
            },
            error:function (data) {
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





function deletepic(photo_id) {
        $.ajax({
            url:'/service/photo/destroy',
            method:'Delete',
            data:{
                photo_id:photo_id,
                _token: "{{ csrf_token() }}",
            },
            success:function(data){
                if (data.errors) {
                                Lobibox.notify("error", {
                                    pauseDelayOnHover: true,
                                    continueDelayOnInactiveTab: false,
                                    position: "top right",
                                    icon: "fa fa-times-circle",
                                    msg: data.message,
                                });
                            }
                            if (data.success) {
                                Lobibox.notify("success", {
                                    pauseDelayOnHover: true,
                                    continueDelayOnInactiveTab: false,
                                    position: "top right",
                                    icon: "fa fa-check-circle", //path to image
                                    msg: data.message,
                                });

                            }
            location.reload();
            },
            error:function(){
                console.log('error');

            }
        });

    }
    </script>
    @endsection

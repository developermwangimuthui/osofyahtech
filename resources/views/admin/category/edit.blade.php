@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <span id="form_result"></span>
            </div>
            <div id="overlay" style="display:none;" class="categoryoverlay">
                <div class="spinner"></div>
                <br />
                Loading...
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-uppercase">
                        Update Category
                    </div>
                    <div class="card-body">
                        @foreach ($categories as $category)
                        <form id="category_add" method="POST" enctype="multipart/form-data"
                            action="{{route('category.update',$category->id)}}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="category_id" id="category_id" value="{{$category->id}}">
                                <label for="title">Category Name</label>
                                <input type="text" class="form-control form-control-rounded" id="title"
                                    placeholder="Enter Category Name" name="category" value="{{$category->category}}">
                            </div>

                            <div class="form-group">
                                <label for="image">Category Image</label>
                                <input type="file" class="form-control form-control-rounded" id="image"
                                    name="image_path">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary shadow-primary btn-round px-5"><i
                                        class="icon-checkbox3"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-uppercase">
                        Current Category Image
                    </div>
                    <div class="card-body">
                        @if ($category->image_path == '')
                        <p>No images Yet</p>
                        @else
                        <div class="list_image_gallery">
                            <div class="icon-remove blue delete">
                                <img class="thumbnail" src="{{url('/CategoryImages').'/'.$category->image_path }}"
                                    alt="image" height="100" width="100" />
                            </div>

                        </div>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script>
        var category_id =$('#category_id').val();
    $("#category_add").on("submit", function (event) {
        event.preventDefault();
        $(".categoryoverlay").fadeIn();
        $.ajax({
            url: '/category/update/'+category_id,
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",

            success:function(data){
                $(".categoryoverlay").fadeOut();
               if (data.errors) {
                html ='<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" \
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
                        Lobibox.notify("warning", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.warning,
                    });
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
                }
                $("#form_result").html(html);
                setTimeout(function () {
                    $("#form_result").html("");
                    location.reload();
                }, 2000);


            },
            error:function (data) {
                $(".categoryoverlay").fadeOut();
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
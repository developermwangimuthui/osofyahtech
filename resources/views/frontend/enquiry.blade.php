@extends('layouts.main')
@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-5"
    data-bg-img="/front/images/macrolan/office1.jpeg">
    <div class="container pt-70 pb-20">
        <!-- Section Content -->
        <div class="section-content">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title text-white">Enquiry Form</h3>
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
                    {{-- inquiry form --}}
                    <form id="inquiryform">
                        <div id="overlay" style="display:none;" class="inquiryoverlay">
                            <div class="spinner"></div>
                            <br />
                            submiting...
                        </div>
                        <center style="margin-top:20px;"><span id="form_results"></span> </center>
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Contact Person *</label>
                                <input id="contact_person" type="text" class="form-control form-control-rounded"
                                    name="contact_person" autofocus placeholder="Contact Person *" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Business Trading Name</label>
                                <input id="business_name" type="text" class="form-control form-control-rounded"
                                    name="business_name" placeholder="Business Trading Name">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Street Address *</label>
                                <input id="street_address" type="text" class="form-control form-control-rounded"
                                    name="street_address" placeholder="Street Address *" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Street Address 2</label>
                                <input id="street_address2" type="text" class="form-control form-control-rounded"
                                    name="street_address2" placeholder="Street Address 2">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Country *</label>
                                <select class="form-control" name="country" required>
                                    <option value="" disabled selected>Select Country *</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Rwanda">Rwanda</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>City *</label>
                                <input id="city" type="text" class="form-control form-control-rounded" name="city"
                                    placeholder="city *" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Zip Code</label>
                                <input id="zip_code" type="text" class="form-control form-control-rounded"
                                    name="zip_code" placeholder="Zip Code">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Telephone *</label>
                                <input id="tel" type="text" class="form-control form-control-rounded" name="tel"
                                    placeholder="telephone *" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Fax Number</label>
                                <input id="fax" type="text" class="form-control form-control-rounded" name="fax"
                                    placeholder="Fax Number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Website</label>
                                <input id="website" type="text" class="form-control form-control-rounded" name="website"
                                    placeholder="website">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Email *</label>
                                <input id="email" type="email" class="form-control form-control-rounded" name="email"
                                    required placeholder="Email *" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Enquiry Service Category</label>
                                <select class="form-control" name="service">
                                    <option value="" disabled selected>Select Service Category</option>
                                    @foreach ($services as $service)
                                    <option value="{{$service->service}}">{{$service->service}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="radio form-group col-md-4">
                                <h5>Are you currently doing business with us?</h5>
                                <label class="radio-inline">
                                    <input type="radio" id="yes" name="current_customer" value="yes">
                                    Yes </label>
                                <label class="radio-inline">
                                    <input type="radio" id="no" name="current_customer" value="no">
                                    No </label>
                            </div>
                            <div class="radio form-group col-md-8">
                                <h5>How did you find out about Macrolan Kenya Ltd?</h5>
                                <label class="radio-inline">
                                    <input type="radio" id="Internet" name="referral" value="Internet">
                                    Internet </label>
                                <label class="radio-inline">
                                    <input type="radio" id="Advertisement" name="referral" value="Advertisement">
                                    Advertisement </label>
                                <label class="radio-inline">
                                    <input type="radio" id="TradeReference" name="referral" value="Trade Reference">
                                    Trade Reference </label>
                                <label class="radio-inline">
                                    <input type="radio" id="Trade Show" name="referral" value="Trade Show">
                                    Trade Show </label>
                                <label class="radio-inline">
                                    <input type="radio" id="Other" name="referral" value="Other">
                                    Other </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="attachment">Attachment</label>
                                <input type="file" id="attachment" name="attachment">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="message">Message</label><br>
                                <textarea id="message" class="form-control-rounded col-md-12" name="message"
                                    rows="7"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-default text-center">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(function () {

    $("#inquiryform").on("submit", function (e) {
      e.preventDefault(),
      $(".inquiryoverlay").fadeIn();
          $.ajax({
              url: "{{route('submitEnquiry')}}",
              method: "post",
              data: new FormData(this),
              contentType: !1,
              cache: !1,
              processData: !1,
              dataType: "json",
              success: function (data) {
                $(".inquiryoverlay").fadeOut();                 
                  var html = "";
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
                              Lobibox.notify("error", {
                                    pauseDelayOnHover: true,
                                    continueDelayOnInactiveTab: false,
                                    position: "top right",
                                    icon: "fa fa-times-circle",
                                    msg: data.errors[count],
                                });
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
                          $('#inquiryform')[0].reset();
                          Lobibox.notify("success", {
                                  pauseDelayOnHover: true,
                                  continueDelayOnInactiveTab: false,
                                  position: "top right",
                                  icon: "fa fa-times-circle",
                                  msg: data.success,
                              });      
                              setTimeout(function () {
                                  $("#form_results").html("");
                                window.location.href = "/";
                              }, 2000);          

                  }
                        
                  $("#form_results").html(html);
                            setTimeout(function () {
                                $("#form_results").html("");
                            }, 2000);
                      
              },
          });
      });

});

</script>

@endsection
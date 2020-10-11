@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Enquiries                       
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="enquiry_table" class="table table-bordered ">
                                <thead>
                                    <th>Contact Person</th>
                                    <th>Business Name</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Zip Code</th>
                                    <th>Street Adrress 1</th>
                                    <th>Street Address 2</th>
                                    <th>Tel</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                    <th>Website</th>
                                    <th>Service Type</th>
                                    <th>Current Customer?</th>
                                    <th>Know How</th>
                                    <th>Message</th>
                                    <th>Attachment</th>
                                    <th>Date</th>
                                    <th>Action</th>

                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <th>Contact Person</th>
                                    <th>Business Name</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Zip Code</th>
                                    <th>Street Adrress 1</th>
                                    <th>Street Address 2</th>
                                    <th>Tel</th>
                                    <th>Fax</th>
                                    <th>Email</th>
                                    <th>Website</th>
                                    <th>Service Type</th>
                                    <th>Current Customer?</th>
                                    <th>Know How</th>
                                    <th>Message</th>
                                    <th>Attachment</th>
                                    <th>Date</th>
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


<script>
    var table = $('#enquiry_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('enquiry.index')}}",
        columns:[
        {data: 'contact_person', name: 'contact_person'},
        {data: 'business_name', name: 'business_name'},
        {data: 'country', name: 'country'},
        {data: 'City', name: 'City'},
        {data: 'Zip_code', name: 'Zip_code'},
        {data: 'street_address1', name: 'street_address1'},
        {data: 'street_address2', name: 'street_address2'},
        {data: 'tel', name: 'tel'},
        {data: 'fax', name: 'fax'},
        {data: 'email', name: 'email'},
        {data: 'website', name: 'website'},
        {data: 'request_service', name: 'request_service'},
        {data: 'is_current_customer', name: 'is_current_customer'},
        {data: 'referral', name: 'referral'},
        {data: 'message', name: 'message'},
        {data: 'attachment', name: 'attachment'},
        {data: 'created_at', name: 'created_at'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs:[
            {targets:14, render:function(data){
                if (data == null) {
                    return data;
                } else {
                    var trimmedString = data.substring(0, 20);
                    return trimmedString + '...';
                    } 
                }               
            },
            {targets:16, render:function(data){
                return moment(data).format('MM/D/YYYY');
                }
            },
            {targets:15, render:function(data){
                if (data != null) {
                    return '<a id="attachment" href="{{URL::to('/')}}/EnquiryFiles/'+data+'" target="_blank">View file</a>';
                } else {
                    return 'no file';
                }
                
                }
            }
        ]

        });



   function enquirydelete(enquiry_id) {
    $.ajax({
           url:'/enquiry/destroy/',
           method:'delete',
           data:{
            enquiry_id:enquiry_id,
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
                $('#enquiry_table').DataTable().ajax.reload();
            }

       });
    }



</script>


@endsection

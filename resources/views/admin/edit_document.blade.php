@extends('admin.includes.Template')



@section('content')



    <style>
        .custom_css_model h3 {

            font-size: 18px;

        }



        .custom_css_model .btn {

            padding: 0 8px !important;

        }
    </style>



    <div class="content container-fluid">







        <!-- Page Header -->



        <div class="page-header">



            <div class="row">



                <div class="col-sm-12">



                    <h3 class="page-title">Edit Document Upload</h3>



                    <ul class="breadcrumb">



                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>



                        <li class="breadcrumb-item"><a href="{{ route('car-inspection-order') }}">Document Upload</a></li>



                        <li class="breadcrumb-item active">Edit Document Upload</li>



                    </ul>



                </div>



            </div>



        </div>



        <!-- /Page Header -->







        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">



                <strong>Success!</strong> {{ $message }}



                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>



            </div>
        @endif







        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">



            <strong>Success! </strong><span id="success_message"></span>



            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->



        </div>







        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">



            <i class="fa fa-warning"></i>



            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->



            <b>Error &nbsp;: </b><span id="error_msg1"></span>



        </div>







        <div class="row">



            <div class="col-md-12">



                <div class="card">



                    <div class="card-body">



                        <!-- <h4 class="card-title">Basic Info</h4> -->



                        <form id="documentform" action="{{route('car-inspection-document-upload-store')}}" method="POST"
                            enctype="multipart/form-data">
                       






                            <INPUT TYPE="hidden" NAME="action" VALUE="edit">



                            <INPUT TYPE="hidden" NAME="id" VALUE="{{ request()->segment(3) }}">



                            @csrf







                            <div class="row">











                                <div class="col-md-12">



                                    <div class="form-group">



                                        <label>Document Upload</label>



                                        <input type="file" class="form-control" id="attachment1" name="attachment1"
                                            multiple>







                                    </div>







                                </div>
                                @if ($ordredocument->verifybuy_documents != '')
                                <div class="col-md-12">
                                      <a href="{{ asset('public/upload/documents/' . $ordredocument->verifybuy_documents) }}"
                                        target="_blank"
                                        style="display: inline-block;">
                                            <img src="{{ asset('public/site/images/PDF_file_icon.png') }}" alt="PDF" style="width:64px; height:auto;">
                                            <br><span style="font-size: 12px;">View PDF</span>
                                        </a>
                                </div>
                                @endif







                            </div>



                            <div class="text-end mt-4">



                                <a class="btn btn-primary" href="{{ route('car-inspection-order') }}"> Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:validation()">Submit</button>



                                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->



                            </div>



                        </form>







                    </div>



                </div>



            </div>







            <style>
                .border_parts tr td {



                    border: 1px solid #ccc;



                    padding: 6px 6px 0px 6px;



                    width: 413px;



                    float: left;



                    border-collapse: collapse;



                    border-spacing: 0px;



                }
            </style>










        </div>



    </div>

     


@stop



@section('footer_js')

 <!-- set order Modal -->

 <div class="modal custom-modal fade" id="set_order_model" role="dialog">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-body">

                <div class="modal-text text-center">

                    <h3>Are you sure you want to Set order of Blog</h3>

                    <input type="hidden" name="set_order_val" id="set_order_val" value="">

                    <input type="hidden" name="set_order_id" id="set_order_id" value="">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                    <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- /set orderModal -->



    <!-- Setbaseimage Modal -->

    <div class="modal custom-modal fade custom_css_model" id="setbaseimg_popup" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-text text-center">

                        <h3 id="poup_text">Are you sure you want to set these image as baseimage</h3>

                        <input type="hidden" name="setbaseimg_id" id="setbaseimg_id" value="">

                        <input type="hidden" name="setbaseimg_pid" id="setbaseimg_pid" value="">

                        <input type="hidden" name="setbaseimg_image_index" id="setbaseimg_image_index" value="">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                        <button type="button" class="btn btn-primary" onclick="setbaseimg();">Yes</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- /Setbaseimage Modal -->



    <!-- setbaseimghover_popup Modal -->

    <div class="modal custom-modal fade custom_css_model" id="setbaseimghover_popup" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-text text-center">

                        <h3 id="poup_text">Are you sure you want to set these image as baseimage hover</h3>

                        <input type="hidden" name="setbaseimghover_id" id="setbaseimghover_id" value="">

                        <input type="hidden" name="setbaseimghover_pid" id="setbaseimghover_pid" value="">

                        <input type="hidden" name="setbaseimghover_image_index" id="setbaseimghover_image_index"
                            value="">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                        <button type="button" class="btn btn-primary" onclick="setbaseimghover();">Yes</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- /setbaseimghover_popup Modal -->



    <!-- Delete  Modal -->

    <div class="modal custom-modal fade" id="delete_model" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-icon text-center mb-3">

                        <i class="fas fa-trash-alt text-danger"></i>

                    </div>

                    <div class="modal-text text-center">

                        <!-- <h3>Delete Expense Category</h3> -->

                        <p>Are you sure want to delete?</p>

                    </div>

                </div>

                <div class="modal-footer text-center">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" id="deleteImageBtn">Delete</button>

                </div>

            </div>

        </div>

    </div>

    <!-- /Delete Modal -->

    <script>
        
        function updateorder_popup(val, id) {
 
             $('#set_order_val').val(val);
 
             $('#set_order_id').val(id);
 
             $('#set_order_model').modal('show');
 
             }
 
 
 
             function updateorder() {
 
             var id = $('#set_order_id').val();
 
             var val = $('#set_order_val').val();
 
             $.ajax({
 
                 type: "POST",
 
                 url: "{{ url('set_order_image') }}",
 
                 data: {
 
                     "_token": "{{ csrf_token() }}",
 
                     "id": id,
 
                     "val": val
 
                 },
 
                 success: function(returnedData) {
 
                     // alert(returnedData);
 
                     if (returnedData == 1) {
 
                         // alert('yes');
 
                         $('#success_message').text("Set Order has been Updated successfully");
 
                         //$('.success_show').show();
 
                         $('.success_show').show().delay(0).fadeIn('show');
 
                         $('.success_show').show().delay(5000).fadeOut('show');
 
 
 
                         $('#set_order_model').modal('hide');
 
                     }
 
                 }
 
             });
 
 
 
             }
 
     </script>





    <script>
        function validation() {



            var attachment1 = $("#attachment1").val();



            if (attachment1 == '') {



                //alert('Please Enter Fabric ');			



                $("#error_msg1").html("Please Select Image.");



                $("#validator").css("display", "block");



                return false;



            }



            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#documentform').submit();



        }





        function setbaseimg_popup(id, pid, image_index) {



            $('#setbaseimg_id').val(id);

            $('#setbaseimg_pid').val(pid);

            $('#setbaseimg_image_index').val(image_index);



            $('#setbaseimg_popup').modal('show');

        }







        function setbaseimg() {



            var id = $('#setbaseimg_id').val();

            var pid = $('#setbaseimg_pid').val();



            $.ajax({



                type: "POST",



                url: "{{ url('product_setbaseimage') }}",



                data: {



                    "_token": "{{ csrf_token() }}",



                    "id": id,



                    "pid": pid



                },



                success: function(returnedData) {



                    // alert(returnedData);



                    if (returnedData == 1) {



                        //alert('yes');



                        $('#success_message').text("Set Base Image has been Updated successfully");



                        //$('.success_show').show();



                        $('.success_show').show().delay(0).fadeIn('show');



                        $('.success_show').show().delay(5000).fadeOut('show');



                        $('#setbaseimg_popup').modal('hide');



                        //location.reload();



                    }



                }



            });



        }





        function setbaseimghover_popup(id, pid, image_index) {



            $('#setbaseimghover_id').val(id);

            $('#setbaseimghover_pid').val(pid);

            $('#setbaseimghover_image_index').val(image_index);



            $('#setbaseimghover_popup').modal('show');



        }







        function setbaseimghover() {



            var id = $('#setbaseimghover_id').val();

            var pid = $('#setbaseimghover_pid').val();



            $.ajax({



                type: "POST",



                url: "{{ url('product_setbaseimghover') }}",



                data: {



                    "_token": "{{ csrf_token() }}",



                    "id": id,



                    "pid": pid



                },



                success: function(returnedData) {



                    // alert(returnedData);



                    if (returnedData == 1) {



                        //alert('yes');



                        $('#success_message').text("Set Base Image has been Updated successfully");



                        //$('.success_show').show();



                        $('.success_show').show().delay(0).fadeIn('show');



                        $('.success_show').show().delay(5000).fadeOut('show');



                        //location.reload();



                        $('#setbaseimghover_popup').modal('hide');



                    }



                }



            });





        }





        $(document).on('click', '.btn-remove', function(event) {

            event.preventDefault(); // Prevent the default link behavior

            var deleteUrl = $(this).data('delete-url'); // Get the delete URL from data attribute



            // Set the click event for the "Yes" button in the modal

            $('#deleteImageBtn').off('click').on('click', function() {

                window.location.href = deleteUrl; // Redirect to the delete URL

            });



            // Show the modal

            $('#delete_model').modal('show');

        });







        function singledelete(url)



        {



            var t = confirm('Are You Sure To Delete Image ?');



            if (t)



            {



                window.location.href = url;



            } else



            {



                return false;



            }



        }
    </script>







@stop

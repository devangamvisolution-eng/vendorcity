@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Coupon</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coupan.index') }}">Coupon</a></li>
                        <li class="breadcrumb-item active">Add Coupon</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
            <i class="fa fa-warning"></i>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
            <b>Error &nbsp;: </b><span id="error_msg1"></span>
        </div>
        <!-- <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
                                                                                                                        <span id="login_error"></span>
                                                                                                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                                                                                    </div> -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form action="{{ route('coupan.store') }}" method="POST" id="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Name</label>
                                        <input type="text" class="form-control" id="coupan_name" name="coupan_name" placeholder="Enter Coupan Name">
                                        <p id="coupan_name_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Code</label>
                                        <input type="text" class="form-control" placeholder="Enter Coupan Code"id="coupan_code" name="coupan_code">
                                        <p id="coupan_code_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_id">Service</label>
                                        <select class="form-control" multiple="multiple"  id="service_id" name="service_id[]" onchange="coupan_subservice_change(this.value);">
                                            <option value="">Select Service</option>
                                            @foreach ($service as $service_data)
                                                <option value="{{ $service_data->id }}">{{ $service_data->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p id="service_id_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subservice_id">Subservice</label>
                                        <div id="subservice_change">
                                        <select class="form-control" multiple="multiple" id="subservice_id"
                                            name="subservice_id[]">
                                            <option value="">Select Subservice</option>
                                        </select>
                                        </div>
                                        <p id="subservice_id_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Discount</label>
                                        <input type="text" class="form-control" id="discount" name="discount"placeholder="Enter Discount Amount"
                                            onkeypress="return numbersonly(event)">
                                        <p id="discount_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="coupanvalue">Coupon Value:</label><br>
                                        <input type="radio" value="1" name="coupanvalue" id="coupanvalue"
                                            class="">&nbsp; Price &nbsp;&nbsp;
                                        <input type="radio"value="0" name="coupanvalue" id="coupanvalue"
                                            class="">&nbsp; Percentage &nbsp;&nbsp;
                                        <p id="coupanvalue_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="coupan_apply_wallet_lable">Coupon Apply/Wallet:</label><br>
                                        <input type="radio" value="1" name="coupan_apply_wallet" id="coupan_apply_wallet"
                                            class="">&nbsp; Apply &nbsp;&nbsp;
                                        <input type="radio" value="0" name="coupan_apply_wallet" id="coupan_apply_wallet"
                                            class="" >&nbsp; Add to User Wallet &nbsp;&nbsp;
                                        <p id="coupan_apply_wallet_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="minimum_order">Minimum Order</label>
                                        <input id="minimum_order" name="minimum_order" type="text" class="form-control"
                                            placeholder="Enter Minimum Order" />
                                        <p id="minimum_order_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_of_coupons">No. Of Coupons</label>
                                        <input id="no_of_coupons" name="no_of_coupons" type="text" class="form-control"
                                            placeholder="Enter No. Of Coupons" />
                                        <p id="no_of_coupons_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_of_coupons_user">No. Of Coupons Per User</label>
                                        <input id="no_of_coupons_user" name="no_of_coupons_user" type="text"
                                            class="form-control" placeholder="Enter No. Of Coupons Per User" />
                                        <p id="no_of_coupons_user_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startdate">Start date:</label>
                                        <input id="startdate" name="startdate" type="date" class="form-control"
                                            placeholder="Enter Startdate" autocomplete="off" />
                                        <p id="startdate_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="enddate">End date:</label>
                                        <input id="enddate" name="enddate" type="date" class="form-control"
                                            placeholder="Enter Enddate" autocomplete="off" />
                                        <p id="enddate_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" style="margin:15px 0 5px 0px; width:100%;">
                                            Description</label>
                                        <textarea id="description" name="description" class="form-control" placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="{{ route('coupan.index') }}" class="btn btn-primary text-light">Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" onclick="validation();" id="submit_button"
                                    class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <script>
        function validation() {
            var coupan_name = $("#coupan_name").val();
            if (coupan_name == '') {
                $("#coupan_name_error").html("Please Enter Coupon Name.");
                //$("#validator").css("display","block");
                $('#coupan_name_error').show().delay(0).fadeIn('show');
                $('#coupan_name_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#coupan_name_error").offset().top - 150
                }, 100);
                return false;
            }
            var coupan_code = $("#coupan_code").val();
            if (coupan_code == '') {
                $("#coupan_code_error").html("Please Enter Coupon Code.");
                //$("#validator").css("display","block");
                $('#coupan_code_error').show().delay(0).fadeIn('show');
                $('#coupan_code_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#coupan_code_error").offset().top - 150
                }, 100);
                return false;
            }
            var discount = $("#discount").val();
            if (discount == '') {
                $("#discount_error").html("Please Enter Discount.");
                //$("#validator").css("display","block");
                $('#discount_error').show().delay(0).fadeIn('show');
                $('#discount_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#discount_error").offset().top - 150
                }, 100);
                return false;
            }
            if ((form.coupanvalue[0].checked == false) && (form.coupanvalue[1].checked == false)) {
                $("#coupanvalue_error").html("Please Select Coupon Value");
                // $("#coupanvalue_error").css("display", "block");
                $('#coupanvalue_error').show().delay(0).fadeIn('show');
                $('#coupanvalue_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#coupanvalue_error").offset().top - 150
                }, 100);
                return false;
            }
            if ((form.coupan_apply_wallet[0].checked == false) && (form.coupan_apply_wallet[1].checked == false)) {
                $("#coupan_apply_wallet_error").html("Please Select Coupon Will be Apply or Amount add on User Wallet");
                $('#coupan_apply_wallet_error').show().delay(0).fadeIn('show');
                $('#coupan_apply_wallet_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#coupan_apply_wallet_error").offset().top - 150
                }, 100);
                return false;
            }
            var minimum_order = $("#minimum_order").val();
            if (minimum_order == '') {
                //alert('Please Enter Category ');
                $("#minimum_order_error").html("Please Enter Minimum Order.");
                //$("#validator").css("display","block");
                $('#minimum_order_error').show().delay(0).fadeIn('show');
                $('#minimum_order_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#minimum_order_error").offset().top - 150
                }, 100);
                return false;
            }
            var no_of_coupons = $("#no_of_coupons").val();
            if (no_of_coupons == '') {
                //alert('Please Enter Category ');
                $("#no_of_coupons_error").html("Please Enter No Of Coupon.");
                //$("#validator").css("display","block");
                $('#no_of_coupons_error').show().delay(0).fadeIn('show');
                $('#no_of_coupons_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#no_of_coupons_error").offset().top - 150
                }, 100);
                return false;
            }
            var no_of_coupons_user = $("#no_of_coupons_user").val();
            if (no_of_coupons_user == '') {
                //alert('Please Enter Category ');
                $("#no_of_coupons_user_error").html("Please Enter No Of Coupon Per User.");
                //$("#validator").css("display","block");
                $('#no_of_coupons_user_error').show().delay(0).fadeIn('show');
                $('#no_of_coupons_user_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#no_of_coupons_user_error").offset().top - 150
                }, 100);
                return false;
            }
            var startdate = $("#startdate").val();
            if (startdate == '') {
                //alert('Please Enter Category ');
                $("#startdate_error").html("Please Enter Start Date.");
                //$("#validator").css("display","block");
                $('#startdate_error').show().delay(0).fadeIn('show');
                $('#startdate_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#startdate_error").offset().top - 150
                }, 100);
                return false;
            }
            var enddate = $("#enddate").val();
            if (enddate == '') {
                //alert('Please Enter Category ');
                $("#enddate_error").html("Please Enter End Date.");
                //$("#validator").css("display","block");
                $('#enddate_error').show().delay(0).fadeIn('show');
                $('#enddate_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#enddate_error").offset().top - 150
                }, 100);
                return false;
            }
            var service_id = $("#service_id").val();
            if(service_id == ''){
                //alert('Please Enter Category ');
                $("#service_id_error").html("Please Select Service.");
                //$("#validator").css("display","block");
                $('#service_id_error').show().delay(0).fadeIn('show');
                $('#service_id_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#service_id_error").offset().top - 150
                }, 100);
                return false;
            }
            var subservice_id = $("#subservice_id").val();
            if(subservice_id == ''){
                //alert('Please Enter Category ');
                $("#subservice_id_error").html("Please Select SubService.");
                //$("#validator").css("display","block");
                $('#subservice_id_error').show().delay(0).fadeIn('show');
                $('#subservice_id_error').show().delay(5000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $("#subservice_id_error").offset().top - 150
                }, 100);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#form').submit();
        }
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
    
        $(document).ready(function() {
            $('#service_id').select2({
                placeholder: 'Select Service', // Add your desired placeholder text here
            });
        });
        $(document).ready(function() {
            $('#subservice_id').select2({
                placeholder: 'Select Subservice', // Add your desired placeholder text here
            });
        });
        function numbersonly(e) {
            var unicode = e.charCode ? e.charCode : e.keyCode
            if (unicode != 8) { //if the key isn't the backspace key (which we should allow)
                if (unicode < 45 || unicode > 57) //if not a number
                    return false //disable key press
            }
        }
        $(document).ready(function() {
            $("#startdate").change(function() {
                var selectedStartDate = new Date($(this).val());
                selectedStartDate.setDate(selectedStartDate.getDate() + 0); // Add 1 day to the start date
                var endInput = $("#enddate");
                endInput.attr("min", selectedStartDate.toISOString().split("T")[0]);
                // Reset end date if it's before the new min date
                if (new Date(endInput.val()) < selectedStartDate) {
                    endInput.val('');
                }
            });
        });
        
    </script>
 
    <script type="text/javascript">
       function coupan_subservice_change() {
        // alert(value);
        var value = $("#service_id").val();
        var selectedSubservices = $("#subservice_id").val();
               var url = '{{ url('coupan_subservice_change') }}';
               $.ajax({
                   url: url,
                   type: 'post',
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "service_id": value,
                       "selected_subservice_ids": selectedSubservices
                   },
                   success: function(msg) {
                       document.getElementById('subservice_change').innerHTML = msg;
                       $("#subservice_id").select2({
                           placeholder: "Select a Subservice"
                       });
                   }
               });
           }
    </script>
@stop

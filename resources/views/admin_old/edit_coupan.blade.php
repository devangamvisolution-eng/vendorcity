@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Coupon</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coupan.index') }}">Coupon</a></li>
                        <li class="breadcrumb-item active">Edit Coupon</li>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="form" action="{{ route('coupan.update', $coupan_data->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Name</label>
                                        <input type="text" class="form-control" id="coupan_name" name="coupan_name"
                                            value="{{ $coupan_data->coupan_name }}">
                                        <p id="coupan_name_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Coupon Code</label>
                                        <input type="text" class="form-control" id="coupan_code" name="coupan_code"
                                            value="{{ $coupan_data->coupan_code }}">
                                        <p id="coupan_code_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_id">Service</label>
                                        <select class="form-control" multiple="multiple"  id="service_id" name="service_id[]" onchange="coupan_subservice_change(this.value);">
                                            @php $in_service_id = explode(",",$coupan_data->service_id); @endphp
                                            <option value="">Select Service</option>
                                            @foreach ($service as $service_data)
                                                <option value="{{ $service_data->id }}"
                                                    @if (in_array($service_data->id, $in_service_id)) {{ 'selected' }} @endif>
                                                    {{ $service_data->servicename }}</option>
                                            @endforeach
                                        </select>
                                        <p id="service_id_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subservice_id">Sub service</label>
                                        <div id="subservice_change">
                                        <select class="form-control" multiple="multiple" id="subservice_id"
                                            name="subservice_id[]">
                                            @php $in_subservice_id = explode(",",$coupan_data->subservice_id); @endphp
                                            <option value="">Select Subservice</option>
                                            @foreach ($subservice as $subcat_data)
                                                <option value="{{ $subcat_data->id }}"
                                                    @if (in_array($subcat_data->id, $in_subservice_id)) {{ 'selected' }} @endif>
                                                    {{ $subcat_data->subservicename }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        <p id="subservice_id_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                               
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Discount</label>
                                        <input type="text" class="form-control" id="discount" name="discount"
                                            onkeypress="return numbersonly(event)" value="{{ $coupan_data->discount }}">
                                        <p id="discount_error" style="display: none;color: red"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="coupanvalue">Coupon Value:</label><br>
                                        <input type="radio" value="1"
                                            {{ $coupan_data->coupanvalue == 1 ? 'checked' : '' }} name="coupanvalue"
                                            id="coupanvalue" class="">&nbsp; Price &nbsp;&nbsp;
                                        <input type="radio"value="0"
                                            {{ $coupan_data->coupanvalue == 0 ? 'checked' : '' }} name="coupanvalue"
                                            id="coupanvalue" class="">&nbsp; Percentage &nbsp;&nbsp;
                                        <p id="coupanvalue_error" style="display: none;color: red"></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="coupan_apply_wallet">Coupon Apply/Wallet:</label><br>
                                        <input type="radio" value="1"
                                            {{ $coupan_data->coupan_apply_wallet == 1 ? 'checked' : '' }} name="coupan_apply_wallet"
                                            id="coupan_apply_wallet" class="">&nbsp; Apply  &nbsp;&nbsp;
                                        <input type="radio" value="0"
                                            {{ $coupan_data->coupan_apply_wallet === 0 ? 'checked' : '' }} name="coupan_apply_wallet"
                                            id="coupan_apply_wallet" class="">&nbsp; Add to User Wallet &nbsp;&nbsp;
                                        <p id="coupan_apply_wallet_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="minimum_order">Minimum Order</label>
                                        <input id="minimum_order" name="minimum_order" type="text" class="form-control"
                                            placeholder="Enter Minimum Order" value="{{ $coupan_data->minimum_order }}" />
                                        <p id="minimum_order_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_of_coupons">No. Of Coupons</label>
                                        <input id="no_of_coupons" name="no_of_coupons" type="text" class="form-control"
                                            placeholder="Enter No. Of Coupons" value="{{ $coupan_data->no_of_coupons }}" />
                                        <p id="no_of_coupons_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_of_coupons_user">No. Of Coupons Per User</label>
                                        <input id="no_of_coupons_user" name="no_of_coupons_user" type="text"
                                            class="form-control" placeholder="Enter No. Of Coupons Per User"
                                            value="{{ $coupan_data->no_of_coupons_user }}" />
                                        <p id="no_of_coupons_user_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="startdate">Start date:</label>
                                        <input id="startdate" name="startdate" type="date" class="form-control"
                                            placeholder="Enter Startdate" autocomplete="off"
                                            value="{{ $coupan_data->startdate }}" />
                                        <p id="startdate_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="enddate">End date:</label>
                                        <input id="enddate" name="enddate" type="date" class="form-control"
                                            placeholder="Enter Enddate" autocomplete="off"
                                            value="{{ $coupan_data->enddate }}" />
                                        <p id="enddate_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                                
                               
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" style="margin:15px 0 5px 0px; width:100%;">
                                            Description</label>
                                        <textarea id="description" name="description" class="form-control" placeholder="Enter Description">{{ $coupan_data->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('coupan.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
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
            //alert('sd');
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
                placeholder: 'Select Category', // Add your desired placeholder text here
            });
        });
        $(document).ready(function() {
            $('#subservice_id').select2({
                placeholder: 'Select SubCategory', // Add your desired placeholder text here
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
            // Get the start date from the database and convert it to a JavaScript Date object
            var startInput = $("#startdate");
            var selectedStartDate = new Date(startInput.val());
            // Set the minimum value for the end date input based on the start date
            var endInput = $("#enddate");
            endInput.attr("min", selectedStartDate.toISOString().split("T")[0]);
            // Update the end date input value if it's before the new min date
            var selectedEndDate = new Date(endInput.val());
            if (selectedEndDate < selectedStartDate) {
                endInput.val(selectedStartDate.toISOString().split("T")[0]);
            }
            // Add a change event listener to the start date input
            startInput.change(function() {
                var newStartDate = new Date($(this).val());
                // Update the minimum value for the end date input
                endInput.attr("min", newStartDate.toISOString().split("T")[0]);
                // If the end date is before the new start date, update the end date
                if (selectedEndDate < newStartDate) {
                    endInput.val(newStartDate.toISOString().split("T")[0]);
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

@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    @if(Route::currentRouteName() == 'cleaning-listing')
                    <h3 class="page-title">Package Order - Cleaning</h3>
                    @elseif(Route::currentRouteName() == 'painting-listing')
                    <h3 class="page-title">Package Order - Painting</h3>
                    @elseif(Route::currentRouteName() == 'salon-spa-listing')
                    <h3 class="page-title">Package Order - Salon & Spa</h3>
                    @elseif(Route::currentRouteName() == 'pest-control-listing')
                    <h3 class="page-title">Package Order - Pest Control</h3>
                    @elseif(Route::currentRouteName() == 'handyman-and-service-listing')
                    <h3 class="page-title">Package Order - Handyman & Service</h3>
                    @else
                    <h3 class="page-title">Package Order - Moving</h3>
                    @endif
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        @if(Route::currentRouteName() == 'cleaning-listing')
                        <li class="breadcrumb-item active">Package Order - Cleaning</li>
                        @elseif(Route::currentRouteName() == 'painting-listing')
                        <li class="breadcrumb-item active">Package Order - Painting</li>
                        @elseif(Route::currentRouteName() == 'salon-spa-listing')
                        <li class="breadcrumb-item active">Package Order - Salon & Spa</li>
                        @elseif(Route::currentRouteName() == 'pest-control-listing')
                        <li class="breadcrumb-item active">Package Order - Pest Control</li>
                        @elseif(Route::currentRouteName() == 'handyman-and-service-listing')
                        <li class="breadcrumb-item active">Package Order - Handyman & Service</li>
                        @else
                        <li class="breadcrumb-item active">Package Order - Moving</li>
                        @endif
                        
                    </ul>
                </div>
                @if (in_array('40', $edit_perm))
                
                    <div class="col-auto">
                    @if(Route::currentRouteName() == 'cleaning-listing')
                    <a class="btn btn-primary me-1" href="{{ route('cleaning-admin-order') }}">
                        <i class="fas fa-plus"></i>Add Cleaning Order
                    </a>
                @endif
                    </div> 
                @endif
            </div>
        </div>
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
         <div class="alert alert-danger alert-dismissible fade show error_show" style="display: none;">
            <strong>Failed! </strong><span id="error_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <!-- Search Filter -->
        <div id="filter_inputs" class="card filter-card">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Search Filter -->
@php
        // echo"<pre>";print_r($vendororders_list);echo"</pre>";
@endphp
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_order') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <!-- <th>select</th> -->
                                            <th style="display: none">Sr no</th>
                                            <th>Order Id</th>
                                            <th>Order Date</th>
                                            @if(Route::currentRouteName() == 'painting-listing')
                                            <th>Date & Time</th>
                                            @elseif(Route::currentRouteName() == 'vendororder.index')
                                            <th>Moving Date</th>
                                            @endif
                                            {{-- <th>Service</th>--}}
                                           
                                            <th>User Name</th>
                                            <th>Amount</th>
                                             <th>Driver</th> 
                                            @if(Route::currentRouteName() == 'cleaning-listing')
                                            <th>Crew</th>
                                            @endif  
                                            <th>Payment Mode</th>
                                            <th>Payment Status</th>
                                            {{-- <th>Order Status</th>
                                            <th>Create Shipment</th>
                                            <th>Schedule Pickup </th>
                                            <th>Label</th>
                                            <th>Track Order</th> --}}
                                            {{-- <th>Assign Vendor</th> --}}
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                             //echo "<pre>";print_r($orders_list);echo"</pre>";
                                             if (isset($vendororders_list) and count($vendororders_list)) {
                                                foreach ($vendororders_list as $key => $vendororders) {
                                        @endphp
                                        
                                            <tr>
                                                <!-- <td></td> -->
                                                <td style="display: none">{{ $i }}</td>
                                                <td>{{$vendororders->format_order_id}}</td>
                                                <td>
                                                    @php
                                                    $order_date = strtotime( $vendororders->created_at);
                                                     echo $mysqldate = date( 'F d, Y', $order_date );
                                                    @endphp
                                                </td>
                                                @if(Route::currentRouteName() == 'painting-listing' || Route::currentRouteName() == 'vendororder.index')
                                                <td>
                                                    @php
                                                    if(Route::currentRouteName() == 'painting-listing'){
                                                    $date = $vendororders->items[0]->bookingdate ?? "";
                                                    $month = $vendororders->items[0]->month ?? "";
                                                    $year = $vendororders->items[0]->bookingyear ?? "";
                                                    $timeSlot = Helper::timeslotname(strval($vendororders->items[0]->time_slot));
                                                    if($date != '' && $month != '' && $year != ''){
                                                        echo $month.' '.$date.', '.$year.'<br/>'.$timeSlot;
                                                    }else{
                                                        echo "-";
                                                    }
                                                    }else{
                                                        if($vendororders->moving_date != ''){
                                                            $moving_date = strtotime( $vendororders->moving_date);
                                                        echo $mysqldate = date( 'F d, Y', $moving_date );
                                                        }else{
                                                            echo "-";
                                                        }
                                                    }
                                                    
                                                    @endphp
                                                </td>
                                                @endif
                                               
                                                <td>{{$vendororders->user_name}}</td>
                                                <td>{{number_format($vendororders->order_total,2);}}</td>
                                                <td>
                                                 @if(isset($vendororders->items[0]) && isset($vendororders->items[0]->driver_id))
                                                    <p> {!! Helper::drivername($vendororders->items[0]->driver_id) !!} </p>
                                                    @else
                                                        <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_driver('{{$vendororders->order_id}}');">Assign Driver</a>
                                                    @endif
                                                </td>
                                                @if(Route::currentRouteName() == 'cleaning-listing')
                                                <td>
                                                @if(isset($vendororders->items[0]))
                                                    @if($vendororders->items[0]->cleaner_id == 2)
                                                        <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_cleaner('{{$vendororders->order_id}}');">Assign Crew</a>
                                                    @elseif($vendororders->items[0]->cleaner_id)   
                                                   
                                                    @php
                                                        $cleaner_Id = explode(",",$vendororders->items[0]->cleaner_id);
                                                    @endphp
                                                        {!! Helper::cleanername_new($cleaner_Id) !!}
                                                    @else
                                                        <a class="btn btn-primary" href="javascript:void(0)" onclick="assign_multi_cleaner('{{$vendororders->order_id}}');">Assign Multiple Crew</a>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                                @endif
                                                <td>
                                                    @if ($vendororders->paymentmode == '1')
                                                        Cash On Delivery
                                                    @elseif ($vendororders->paymentmode == '2')
                                                        Online Payment
                                                    @endif
                                                </td>
                                                <td>{{$vendororders->payment_status}}</td>
                                                
                                                <td class="text-right">
                                                    
                                            @if(isset($vendororders->items[0]) && isset($vendororders->items[0]->service_id))
                                            
                                                @if($vendororders->items[0]->subservice_id == 52)
                                                    <a class="btn btn-primary" href="{{ route('vendor-handyman-and-service-detail', [$vendororders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                                
                                                @elseif($vendororders->items[0]->service_id == 34)
                                                    <a class="btn btn-primary" href="{{ route('vendor-painting-detail', [$vendororders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                                @elseif($vendororders->items[0]->service_id == 45)
                                                    <a class="btn btn-primary" href="{{ route('vendor-cleaning-detail', [$vendororders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                                @elseif($vendororders->items[0]->service_id == 48)
                                                    <a class="btn btn-primary" href="{{ route('vendor-salon-spa-detail', [$vendororders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                                @elseif($vendororders->items[0]->service_id == 47)
                                                    <a class="btn btn-primary" href="{{ route('vendor-pest-control-detail', [$vendororders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                                    
                                                @else
                                                    <a class="btn btn-primary" href="{{ route('vendor-moving-detail', [$vendororders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
                                                    @endif
                                                @endif
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            } }
                                            @endphp
                                        
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
    @section('footer_js')
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
                <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->
<!-- Select one record Category Modal -->
<div class="modal custom-modal fade" id="select_one_record" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-text text-center">
                    <h3>Please select at least one record to delete</h3>
                    <!-- <p>Are you sure want to delete?</p> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Select one record Category Modal -->
<!-- Assign Driver Modal -->
<div class="modal custom-modal fade" id="assign_driver_model" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="assign_driver_form" action="{{ url('assign-driver-form') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                
                <div class="modal-text text-center">
                    <!-- <h3>Delete Expense Category</h3> -->
                    <!-- <p>Select Vendor</p> -->
                </div>
                <div class="modal-text text-center" id="driver_dropdownreplace">
                </div>
                <p class="form-error-text" id="driver_id_error" style="color: red; margin-top: 10px;"></p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                 <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                    style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                    </button>
                <button type="button" id="submit_button" class="btn btn-primary" onclick="form_sub_driver();">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /Assign Driver Modal -->
<!--- cleaner Modal Start-->
    @foreach ($vendororders_list as $key => $orders)
    
    @php
    
    // echo"<pre>";print_r($orders);echo"</pre>";exit;
    $cleaner_data = DB::table('users')
                    ->where('role_id', 16)
                    ->where('is_active', '0')
                    ->whereRaw("FIND_IN_SET(?, service)", [$orders->items[0]->service_id])
                    ->whereRaw("FIND_IN_SET(?, subservice)", [$orders->items[0]->subservice_id])
                    ->orderBy('id', 'ASC')
                    ->get();
//    echo"<pre>";print_r($cleaner_data);echo"</pre>";exit;
    @endphp
        <div class="modal custom-modal fade" id="cleaner_model_{{$orders->order_id}}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="cleaner_assign_form" action="{{ url('vendor-cleaner-assign-form') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <select name="cleaner" id="cleaner_{{$orders->order_id}}" class="form-control">
                                <option value="">Select Cleaner</option>
                                @foreach($cleaner_data as $data)
                                    @if($data->id != 2)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="form-error-text" id="cleaner_error_{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                            </div>
                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button_{{$orders->order_id}}" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" onclick="cleaner_assign({{$orders->order_id}});" id="cleaner_button_{{$orders->order_id}}">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
<!--- Cleaner Modal Close --->
<!--- Multi cleaner Modal Start -->
    @foreach ($vendororders_list as $key => $orders)
    
    {{-- @php
    // echo"<pre>";print_r($orders);echo"</pre>";exit;
    @endphp --}}
    <script>
            $(document).ready(function() {
                $('#multi_cleaner_{{$orders->order_id}}').select2({
                    placeholder: "Select Multiple Crew",
                    dropdownParent: $('#multi_cleaner_model_{{$orders->order_id}}')
                });
            });
    </script>
    @php
    // echo"<pre>";print_r($orders->items[0]);echo"</pre>";exit;
    $cleaner_data = DB::table('users')
                    ->where('role_id', 16)
                    ->where('is_active', '0')
                    ->whereRaw("FIND_IN_SET(?, service)", [$orders->items[0]->service_id])
                    ->whereRaw("FIND_IN_SET(?, subservice)", [$orders->items[0]->subservice_id])
                    ->orderBy('id', 'ASC')
                    ->get();
   
    @endphp
        <div class="modal custom-modal fade" id="multi_cleaner_model_{{$orders->order_id}}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="multi_cleaner_assign_form" action="{{ url('vendor-multi-cleaner-assign-form') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                          
                            <select name="multi_cleaner_{{ $orders->order_id }}" id="multi_cleaner_{{$orders->order_id}}" class="form-control" multiple="mulitple" onchange="vendor_multi_cleaner_timeslot({{$orders->order_id}},{{$orders->items[0]->subservice_id}});"  data-max-select="{{$orders->items[0]->how_many_cleaners_do_you_need}}">
                                @foreach($cleaner_data as $data)
                                    @if($data->id != 2)
                                        <option value="{{$data->id}}">{{$data->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="form-error-text" id="multi_cleaner_error_{{$orders->order_id}}" style="color: red; margin-top: 10px;"></p>
                            <div class="modal-footer text-center">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary mb-1" type="button" disabled id="multi_spinner_button_{{$orders->order_id}}" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" onclick="multi_cleaner_assign({{$orders->order_id}} ,{{$orders->items[0]->how_many_cleaners_do_you_need }})" id="multi_cleaner_button_{{$orders->order_id}}">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      
    @endforeach
<!--- Multi Cleaner Modal Close --->
<script>
    function delete_category() {
        // alert('test');
        var checked = $("#form input:checked").length > 0;
        if (!checked) {
            $('#select_one_record').modal('show');
        } else {
            $('#delete_model').modal('show');
        }
    }
    function form_sub() {
        $('#form').submit();
    }
    function assign_cleaner(order_id){
        $('#cleaner_model_'+order_id).modal('show');
    }
    function assign_multi_cleaner(order_id){
    $('#multi_cleaner_model_'+order_id).modal('show');
    }
    function assign_driver(order_id){
      
        var url = '{{ url('assign-driver') }}';
        $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
                },
                success: function(msg) {
                    document.getElementById('driver_dropdownreplace').innerHTML = msg;
                    $('#assign_driver_model').modal('show');
                    
                }
        });
    }
    function form_sub_driver() {
        var driver_id = jQuery("#driver_id").val();
            if (driver_id == '') {
                jQuery('#driver_id_error').html("Please Select Driver");
                jQuery('#driver_id_error').show().delay(0).fadeIn('show');
                jQuery('#driver_id_error').show().delay(2000).fadeOut('show');
                
                return false;
            }
        $('#spinner_button').show();
        $('#submit_button').hide();
        $('#assign_driver_form').submit();
    }
    function vendor_multi_cleaner_timeslot(order_id,subservice_id) {
        var selectElement = jQuery("#multi_cleaner_" + order_id);
        var maxSelect = selectElement.data("max-select"); // Get the max selection count
        var selectedOptions = selectElement.val();
        if(subservice_id == 28){
        if (selectedOptions.length > maxSelect) {
            alert("You can only select up to " + maxSelect + " Crew.");
            // Deselect the last selected option
            selectedOptions.pop();
            selectElement.val(selectedOptions);
            
            // Trigger change event to update UI
            selectElement.trigger('change');
            return;
        }
    }
        var url = '{{ url('vendor-multi-cleaner-time-slot') }}';
        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "cleaner": selectedOptions,
                "order_id": order_id
            },
            success: function(response) {
                const notAvailable = response.not_available_cleaners?.trim();
                if (notAvailable && notAvailable !== '-') {
                    var cleanerName = response.not_available_cleaners;
                    alert('This Crew is not available: ' + cleanerName);
                }
                var cleanerIds = response.not_available_cleaners_id;
                if (cleanerIds && cleanerIds.length > 0) {
                    cleanerIds.forEach(function(id) {
                        var option = selectElement.find(`option[value="${id}"]`);
                        if (option.length) {
                            option.prop('selected', false); // Deselect unavailable option
                        }
                    });
                    // Trigger change event to update UI
                    selectElement.trigger('change');
                }
            }
        });
    }
    
//Multiple Cleaner Assign Popup Submit

function multi_cleaner_assign(order_id , cleaner_count) {
    var cleaner = jQuery("#multi_cleaner_" + order_id).val();
    if (cleaner == '' || cleaner == null) {
        jQuery('#multi_cleaner_error_' + order_id).html("Please Select Crew");
        jQuery('#multi_cleaner_error_' + order_id).show().delay(2000).fadeOut('show');
        return false;
    }
    // Count the selected cleaners
    let selected_cleaner_count = Array.isArray(cleaner) ? cleaner.length : 0;
    if (selected_cleaner_count < cleaner_count) {
        jQuery('#multi_cleaner_error_' + order_id).html('Please select ' + cleaner_count + ' cleaners');
        jQuery('#multi_cleaner_error_' + order_id).show().delay(2000).fadeOut('show');
        return false;
    }
    $('#multi_cleaner_button_' + order_id).hide();
    $('#multi_spinner_button_'+ order_id).show();
         var url = '{{ url('vendor-multi-cleaner-assign-form') }}';
            $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "order_id": order_id,
                        "cleaner": cleaner,
                    },
                    success: function(response) {
                        if(response.status == 1){
                            $('#success_message').text("Multiple Crew Assigned Successfully");
                            $('.success_show').fadeIn().delay(1000).fadeOut();
                            $('#multi_cleaner_model_'+response.order_id).modal('hide');
                            setTimeout(function() {location.reload();},1500);
                        }
                    }
            });
}
//Multiple Cleaner Assign Popup Submit End
//Auto assign Cleaner Popoup Submit
function cleaner_assign(order_id) {
    // alert(order_id);
    // return false;

var cleaner = jQuery("#cleaner_" + order_id).val();
// alert(cleaner);

if (cleaner == '') {
    jQuery('#cleaner_error_' + order_id).html("Please Select Crew");
    jQuery('#cleaner_error_' + order_id).show().delay(2000).fadeOut('show');
    return false;
}
$('#cleaner_button_' + order_id).hide();
$('#spinner_button_'+ order_id).show();
        var url = '{{ url('vendor-cleaner-assign-form') }}';
            $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "order_id": order_id,
                        "cleaner": cleaner,
                    },
                    success: function(response) {
                        if(response.status == 1){
                            $('#success_message').text("Crew Assigned Successfully");
                            $('.success_show').fadeIn().delay(1000).fadeOut();
                            $('#cleaner_model_'+response.order_id).modal('hide');
                            setTimeout(function() {location.reload();},1500);
                        }else if(response.status == 0){
                            $('#cleaner_model_'+response.order_id).modal('hide');
                            $('#error_message').text(response.message);
                            $('.error_show').fadeIn().delay(1000).fadeOut();
                           
                            // setTimeout(function() {location.reload();},1500);
                        }
                    }
            });
}
//Auto assign Cleaner Popup Submit End
    
</script>
<script>
    if ($.fn.DataTable.isDataTable('#example')) {
        $('#example').DataTable().destroy();
    }
    $(document).ready(function() {
        $('#example').dataTable({
            "searching": true
        });
    })
</script>
@stop
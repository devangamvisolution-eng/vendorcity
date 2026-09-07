@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();       
        $get_user_data = Helper::get_user_data($userId);       
        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);       
        // $edit_perm = [];        
        // if ($get_permission_data->editperm != '') {
        //     $edit_perm = $get_permission_data->editperm;
        //     $edit_perm = explode(',', $edit_perm);
        // }    
        $roleIds = explode(',', $get_user_data->role_id);

			$edit_perm = [];

			foreach ($roleIds as $roleId) {
				$roleId = trim($roleId); // Clean any spaces
				
				$get_permission_data = Helper::get_permission_data($roleId);

				if (
					is_object($get_permission_data) &&
					property_exists($get_permission_data, 'editperm') &&
					$get_permission_data->editperm != ''
				) {
					$perms = explode(',', $get_permission_data->editperm);
					$edit_perm = array_merge($edit_perm, $perms); // Combine permissions
				}
			}

			// Optional: remove duplicates and reset array keys
			$edit_perm = array_values(array_unique($edit_perm));
   
    @endphp
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Sales Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ul>
                </div>
                @if (in_array('22', $edit_perm))
                    <!-- <div class="col-auto">
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div> -->
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
                                            <th>User Name</th>
                                            <th>Amount</th>
                                            <th>Payment Mode</th>
                                            <th>Payment Status</th>
                                            <th>Payment Id</th>
                                            {{-- <th>Order Status</th>
                                            <th>Create Shipment</th>
                                            <th>Schedule Pickup </th>
                                            <th>Label</th>
                                            <th>Track Order</th> --}}
                                            
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            //  echo "<pre>";print_r($orders_list);echo"</pre>";exit;
                                             if (isset($orders_list) and count($orders_list)) {
                                                foreach ($orders_list as $key => $orders) {
                                        @endphp
                                        
                                            <tr>
                                                <!-- <td></td> -->
                                                <td style="display: none">{{ $i }}</td>
                                                <td>{{$orders->order_id}}</td>
                                                <td>
                                                    @php
                                                    $order_date = strtotime( $orders->created_at);
                                                     echo $mysqldate = date( 'F d, Y', $order_date );
                                                    @endphp
                                                </td>
                                                <td>{{$orders->user_name}}</td>
                                                <td>{{number_format($orders->order_total);}}</td>
                                                <td>
                                                    @if ($orders->paymentmode == '1')
                                                        Cash On Delivery
                                                    @elseif ($orders->paymentmode == '2')
                                                        Online Payment
                                                    @endif
                                                </td>
                                                <td>{{$orders->payment_status}}</td>
                                                <td>
                                                    @if($orders->payment_id != '')
                                                        {{$orders->payment_id}}
                                                    @else
                                                        {{'-'}}
                                                    @endif
                                                </td>
                                                {{--<td>
                                                    @if ($orders->order_status === 'P')
                                                        Pending
                                                    @elseif ($orders->order_status === 'K')
                                                        Packed
                                                    @elseif ($orders->order_status === 'R')
                                                        Processing
                                                    @elseif ($orders->order_status === 'S')
                                                        Shipped
                                                    @elseif ($orders->order_status === 'O')
                                                        Out For Delivery
                                                    @elseif ($orders->order_status === 'D')
                                                        Delivered
                                                    @else
                                                        Canceled
                                                    @endif
                                                </td>
                                                 <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td> --}}
                                                
														   
														   
                                                <td class="text-right">
                                                    <a class="btn btn-primary" href="{{ route('details', [$orders->order_id]) }}"><i class="far fa-eye me-2"></i>Details</a>
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
<!-- Assign Vendor  Modal -->
<div class="modal custom-modal fade" id="assign_vendor_model" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="order_vendor_form" action="{{ url('order_vendor_form') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                
                <div class="modal-text text-center">
                    <!-- <h3>Delete Expense Category</h3> -->
                    <!-- <p>Select Vendor</p> -->
                </div>
                <div class="modal-text text-center" id="dropdownreplace">
                </div>
                <p class="form-error-text" id="vendor_id_error" style="color: red; margin-top: 10px;"></p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="form_sub_vendor();">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
   <div class="modal custom-modal fade" id="set_order_model" role="dialog">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-body">
                   <div class="modal-text text-center">
                       <h3>Are you sure you want to Change Percentage</h3>
                       <input type="hidden" name="percentage" id="percentage" value="">
                       <input type="hidden" name="order_id" id="order_id" value="">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                       <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>
                   </div>
               </div>
           </div>
       </div>
   </div>
<!-- /Assign Vendor Modal -->
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
    function form_sub_vendor() {
        var vendor_id = jQuery("#vendor_id").val();
            if (vendor_id == '') {
                jQuery('#vendor_id_error').html("Please Select Vendor");
                jQuery('#vendor_id_error').show().delay(0).fadeIn('show');
                jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');
                
                return false;
            }
        $('#order_vendor_form').submit();
    }
    function assign_vendor(order_id){
        var url = '{{ url('assign_vendor') }}';
        $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": order_id
                },
                success: function(msg) {
                    document.getElementById('dropdownreplace').innerHTML = msg;
                    $('#assign_vendor_model').modal('show');
                    
                }
        });
    }
	
	function updateorder_booking_percentage(val, id) {
           $('#percentage').val(val);
           $('#order_id').val(id);
           $('#set_order_model').modal('show');
       }
	   
	   function updateorder() {
           var percentage = $('#percentage').val();
           var order_id = $('#order_id').val();
           $.ajax({
               type: "POST",
               url: "{{ url('set_booking_percentage') }}",
               data: {
                   "_token": "{{ csrf_token() }}",
                   "order_id": order_id,
                   "percentage": percentage
               },
               success: function(returnedData) {
                   // alert(returnedData);
                   if (returnedData == 1) {
                       //alert('yes');
                       $('#success_message').text("Booking Percentage Updated successfully");
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
    $(document).ready(function() {
        // Check if the DataTable instance already exists
        if ($.fn.DataTable.isDataTable('#example')) {
            // Destroy the existing DataTable before reinitializing
            $('#example').DataTable().destroy();
        }
        // Initialize DataTable with the new options
        $('#example').dataTable({
            "searching": true
        });
    });
</script>
@stop
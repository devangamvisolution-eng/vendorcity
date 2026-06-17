@extends('admin.includes.Template')

@section('content')

    @php

        $userId = Auth::id();       

        // 
        $get_user_data = Helper::get_user_data($userId);       

        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);       

        // $edit_perm = [];        

        // if ($get_permission_data->editperm != '') {

        //     $edit_perm = $get_permission_data->editperm;

        //     $edit_perm = explode(',', $edit_perm);

        // }       

        $user_data = Auth::user();
        // echo"<pre>";print_r($user_data);echo"</pre>";exit;

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

                    <h3 class="page-title">Crew Report</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Crew Report</li>

                    </ul>

                </div>



                @if (in_array('37', $edit_perm))

                    <div class="col-auto">

                    @if($filter_cleaner_id !="")
                    <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel Download</a>
                    @endif

                        <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
                        </a>
    



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

        <form method="GET" action="{{ url('filter_data_cleaner') }}" id="filter_data">

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_cleaner_id_fil" id="filter_cleaner_id_fil" value="{{ $filter_cleaner_id ?: '' }}">
          
        </form>


    @php

        if(!empty($startdate) || !empty($enddate) || !empty($filter_cleaner_id) ){
            $css = "display:block;";
        }else{
            $css = "display:none;";
        }

    @endphp 

        <div id="filter_inputs" class="card filter-card" style="{{ $css }}">

            <div class="card-body pb-0">
             <form id="filter_form" action="{{ route('cleaner-report') }}" method="POST">
                 @csrf
                 <input type="hidden" name="action" value="filter">
     
                <div class="row">
     
                    <div class="col-sm-6 col-md-8">
                     <div class="row">
     
                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Start Date</label>
                                 <input type="date" class="form-control" name="s_date" id="s_date" placeholder="Enter Start Date" value="{{ $startdate }}" >
                             </div>
                         </div>
     
                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>End Date</label>
                                 <input type="date" class="form-control" name="e_date" id="e_date" placeholder="Enter End Date" value="{{ $enddate }}">
                             </div>
                         </div>
                                           
                         {{-- <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Select Service</label>
                                 <select name="servicename" class="form-control form-select"  id="servicename">
                                     <option value="">Select Service</option>
                                     @foreach ($service_data as $service_data_new)
                                         <option value="{{ $service_data_new->id }}"
                                             @if ($service_data_new->id == $filter_service_id) {{ 'selected' }} @endif>
                                             {{ $service_data_new->servicename }}</option>
                                     @endforeach
                                 </select>
                                 <p class="form-error-text" id="servicename_error"
                                 style="color: red; margin-top: 10px;"></p>
                             </div>
                         </div> --}}
     
                    @php
                    
                        if($user_data->role_id == 16){
                            $style = "display:none;";
                        }else{
                            $style = "display:block;";
                        }
                    @endphp
                         
                         <div class="col-lg-4" style="{{ $style }}">
                             <div class="form-group">
                                 <label>Select Crew</label>
                                 <select name="cleaner_name" class="form-control form-select"  id="cleaner_name">
                                     <option value="">Select Crew</option>

                                     @foreach($cleaner_data as $data)
                                     @if ($data->id != 2)
                                    <option value="{{ $data->id }}" @if ($data->id == $filter_cleaner_id ) {{ 'selected' }} @endif>
                                     {{ $data->name }}</option>
                                     @endif
                                     @endforeach
                                 </select>
                                 <p class="form-error-text" id="cleaner_name_error"
                                 style="color: red; margin-top: 10px;"></p>
                             </div>
                         </div>
                    </div>
                    </div>
                    <div class="col-sm-3 col-md-4">
                     <div class="form-group">
                         <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;" onclick="filter_validation()">Submit</a>
     
                         <a class="btn btn-primary filter-btn" href="{{ route('cleaner-report') }}" style="margin-top: 22px;">Reset</a>
                         </div>
                    </div>
                </div>
             </form>
            </div>
     
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
                                            <th>Date</th>
                                            <th>Starting Time</th>
                                            <th>Ending Time</th>
                                            <th>Sales Person</th>
                                            <th>Customer Name</th>
                                            <th>Contact No.</th>
                                            <th>Address</th>
                                            <th>Cleaners</th>
                                            <th>Type of Job</th>
                                            <th>Vendor Name</th>
                                            <th>Total Amount</th>
                                            <th>Duration</th> 
                                            <th>Status</th> 
                                            <th>Remarks</th> 
                                            <th>Client Review</th> 
                                            <th>Payment Status</th>

                                           

                                        </tr>

                                    </thead>

                                    <tbody>

                            @if($filter_cleaner_id !="")
                                    @php
                                        $i=1;
                                    @endphp
                                @foreach($cleaner_order_data as $data)


                                @php
                                // echo"<pre>";print_r($data);echo"</pre>";exit;
                            
                                    $user_data = DB::table('frontloginregisters')->where('id',$data->user_info_id)->first();

                                    $order_data = DB::table('ci_orders')->where('order_id',$data->order_id)->first();
                                @endphp
                                        <tr>
                                            <td>{{ $order_data->format_order_id }}</td>
                                            <td>{{ $data->cdate }}</td>

                                    <td>{!! Helper::timeslotname($data->time_slot) !!}</td>
                                            
                                    @php
                                                
                                   if($data->subservice_id == 28){
                                    $hours = $data->how_many_hours_should_they_stay;

                                    if ($hours) {
                                        // Calculate the target end time
                                        $target_end_time =$data->time_slot + $hours;

                                        // Find the corresponding time slot that matches the calculated ending time
                                        $next_slot = DB::table('time_slots')
                                                    ->where('id',$target_end_time)
                                                    ->first();
                                    }
                                   }
                                    @endphp
                                    
                                        @if($data->subservice_id == 28)
                                            <td>{{ $next_slot->name }}</td>
                                        @else
                                            <td>-</td>
                                        @endif

                                        {{-- Sales Person --}}

                                        <td>
                                            @if($data->salesperson_id != "" && $data->salesperson_id != null)
                                            {!! Helper::salesperson($data->salesperson_id) !!}
                                            @else 
                                            -
                                            @endif
                                        </td>


                                            <td>{{ $user_data->name }}</td>

                                            <td>{{ $user_data->mobile }}</td>

                                            <td>{{ $data->apartment_villa_no }},{{ $data->building_street_no }},{{ $data->area }},{{ $data->city }}</td>

                                            <td>
                                                @php
                                                    $cleaner_Id = explode(",",$data->cleaner_id);
                                                @endphp
                                                {!! Helper::cleanername_new($cleaner_Id) !!}
                                            </td>

                                            <td>
                                                {!! Helper::subservicename($data->subservice_id) !!}
                                            </td>
                                           
                                            <td>
                                                @if($order_data->vendor_id != "" && $order_data->vendor_id != 0)
                                                {!! Helper::vendorsname($order_data->vendor_id) !!}
                                                @else
                                                -
                                                @endif
                                            </td>

                                            <td>
                                        @if($data->subservice_id == 28)

                                            @php
                                            $service_charge = $order_data->service_charge ?? 0;
                                            $no_of_cleaners = $data->how_many_cleaners_do_you_need ?? 0;

                                            $cleaner_price = $service_charge / $no_of_cleaners;
                                            @endphp

                                            {{ $cleaner_price  }}
                                              </td>
                                        @else

                                            @if($data->cleaner_price != "")
                                            {{ $data->cleaner_price }}
                                            @else
                                            -
                                            @endif

                                        @endif
                                            </td>

                                            {{--For  Duration --}}

                                             @if($data->subservice_id == 28)
                                            <td>{{ $hours }}</td>
                                            @else
                                                <td>-</td>
                                            @endif

                                            <td>
                                            @if($order_data->order_status == "CO")
                                                Completed
                                            @elseif($order_data->order_status == "P")
                                                Pending
                                            @else
                                                Cancelled
                                            @endif
                                            </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td>
                                                @if($order_data->payment_status == "Success")
                                                Success
                                                @else
                                                Failed
                                                @endif
                                            </td>


                                        </tr>
                                @endforeach

                                @php
                                    $i++;
                                @endphp

                            @endif
                                       
                                        





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

    function excel_download() {
            $('#filter_data').submit();
        }

    function filter_validation(){
                
        var cleaner_name = jQuery("#cleaner_name").val();

        if (cleaner_name == '') {
            jQuery('#cleaner_name_error').html("Please Select Cleaner");
            jQuery('#cleaner_name_error').show().delay(0).fadeIn('show');
            jQuery('#cleaner_name_error').show().delay(2000).fadeOut('show');
            $('html, body').animate({
                scrollTop: $('#cleaner_name').offset().top - 150
            }, 1000);
            return false;
        }

        $('#filter_form').submit();
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
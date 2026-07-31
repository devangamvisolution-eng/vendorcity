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

         $userdata = Auth::user();
    @endphp
    <style>
        .premium-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            background: #fff;
            margin-bottom: 24px;
        }
        .premium-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        .premium-table thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eef2f5;
            padding: 16px;
            white-space: nowrap;
        }
        .premium-table tbody td {
            padding: 16px;
            vertical-align: middle;
            color: #555;
            border-bottom: 1px solid #f1f3f5;
            font-size: 14px;
        }
        .premium-table tbody tr {
            transition: all 0.2s ease;
        }
        .premium-table tbody tr:hover {
            background-color: #fcfcfc;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        .badge-status {
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
            text-align: center;
        }
        .badge-completed { background-color: #e6f6ec; color: #2e8b57; }
        .badge-pending { background-color: #fff8e5; color: #d4a305; }
        .badge-cancelled { background-color: #fdeded; color: #c0392b; }
        
        .filter-card {
            border-radius: 12px;
            border: 1px solid #eef2f5;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            background: #fafbfc;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
        }
        .btn-premium {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
        }
        .page-title {
            font-weight: 700;
            color: #2c3e50;
            font-size: 24px;
        }
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Day Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Day Report</li> 
                    </ul>
                </div>

                {{-- @if (in_array('50', $edit_perm)) --}}

                
                   
                

                    <div class="col-auto">

                    <a class="btn btn-primary btn-premium me-1" href="javascript:void('0');" onclick="excel_download();"><i class="fas fa-file-excel"></i> Excel Download</a>
                    </div>
        
                {{-- @endif --}}
            </div>
        </div>

       

        <form method="GET" action="{{ url('filter_day_report_data') }}" id="filter_data">

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_service_id_fil" id="filter_service_id_fil" value="{{ $filter_service_id ?: '' }}">
          
            <input type="hidden" name="filter_salesperson_id_fil" id="filter_salesperson_id_fil" value="{{ $filter_salesperson_id ?: '' }}">
          
        </form>
        <div id="filter_inputs" class="card filter-card" style="display: block !important;">

            <div class="card-body pb-0">
             <form id="filter_form" action="{{ route('day-report-filter') }}" method="POST">
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
                                           
                         <div class="col-lg-4">
                             <div class="form-group">
                                 <label>Select Service</label>
                                 <select name="servicename" class="form-control form-select"  id="servicename">
                                     <option value="">Select Service</option>
                                     @foreach ($service_data as $service_data_new)
                                         <option value="{{ $service_data_new->id }}"
                                             @if($service_data_new->id == $filter_service_id){{ 'selected' }} @endif>
                                             {{ $service_data_new->servicename }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
                    @php
                        if($userdata->role_id != 1){
                            $style = "display:none;";
                        }else{
                            $style = "display:block;";
                        }
                    @endphp
                         <div class="col-lg-4" style="{{ $style }}">
                             <div class="form-group">
                                 <label>Select SalesPerson</label>
                                 <select name="salesperson_id" class="form-control form-select"  id="salesperson_id">
                                     <option value="">Select SalesPerson</option>
                                     @foreach ($user_data as $user_data_new)
                                         <option value="{{ $user_data_new->id }}"
                                             @if ($user_data_new->id == $filter_salesperson_id) {{ 'selected' }} @endif>
                                             {{ $user_data_new->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>
     
                    </div>
                    </div>
                    <div class="col-sm-3 col-md-4">
                         <a class="btn btn-primary btn-premium filter-btn" href="javascript:void(0);" style="margin-top: 22px;" onclick="filter_validation()">Submit</a>
     
                         <a class="btn btn-secondary btn-premium filter-btn" href="{{ url('admin/day-report') }}" style="margin-top: 22px; background: #6c757d; color: white;">Reset</a>
                         </div>
                    </div>
                </div>
             </form>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="card premium-card">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_order') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table premium-table datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <!-- <th>select</th> -->
                                            <th style="display: none">Sr no</th>
                                            <th>Order Id</th>
                                            <th>Order Date</th>
                                            <th>Service</th>
                                            <th>Vendor Name</th>
                                            <th>Crew Name</th>
                                            <th>Salesperson Name</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Mobile</th>
                                            <th>User Address</th>
                                            <th>Time Slot</th>
                                            <th>Amount</th>
                                            <th>Order Status</th>
                                            <th>Payment Mode</th>
                                            <th>Payment Id</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            // echo"<pre>";print_r($orders_list);echo"</pre>";exit;
                                             
                                             if (isset($orders_list) && count($orders_list)) {
                                                foreach ($orders_list as $key => $orders) {

                                        //    echo "<pre>";print_r($orders->items);echo"</pre>";
                                        @endphp
                                        
                                        @if(!empty($orders->items))
                                            <tr>
                                                <!-- <td></td> -->
                                                <td style="display: none">{{ $i }}</td>
                                                <td>{{$orders->format_order_id}}</td>
                                                <td>
                                                    @php
                                                    $order_date = strtotime( $orders->created_at);
                                                     echo $mysqldate = date( 'F d, Y', $order_date );
                                                    @endphp
                                                </td>

                                                <td>
                                                    {!! isset($orders->items[0]->service_id) ? Helper::servicename($orders->items[0]->service_id) : '-' !!}
                                                </td>

                                                <td>
                                                    @if($orders->vendor_id != 0 && $orders->vendor_id != '')
                                                        {!! Helper::vendorsname($orders->vendor_id) !!}
                                                    @else   
                                                        {{ '-' }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @php
                                                        $cleaner_Id = explode(",",$orders->items[0]->cleaner_id);
                                                    @endphp
                                                   @if(isset($cleaner_Id) && count($cleaner_Id) > 0)
                                                    {!! Helper::cleanername_new($cleaner_Id) !!}
                                                    @else   
                                                    {{ '-' }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($orders->items[0]->salesperson_id != 0 && $orders->items[0]->salesperson_id != '')
                                                        {!! Helper::salesperson($orders->items[0]->salesperson_id) !!}
                                                    @else   
                                                        {{ '-' }}
                                                    @endif
                                                </td>

                                                <td>{{$orders->user_name}}</td>

                                                <td>{{$orders->user_email}}</td>
                                                
                                                <td>{{$orders->user_mobile}}</td>


                                                <td>{{ $orders->items[0]->building_street_no }},{{ $orders->items[0]->apartment_villa_no }},{{ $orders->items[0]->area }},{{$orders->items[0]->city}}</td>

                                                <td>{!! Helper::timeslotname($orders->items[0]->time_slot) !!}</td>
                                                <td>{{$orders->order_total}}</td>

                                                
                                                <td>
                                                @if($orders->order_status === 'P')
                                                     <span class="badge-status badge-pending">Pending</span>
                                                @elseif ($orders->order_status == 'CO')
                                                    <span class="badge-status badge-completed">Completed</span>
                                                @elseif ($orders->order_status == 'CL')
                                                    <span class="badge-status badge-cancelled">Cancelled</span>
                                                @endif
                                                </td>

                                                <td>
                                                    @if ($orders->paymentmode == '1')
                                                        Cash On Delivery
                                                    @elseif ($orders->paymentmode == '2')
                                                        Online Payment
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($orders->payment_id != '')
                                                        {{$orders->payment_id}}
                                                    @else
                                                        {{'-'}}
                                                    @endif
                                                </td>

                                            </tr>
                                            @endif
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


<script>
    $(document).ready(function() {
        // Check if the DataTable instance already exists
        if ($.fn.DataTable.isDataTable('#example')) {
            // Destroy the existing DataTable before reinitializing
            $('#example').DataTable().destroy();
        }
        // Initialize DataTable with the new options
        $('#example').dataTable({
            "searching": true,
            "paging": true,
        });
    });

    function filter_validation(){

        $('#filter_form').submit();
    }

    function excel_download() {
            $('#filter_data').submit();
        }

    </script>

@stop
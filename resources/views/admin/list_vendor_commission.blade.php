@extends('admin.includes.Template')

@section('content')
<style>
    #second_table{
        border: 1px solid #000;
        margin-top: 60px;
    }
    #second_table tr td{
        border: 1px solid #000;
    }
</style>

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

        //echo"<pre>";print_r($userdata->role_id);echo"</pre>";

    @endphp

    <style>
        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
    </style>

    <div class="content container-fluid">





        <!-- Page Header -->

        <div class="page-header">

            <div class="row align-items-center">

                <div class="col">

                    <h3 class="page-title">Vendor Commission Report</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Vendor Commission Report</li>

                    </ul>

                </div>

                <div class="col-auto">
                    @if($filter_vendor_id !="")
                    <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel Download</a>
                    @endif
                    
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>


                    
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

        <form method="GET" action="{{ url('filter_data_vendor') }}" id="filter_data">

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_vendor_id_fil" id="filter_service_id_fil" value="{{ $filter_vendor_id ?: '' }}">

            <input type="hidden" name="filter_service_id_fil" id="filter_service_id_fil" value="{{ $filter_service_id ?: '' }}">

        </form>

    @php

        if(!empty($startdate) || !empty($enddate) || !empty($filter_vendor_id) || !empty($filter_service_id) ){
            $css = "display:block;";
        }else{
            $css = "display:none;";
        }

    @endphp 

   <!-- Search Filter -->

   <div id="filter_inputs" class="card filter-card" style="{{ $css }}">

       <div class="card-body pb-0">
        <form id="filter_form" action="{{ route('vendors-filter') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="filter">

           <div class="row">

               <div class="col-sm-6 col-md-8">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" class="form-control" name="s_date" id="s_date" placeholder="Enter Start Date"
                                value="{{ $startdate ?: '' }}">
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="date" class="form-control" name="e_date" id="e_date" placeholder="Enter End Date"
                                value="{{ $enddate ?: '' }}">
                        </div>
                    </div>
                                      
                    <div class="col-lg-4">
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
                    </div>

                    @php
                        if($userdata->role_id != 1){
                            $style = "display:none;";
                        }else{
                            $style = "display:block;";
                        }
                    @endphp
                    <div class="col-lg-4" style="{{$style}}">
                        <div class="form-group">
                            <label>Select Vendor</label>
                            <select name="vendorname" class="form-control form-select"  id="vendorname">
                                <option value="">Select Vendor</option>
                                
                                @foreach ($vendor_data as $vendor_data_new)
                                    <option value="{{ $vendor_data_new->id }}"
                                        @if ($vendor_data_new->id == $filter_vendor_id || $vendor_data_new->id == $userId) {{ 'selected' }} @endif>
                                        {{ $vendor_data_new->name }}</option>
                                @endforeach
                            </select>
                            <p class="form-error-text" id="vendorname_error"
                            style="color: red; margin-top: 10px;"></p>
                        </div>
                    </div>
               </div>
               </div>
               <div class="col-sm-3 col-md-4">
                <div class="form-group">
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;" onclick="filter_validation()">Submit</a>

                    <a class="btn btn-primary filter-btn" href="{{ route('vendor-commission-report') }}" style="margin-top: 22px;">Reset</a>
                    </div>
               </div>
           </div>
        </form>
       </div>

   </div>

        @php
           // echo "<pre>";print_r($packages_data);echo"</pre>";
        @endphp

        <div class="row">

            <div class="col-sm-12">

                <div class="card card-table">

                    <div class="card-body">

                        <form id="form" action="{{-- route('delete_price') --}}" enctype="multipart/form-data">

                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

                            @csrf

                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">

                                    <thead class="thead-light">

                                        <tr>
                                            <th style="display: none">>Sr No</th>
                                            <th>Order Id</th>
                                            <th>Service Name</th>
                                            <th>Added Date</th>
                                            <th>Order Date</th>
                                            <th>Vendor Name</th>
                                            <th>Payment Mode</th>
                                            <th>Received By</th>
                                            <th>Total Amount (Incl. VAT)</th>
                                            <th>Amount (Without VAT)</th>
                                            <th>Add Amount</th>
                                            <th>Commission % (VC)</th>
                                            <th>Commission (VC)</th>
                                            <th>CC Fee</th>
                                            <th>Commission + CC Charges</th>
                                            {{-- <th>Commission Amount</th> --}}
                                            {{-- <th>Amount to Vendor</th> --}}
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @php
                                         $total_commission_amount = 0;
                                         $total_amount = 0;
                                         $vc_commission = 0;
                                         $vc_received = 0;
                                         $vendor_received=0;
                                         $vendor_total = 0;
                                         $vat_on_sum_charge = 0;
                                         $displayedOrderIds = [];

                                         $i = 1;

                                         $commission_cc_charge = 0;

                                        @endphp

                                        @if($filter_vendor_id !="")
                                        @foreach($package_order_amount_attr as $data)

                                        @php
                                        $showRow = !in_array($data->order_id, $displayedOrderIds);
                                        if ($showRow) {
                                            $displayedOrderIds[] = $data->order_id;
                                        }
                                        @endphp
                                        
                                        @if($data->collect_by == "Vendorscity")
                                        @php
                                            $vc_received += $data->add_amount;
                                        @endphp
                                        @endif
                                        @if($data->collect_by == "Vendor")
                                        @php
                                            $vendor_received += $data->add_amount;
                                        @endphp
                                        @endif

                                    <tr>
                                        <td style="display: none">{{ $i }}</td>
                                        <td>
                                            {{$data->order_id}}
                                        </td>
                                        <td>
                                            {!! Helper::servicename($data->service_id)  !!}
                                        </td>
                                        <td>
                                            {{$data->date}}
                                        </td>
                                        <td>
                                            {{$data->order_date}}
                                        </td>
                                        <td>
                                        {!! Helper::vendorsname($data->vendor_id) !!}
                                        </td>
                                        <td>
                                            {{$data->payment_type}}
                                        </td>
                                        <td>
                                            {{$data->collect_by}}
                                        </td>
                                     
                                        <td>@if ($showRow)
                                            @php
                                                    $data->order_total = $data->order_total;
                                                @endphp
                                            @else
                                            @php
                                                $data->order_total = 0;
                                            @endphp
                                            @endif
                                            {{ $data->order_total }}
                                        </td>
                                        @php
                                            $amount_without_vat = $data->order_total - $data->vatcharge;
                                        @endphp
                                        <td>
                                            @if ($showRow)
                                                @php
                                                    $amount_without_vat = $amount_without_vat;
                                                @endphp
                                            @else
                                                @php
                                                $amount_without_vat = 0;
                                                @endphp
                                            @endif

                                            {{$amount_without_vat}}
                                            </td><!-- Amount with out VAT  -->
                                        <td>
                                            {{$data->add_amount}} <!--Add amount-->
                                        </td>   
                                        <td>
                                            {{$data->booking_percentage}}
                                        </td>
                                       
                                      

                                        @php
                                            $commission_amount = $amount_without_vat * $data->booking_percentage /100;

                                            $amount_to_vendor = $data->add_amount - $commission_amount;

                                            if($data->payment_type == "Online"){
                                                $cc_fee = $data->add_amount * 2.625/100;
                                            }else{
                                                $cc_fee = '0';
                                            }

                                            $commission_cc_charge = $commission_amount + $cc_fee;

                                            $total_commission_amount += $commission_cc_charge;

                                            $vat_on_sum_charge = $total_commission_amount * 5/100;

                                            $vc_commission = $total_commission_amount + $vat_on_sum_charge;

                                            $total_amount += $data->order_total;

                                            $vendor_total = $total_amount - $vc_commission;
                                        @endphp

                                        <td>@if ($showRow)
                                            {{$commission_amount}}
                                            @else{{'-'}}
                                            @endif
                                            </td>
                                        <td>{{$cc_fee}}</td>
                                        <td>{{$commission_cc_charge}}</td>
                                        {{-- <td>{{$amount_to_vendor}}</td> --}}
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                                @endif
                        </tbody>

                    </table>

                </div>

            </form>
                        @if($filter_vendor_id !="")
                        <div class="table-responsive">
                        <table class="table"  style="width: 50%;" id="second_table">
                            @php
                            $amount_without_commission = $total_amount - $vc_commission;

                            $paid_to_vendor = $vendor_total - $vendor_received;
                            @endphp
                            <tr>
                                <td colspan="2" style="text-align: center;">Summary</td></tr>
                            <tr>
                                <td>Vat on Sum of charges</td>
                                <td>{{$vat_on_sum_charge}}</td>
                            </tr>
                            <tr>
                                <td>Total VC Commision</td>
                                <td>{{$vc_commission}}</td>
                            </tr>
                            <tr>
                                <td>Vendors Total</td>
                                <td>{{$vendor_total}}</td>
                            </tr>
                            <tr>
                                <td>Vendor Received</td>
                                <td>{{$vendor_received}}</td>
                            </tr>
                            <tr>
                                <td>Paid to Vendor</td>
                                <td>{{$paid_to_vendor}}</td>
                            </tr>
                            
                        </table>
                        </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
@stop
@section('footer_js')

    <!-- Delete  Modal -->
    



    <script>
         function excel_download() {
            $('#filter_data').submit();
        }
        function delete_category(id) {

            // alert(id);

            $('#delete_model_' + id).modal('show');


        }
        function filter_validation(){
                
                var vendorname = jQuery("#vendorname").val();

                if (vendorname == '') {
                    jQuery('#vendorname_error').html("Please Select Vendor");
                    jQuery('#vendorname_error').show().delay(0).fadeIn('show');
                    jQuery('#vendorname_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#vendorname').offset().top - 150
                    }, 1000);
                    return false;
                }

                $('#filter_form').submit();
            }
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
        function agent_detail(inquiry_id) {
            $('#show_comment_model_'+ inquiry_id).modal('show');
            }
    </script>

@stop

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

                    <h3 class="page-title">Vendor Subscription Report</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Vendor Subscription Report</li>

                    </ul>

                </div>

                <div class="col-auto">
                    @if($filter_vendor_id !="")
                    @if(count($package_accept_inquiry) > 0)
                    <a class="btn btn-primary me-1" href="javascript:void('0');" onclick="excel_download();">Excel Download</a>
                    @endif
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

        <form method="GET" action="{{ url('filter_vendorsubscriptionreport') }}" id="filter_data">
            @csrf
            <input type="hidden" name="action" value="filtersubscription" >

            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">

            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">

            <input type="hidden" name="filter_vendor_id_fil" id="filter_service_id_fil" value="{{ $filter_vendor_id ?: '' }}">
            <input type="hidden" name="filter_vendorsubscriptionid" id="filter_vendorsubscriptionid" value="{{ $filter_vendorsubscriptionid ?: '' }}">

            

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
        <form id="filter_form" action="{{ route('vendorsubscriptionreport') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="filtersubscription" >

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
                                      
                    

                    @php
                        if($userdata->role_id !=1){
                            $style = "display:none;";
                        }else{
                            $style = "display:block;";
                        }
                    @endphp
                    <div class="col-lg-4" style="{{$style}}">
                        <div class="form-group">
                            <label>Select Vendor</label>
                            <select name="vendorname" class="form-control form-select"  id="vendorname" onchange="subscription_change(this.value);">
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

                    <div class="col-lg-5" >
                        <div class="form-group">
                            <label>Select Subscription</label>
                            <span id="subscription_change">
                            <select name="vendorsubscription" class="form-control form-select"  id="vendorsubscription">
                                <option value="">Select Subscription</option>
                                @if(count($vendor_subscription) > 0)
                                @foreach ($vendor_subscription as $subscription_data_new)
                                <option value="{{ $subscription_data_new->id }}"
                                    @if ($subscription_data_new->id == $filter_vendorsubscriptionid || $subscription_data_new->
                                    id == $userId) {{ 'selected' }} @endif>
                                    {{ $subscription_data_new->subscription_name." - ". $subscription_data_new->id }}</option>
                                    @endforeach
                                    @endif

                            </select>
                            </span>
                            <p class="form-error-text" id="vendorsubscription_error"
                            style="color: red; margin-top: 10px;"></p>
                        </div>
                    </div>
               </div>
               </div>
               <div class="col-sm-3 col-md-4">
                <div class="form-group">
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" style="margin-top: 22px;" onclick="filter_validation()">Submit</a>

                    <a class="btn btn-primary filter-btn" href="{{ route('vendorsubscriptionreport') }}" style="margin-top: 22px;">Reset</a>
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
                                            <th>Vendor Name</th>
                                            <th>Inquiry Id</th>
                                            <th>Accepted Date</th>
                                            <th>Name</th>
                                            <th>Service</th>
                                            <th>Sub Service</th>
                                            <th>Lead Amount</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        
                                        @if($filter_vendor_id !="")
                                        @php
                                        $i=1;
                                    @endphp
                                        @foreach($package_accept_inquiry as $data)

                                        

                                    <tr>
                                        <td style="display: none">{{ $i }}</td>
                                       
                                        <td> {!! Helper::vendorsname($data->vendor_id) !!}</td>
                                        <td>{{ $data->inq_idformat }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->added_date))}}</td>
                                        <td>{{ $data->inq_name }}</td>
                                        <td>
                                            @if ($data->service_id ?? '')
                                                {!! Helper::servicename(strval($data->service_id)) !!}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->subservice_id ?? '')
                                                {!! Helper::subservicename(strval($data->subservice_id)) !!}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                if(isset($data->price_of_lead) && !empty(isset($data->price_of_lead))){
                                                    $price_of_lead = $data->price_of_lead;
                                                }else{

                                                    $price_of_lead = $data->subscription_price_package / $data->subscription_no_of_inquiry_package ;
                                                }
                                            @endphp
                                            
                                            {{ $price_of_lead }}
                                        </td>
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
                        @if(count($package_accept_inquiry) > 0)
                        @if($package_accept_inquiry[0]->subscription_type_of_subscription == 0 || $package_accept_inquiry[0]->subscription_type_of_subscription == 2)
                        <div class="table-responsive">
                        <table class="table"  style="width: 50%;" id="second_table">
                            
                            <tr>
                                <td colspan="2" style="text-align: center;">{{ $package_accept_inquiry[0]->subscription_name }}</td></tr>
                                @if($package_accept_inquiry[0]->subscription_type_of_subscription == 0 || $package_accept_inquiry[0]->subscription_type_of_subscription == 2)
                                <tr>
                                    <td>Package Price</td>
                                    <td>{{ $package_accept_inquiry[0]->subscription_price_package }}</td>
                                </tr>
                                @endif
                                <tr>
                                <td>Total Inquiry</td>
                                <td>

                                    @php
                                                        

                                    if($package_accept_inquiry[0]->subscription_type_of_subscription == 0 || $package_accept_inquiry[0]->subscription_type_of_subscription == 2){
                                        $totalInquiry = $package_accept_inquiry[0]->subscription_no_of_inquiry_package;
                                    }else{
                                        $totalInquiry = '0';
                                    }
                                @endphp
                                    
                                    {{ $totalInquiry }}
                                </td>
                            </tr>
                            <tr>
                                <td>Accepted Inquiry</td>
                                <td>

                                    @php
                                                    

                                        // if($package_accept_inquiry[0]->subscription_type_of_subscription == 0 || $package_accept_inquiry[0]->subscription_type_of_subscription == 2){                                            
                                            $acceptInquiry = count($package_accept_inquiry);
                                        // }else{
                                        //     $acceptInquiry = '0';
                                        // }
                                    @endphp

                                    {{ $acceptInquiry }}
                                    
                                    </td>
                            </tr>
                            <tr>
                                <td>Pending Inquiry</td>
                                <td>
                                    @php
                                                
                                                $pendingInquiry = $totalInquiry - $acceptInquiry;

                                            @endphp
                                            {{ $pendingInquiry }}
                                </td>
                            </tr>
                            <tr>
                                <td>Amount Spend</td>
                                <td>
                                    @php

                                        if($package_accept_inquiry[0]->subscription_type_of_subscription == 0 || $package_accept_inquiry[0]->subscription_type_of_subscription == 2){                                            
                                            $amountSpend = $package_accept_inquiry[0]->subscription_price_package / $package_accept_inquiry[0]->subscription_no_of_inquiry_package * count($package_accept_inquiry);
                                        }else{
                                            $amountSpend = '0';
                                        }

                                    @endphp
                                            {{ $amountSpend }}
                                </td>
                            </tr>

                            <tr>
                                <td>Current Wallet Amount</td>
                                <td>
                                    @php

                                     $userwallet = DB::table('users')->where('id',$package_accept_inquiry[0]->vendor_id)->value('wallet_amount');   

                                    @endphp
                                            {{ $userwallet }}
                                </td>
                            </tr>
                            
                            
                        </table>
                        </div>

                        @else
                        <div class="table-responsive">
                            <table class="table"  style="width: 50%;" id="second_table">
                                
                              
                                <tr>
                                    <td>Accepted Inquiry</td>
                                    <td>
    
                                        @php
                                                        
    
                                            // if($package_accept_inquiry[0]->subscription_type_of_subscription == 0 || $package_accept_inquiry[0]->subscription_type_of_subscription == 2){                                            
                                                $acceptInquiry = count($package_accept_inquiry);
                                            // }else{
                                            //     $acceptInquiry = '0';
                                            // }
                                        @endphp
    
                                        {{ $acceptInquiry }}
                                        
                                        </td>
                                </tr>
                               
                                <tr>
                                    <td>Amount Spend</td>
                                    <td>
                                        @php
                                        $amountSpend = 0;
                                        foreach($package_accept_inquiry as $package_accept_inquirydata){

                                            $amountSpend += $package_accept_inquirydata->price_of_lead;
                                        }
    
                                            
    
                                        @endphp
                                                {{ $amountSpend }}
                                    </td>
                                </tr>
    
                                <tr>
                                    <td>Current Wallet Amount</td>
                                    <td>
                                        @php
    
                                         $userwallet = DB::table('users')->where('id',$package_accept_inquiry[0]->vendor_id)->value('wallet_amount');   
    
                                        @endphp
                                                {{ $userwallet }}
                                    </td>
                                </tr>
                                
                                
                            </table>
                            </div>

                        @endif


                        @endif
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

            function subscription_change(vendorid){
                // alert(vendorid);

                var url = '{{ url('subscription_change') }}';

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "vendorid": vendorid
                    },
                    success: function(msg) {
                        document.getElementById('subscription_change').innerHTML = msg;
                    }
                });
            }
    </script>

@stop

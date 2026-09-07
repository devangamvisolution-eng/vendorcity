  @extends('admin.includes.Template')
   @section('content')
       <style type="text/css">
           .modal-dialog {
               max-width: 50%
           }
       </style>
       <div class="content container-fluid">
           <div class="success">
               @if ($message = Session::get('login_success'))
                   <div class="alert alert-success alert-dismissible fade show" style="text-align: center;">
                       {{ $message }}
                       <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                   </div>
               @endif
           </div>
           @if ($message = Session::get('success'))
               <div class="alert alert-success alert-dismissible fade show">
                   <strong>Success!</strong> {{ $message }}
                   <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
               </div>
           @endif
           @php
               $subscriber_name = DB::table('users')->where('id', $id)->first();
           @endphp
           <h4>Subscription / {{ $subscriber_name->name }}</h4>
           <div class="row">
               <div class="col-xl-4 col-sm-4 col-12 mt-2">
                   <div class="card">
                       <div class="card-body">
                           <div class="dash-widget-header text-center" style="display:block">
                               <div class="dash-count">
                                   <div class="dash-title"><a href=""
                                           style=" margin-bottom: 25px;display: inline-block;">Total Balance Amount</a>
                                   </div>
                                   <div class="dash-counts mb-2">
                                       <p>{{ $subscriber_name->wallet_amount }}</p>
                                   </div>
                                   <a href="{{ url('vendors_wallet', ['id' => $id]) }}"
                                       class="btn btn-rounded btn-outline-primary">View</a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-xl-4 col-sm-4 col-12 mt-2">
                   <div class="card">
                       <div class="card-body">
                           <div class="dash-widget-header text-center" style="display:block">
                               <div class="dash-count">
                                   <div class="dash-title"><a href="{{ route('base_on_service_lead', ['id' => $id]) }}"
                                           style=" margin-bottom: 25px;display: inline-block;">Based on Services Leads</a>
                                   </div>
                                   <a href="{{ route('base_on_service_lead', ['id' => $id]) }}"
                                       class="btn btn-rounded btn-outline-primary">Buy Now</a>
                                   {{-- <!-- <div class="dash-counts">
                                        <p>This is Box</p>
                                    </div> --> --}}
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               @php
                   $price_data = DB::table('prices')->select('*')->orderBy('id', 'desc')->first();
                   //echo "<pre>";print_r($price_data);echo "</pre>";
               @endphp
               @if ($price_data->based_on_booking_service_price != '')
                   <div class="col-xl-4 col-sm-4 col-12 mt-2" style="display: none">
                       <div class="card">
                           <div class="card-body">
                               <div class="dash-widget-header text-center" style="display:block">
                                   <div class="dash-count">
                                       <div class="dash-title"><a
                                               href="{{ route('based_on_booking_services', ['id' => $id]) }}"
                                               style=" margin-bottom: 25px;display: inline-block;">{{ $price_data->based_on_booking_service_label }}</a>
                                       </div>
                                       <a href="{{ route('based_on_booking_services', ['id' => $id]) }}"
                                           class="btn btn-rounded btn-outline-primary">Buy Now</a>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               @endif
               @if ($price_data->based_on_listing_criteria_price != '')
                   <div class="col-xl-4 col-sm-4 col-12 mt-2">
                       <div class="card">
                           <div class="card-body">
                               <div class="dash-widget-header text-center" style="display:block">
                                   <div class="dash-count">
                                       <div class="dash-title"><a
                                               href="{{ route('based_on_listing_criteria', ['id' => $id]) }}"
                                               style=" margin-bottom: 25px;display: inline-block;">{{ $price_data->based_on_listing_criteria_label }}</a>
                                       </div>
                                       <a href="{{ route('based_on_listing_criteria', ['id' => $id]) }}"
                                           class="btn btn-rounded btn-outline-primary">Buy Now</a>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               @endif
               <div class="col-xl-4 col-sm-4 col-12 mt-2">
                   <div class="card">
                       <div class="card-body">
                           <div class="dash-widget-header text-center" style="display:block">
                               <div class="dash-count">
                                   <div class="dash-title"><a href="{{ route('international-package', ['id' => $id]) }}"
                                           style=" margin-bottom: 25px;display: inline-block;">International Package</a>
                                   </div>
                                   <a href="{{ route('international-package', ['id' => $id]) }}"
                                       class="btn btn-rounded btn-outline-primary">Buy Now</a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>


               

               
               @php
                   $currentDate = now();
                   $id = $id;
                   $package_subs = DB::table('subscription')
                       ->select('*')
                       ->where('vendor_id', '=', $id)
                       ->where('type_of_subscription', '=', 1)
                       ->orderBy('id', 'desc')
                       ->get();
                   $package_subs = $package_subs->toArray();
                //    echo "<pre>";print_r($package_subs);echo "</pre>";
                   $result = DB::table('subscription')
                       ->select('*')
                       ->where('vendor_id', '=', $id)
                       ->where('is_deleted' , '=' ,'0')
                       //->where('enddate', '>=', $currentDate)
                       ->orderBy('id', 'desc')
                       ->get();
                   $result_new = $result->toArray();
                //    echo "<pre>";print_r($result_new);echo "</pre>";
               @endphp
               <div class="col-lg-12">
                   <div class="card">
                       <div class="card-header">
                           <h5 class="card-title">Your Subscription Details</h5>
                       </div>
                       <div class="card-body">
                           <div class="table-responsive">
                               @if (isset($result_new) && !empty($result_new))
                                   <table class="table table-striped mb-0" id="subs_table">
                                       <thead>
                                           <tr>
                                               <th>Subscription Id</th>
                                               <th>Subscription Name</th>
                                               <th>Type Of Package</th>
                                               <th>Type of Subscription</th>
                                               <th>Total Inquiry</th>
                                               <th>Accept Inquiry</th>
                                               <th>Pending Inquiry</th>
                                               {{-- <th>Total</th> --}}
                                               {{-- <th>Start Date</th>
                                               <th>End Date</th>
                                               <th>Status</th> --}}
                                               <th>Detail</th>
                                               <th>Copy Package</th>
                                               <th>Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($result_new as $subs_data)
                                               <tr>
                                                   <td>{{ $subs_data->id }}</td><td>{{ $subs_data->subscription_name }}</td>
                                                   <td>
                                                        @php
                                                            if($subs_data->type_of_package == 0){
                                                                $type_of_package = 'Local';
                                                            }elseif($subs_data->type_of_package == 1){
                                                                $type_of_package = 'International';
                                                            }else{
                                                                $type_of_package ="";
                                                            }

                                                           
                                                        @endphp
                                                         {{ $type_of_package }}

                                                   </td>

                                                   <td>
                                                    @php
                                                        if($subs_data->type_of_subscription == 0){
                                                            $type_of_subscription = 'Package';
                                                        }elseif($subs_data->type_of_subscription == 1){
                                                            $type_of_subscription = 'Leads';
                                                        }elseif($subs_data->type_of_subscription == 2){
                                                            $type_of_subscription = 'Auto Accept Package';
                                                        }else{
                                                            $type_of_subscription ="";
                                                        }

                                                       
                                                    @endphp
                                                     {{ $type_of_subscription }}

                                               </td>
                                               
                                               <td>
                                                    @php
                                                        

                                                        if($subs_data->type_of_subscription == 0 || $subs_data->type_of_subscription == 2){
                                                            $totalInquiry = $subs_data->no_of_inquiry_package;
                                                        }else{
                                                            $totalInquiry = '0';
                                                        }
                                                    @endphp
                                                            {{ $totalInquiry }}
                                               </td>
                                               <td>
                                                @php
                                                    

                                                    if($subs_data->type_of_subscription == 0 || $subs_data->type_of_subscription == 2){

                                                        $package_inquiry_accepted = DB::table('package_inquiry_accepted')->where('subscription_id',$subs_data->id)->count();
                                                        $acceptInquiry = $package_inquiry_accepted;
                                                    }else{
                                                        $acceptInquiry = '0';
                                                    }
                                                @endphp
                                                        {{ $acceptInquiry }}
                                           </td>

                                           <td>
                                            @php
                                                
                                                $pendingInquiry = $totalInquiry - $acceptInquiry;

                                            @endphp
                                            {{ $pendingInquiry }}
                                       </td>

                                                   {{-- <td>{{ $subs_data->total }}</td> --}}
                                                   {{-- <td>{{ date('d-m-Y', strtotime($subs_data->startdate)) }}</td>
                                                   <td>{{ date('d-m-Y', strtotime($subs_data->enddate)) }}</td>
                                                   <td> <span class="badge badge-pill bg-success-light">Active</span></td> --}}
                                                   
                                                    
                                                   <td><a class="btn btn-primary" href="javascript:void('0');"
                                                           onclick="delete_category('{{ $subs_data->id }}');">View
                                                           Services</a></td>
                                                    <td>
                                                        @if( $subs_data->subscription_name == 'International Package' )
                                                        <a class="btn btn-primary"
                                                        href="{{ route('international-package', ['id' => $subs_data->vendor_id,'subs_id'=>$subs_data->id]) }}">Copy Package</a>
                                                        @else
                                                        <a class="btn btn-primary"
                                                        href="{{ route('base_on_service_lead', ['id' => $subs_data->vendor_id, 'subs_id'=>$subs_data->id]) }}">Copy Package</a>
                                                        @endif

                                                    </td>
                                                        
                                                    <td class="text-right">
                                                        @if( $subs_data->subscription_name == 'International Package' )
                                                        <a class="btn btn-primary"
                                                        href="{{ route('edit_international_subscription', ['id' => $subs_data->id]) }}"><i
                                                            class="far fa-edit"></i></a>
                                                        @else
                                                        <a class="btn btn-primary"
                                                            href="{{ route('edit_subscription', ['id' => $subs_data->id]) }}"><i
                                                                class="far fa-edit"></i></a>
                                                        @endif

                                                        <a class="btn btn-danger me-1" href="javascript:void(0);" onclick="delete_subs_model({{ $subs_data->id }});">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                               </tr>
                                           @endforeach
                                       </tbody>
                                   </table>
                               @else
                                   {{ 'No Data Found' }}
                               @endif
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   @stop

   @section('footer_js')
   <!-- Delete  Modal -->
   @if ($result_new != '')
       @foreach ($result_new as $data)
           <div class="modal custom-modal fade" id="delete_model_{{ $data->id }}" role="dialog">
               <div class="modal-dialog modal-dialog-centered">
                   <div class="modal-content">
                       <div class="modal-body">
                           <div class="modal-text text-center">
                               <div id="div_replace_{{ $data->id }}">
                               </div>
                           </div>
                       </div>
                       <!-- <div class="modal-footer text-center">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                   <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>
               </div> -->
                   </div>
               </div>
           </div>
       @endforeach
   @endif
   
   <div class="modal custom-modal fade" id="subscription_delete_model" role="dialog">
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
<form id="delete_form" action="{{route('delete_subscription')}}" type="">
<input type="hidden" id="subs_id" name="subs_id" value="">
</form>
   <script>
     function delete_subs_model(subs_id) {
            //  alert('subscription_id');
            $('#subs_id').val(subs_id);
            $('#subscription_delete_model').modal('show');
        }
   </script>

   <script>
    function form_sub() {
        $('#delete_form').submit();
        }
   </script>
   <script>
       function delete_category(id) {
           var url = '{{ url('subscription_replace') }}';
           $.ajax({
                url: url,
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(msg) {
                    document.getElementById('div_replace_'+ id).innerHTML = msg;
                    $('#delete_model_' + id).modal('show');
                }
            });
           //
       }
   </script>

@stop
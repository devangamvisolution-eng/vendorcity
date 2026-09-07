   @extends('admin.includes.Template')
   @section('content')


       <div class="content container-fluid">

           @php

               $price_data = DB::table('prices')
                   ->select('*')
                   ->orderBy('id', 'desc')
                   ->first();

               //echo "<pre>";print_r($price_data);echo "</pre>";

           @endphp

           <!-- Page Header -->
           <div class="page-header">
               <div class="row">
                   <div class="col-sm-12">
                       <!-- <h3 class="page-title">Add City</h3> -->
                       <h3 class="page-title">{{ $price_data->based_on_booking_service_label }}</h3>
                       <ul class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="{{ route('vendors.subscription', $id) }}">Subscription</a>
                           </li>
                           <li class="breadcrumb-item active">{{ $price_data->based_on_booking_service_label }}</li>
                       </ul>
                   </div>
               </div>
           </div>
           <!-- /Page Header -->

           <!--  <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
                                   <span id="login_error"></span>
                                   <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                               </div> -->


           <div class="row">
               <div class="col-md-12">
                   <div class="card">
                       <div class="card-body">
                           <!-- <h4 class="card-title">Category</h4> -->
                           <form action="{{ route('based_on_booking_services', ['id' => $id]) }}" id="category_form_new"
                               method="POST" enctype="multipart/form-data">

                               <input type="hidden" name="vendor_id" id="subscription_id" value="{{ $id }}">

                               <input type="hidden" name="subscription_id" id="subscription_id" value="2">
                               <input type="hidden" name="action" id="subscription_id" value="add">

                               @csrf
                               <div class="row">

                                   <div class="form-group">
                                       <label for="country">Subscription Name</label>
                                       <input type="text" name="subscription_name" id="subscription_name"
                                           value="{{ $price_data->based_on_booking_service_label }}" class="form-control"
                                           readonly>
                                       <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>

                                   <div class="form-group">
                                       <label for="country">Subscription Price</label>
                                       <input type="text" name="total" id="total"
                                           value="{{ $price_data->based_on_booking_service_price }}" class="form-control"
                                           readonly>
                                       <p class="form-error-text" id="country_error" style="color: red; margin-top: 10px;">
                                       </p>
                                   </div>

                               </div>
                               <div class="text-end mt-4">
                                   <a class="btn btn-primary" href="{{ route('vendors.subscription', $id) }}"> Back</a>
                                   <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                       style="display: none;">
                                       <span class="spinner-border spinner-border-sm" role="status"
                                           aria-hidden="true"></span>
                                       Loading...
                                   </button>
                                   <button type="button" class="btn btn-primary"
                                       onclick="javascript:category_validation()"id="submit_button">Buy Now</button>

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
           function category_validation() {

               $('#spinner_button').show();
               $('#submit_button').hide();

               $('#category_form_new').submit();
           }
       </script>
   @stop

   @extends('admin.includes.Template')
   @section('content')


      <div class="content container-fluid">

        @php
           //echo "<pre>";print_r($all_data);echo "</pre>";

           $added_date = date('d-m-Y', strtotime($all_data->added_date));

           $startdate = date('d-m-Y', strtotime($all_data->startdate));
           $enddate = date('d-m-Y', strtotime($all_data->enddate));
           @endphp
            
                    <div class="row justify-content-center">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="invoice-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="invoice-logo">
                                                    <img src="{{ asset('public/admin/assets/img/logo.png') }}" alt="logo">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="invoice-details">
                                                    <strong>Order:</strong> #{{$all_data->id}} <br>
                                                    <strong>Issued:</strong> {{$added_date}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Invoice Item -->
                                    <div class="invoice-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="invoice-info">
                                                    <strong class="customer-text">Invoice From</strong>
                                                    <p class="invoice-details invoice-details-two">
                                                        Darren Elder <br>
                                                        806  Twin Willow Lane, Old Forge,<br>
                                                        Newyork, USA <br>
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="invoice-info invoice-info2">
                                                    <strong class="customer-text">Invoice To</strong>
                                                    <p class="invoice-details">
                                                        Walter Roberson <br>
                                                        299 Star Trek Drive, Panama City, <br>
                                                        Florida, 32405, USA <br>
                                                    </p>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <!-- /Invoice Item -->
                                    
                                   
                                    
                                    <!-- Invoice Item -->
                                    <div class="invoice-item invoice-table-wrap">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="invoice-table table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Subscription Name</th>
                                                                <th class="text-center">Start Date</th>
                                                                <th class="text-center">End Date</th>
                                                                <th class="text-end">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>{{$all_data->subscription_name}}</td>
                                                                <td class="text-center">{{$startdate}}</td>
                                                                <td class="text-center">{{$enddate}}</td>
                                                                <td class="text-end">{{$all_data->total}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xl-4 ms-auto">
                                                <div class="table-responsive">
                                                    <table class="invoice-table-two table">
                                                        <tbody>
                                                       <!--  <tr>
                                                            <th>Subtotal:</th>
                                                            <td><span>$350</span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Discount:</th>
                                                            <td><span>-10%</span></td>
                                                        </tr> -->
                                                        <tr>
                                                            <th>Total Amount:</th>
                                                            <td><span>{{$all_data->total}}</span></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Invoice Item -->
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
   @stop
   @section('footer_js')
       
   @stop

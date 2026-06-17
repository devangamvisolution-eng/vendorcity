@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">

        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-item">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="invoice-logo">
                                        <!-- <img src="{{ asset('public/admin/assets/img/logo.png') }}" alt="logo"> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <p class="invoice-details">
                                        <strong>Order:</strong> #{{ $order->format_order_id }} <br>
                                        <strong>Issued:</strong>
                                        @php
                                            $order_date = strtotime($order->created_at);
                                            echo $mysqldate = date('l, F d, Y', $order_date);

                                        @endphp
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Item -->
                        <div class="invoice-item" style="margin-top:20px;">
                            <div class="row">

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

                                <div class="col-md-6">
                                    <div class="invoice-info">
                                        <strong class="customer-text">Billing details</strong>
                                        <p class="invoice-details invoice-details-two">
                                            {{ $order->first_name }} {{ $order->last_name }} <br>
                                            @if ($order->address2 != '')
                                                {{ $order->address2 }},
                                            @endif

                                            @if ($order->address1 != '')
                                                {{ $order->address1 }},
                                            @endif
                                            </br>
                                            @if ($order->area != '')
                                                {{ $order->area }},
                                            @endif

                                            @if ($order->emirate != '')
                                                {{ $order->emirate }},
                                            @endif
                                            </br>
                                            @if ($order->country != '')
                                                {{ Helper::countryname($order->country) }}
                                            @endif

                                            @if ($order->city != '')
                                                {{ Helper::cityname($order->city) }},
                                            @endif
                                            <br>
                                            @if ($order->state != '')
                                                {{ Helper::state_name($order->state) }},
                                            @endif

                                            @if ($order->zipcode != '')
                                                {{ $order->zipcode }},
                                            @endif

                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="invoice-info invoice-info2">
                                        <strong class="customer-text">Payment Method</strong>

                                        <p class="invoice-details">
                                            @if ($order->paymentmode == '1')
                                                Cash On Delivery
                                            @elseif ($order->paymentmode == '2')
                                                Online Payment
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Invoice Item -->

                        <!-- Invoice Item -->
                        <!-- <div class="invoice-item">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="invoice-info">
                                                                    <strong class="customer-text">Payment Method</strong>
                                                                    
                                                                    <p class="invoice-details invoice-details-two">
                                                                        @if ($order->paymentmode == '1')
                                                                        Cash On Delivery
                                                                    @elseif ($order->paymentmode == '2')
                                                                        Online Payment
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                        <!-- /Invoice Item -->

                        <div class="col-md-12">
                            <strong class="customer-text" style="font-size: 18px;color:#272b41;">Customer Details</strong>
                            <div class="table-responsive">
                                <table class="invoice-table table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>

                                            <th class="text-center">Email ID</th>
                                            <th class="text-center">Mobile No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{{ $order->user_name }}</td>
                                            <td class="text-center">{{ $order->user_email }}</td>
                                            <td class="text-center">{{ $order->user_mobile }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>&nbsp;

                        @php
                            //echo "<pre>";print_r($order);echo"</pre>";

                            
                        @endphp

                        <!-- Invoice Item -->
                        @if($order->order_from  != 1 && $order->order_from  != 2)
                        <div class="invoice-item invoice-table-wrap">
                            <div class="row">
                                <strong class="customer-text" style="font-size: 18px;color:#272b41;">Order Summary</strong>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="invoice-table table table-bordered">
                                            <thead>
                                                <tr>
                                                    {{-- <th class="text-center">Package Image</th> --}}
                                                    <th class="text-center">Package Name</th>
                                                    <th class="text-center">Service</th>
                                                    <th class="text-center">Sub Service</th>
                                                    <th class="text-center">Moving Date</th>

                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Totals</th>
                                                    <th class="text-center">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sub_total = 0;
                                                @endphp
                                                @foreach ($order->items as $item)
                                                    @php
                                                        /*echo "<pre>";print_r($item);echo "</pre>"; */
                                                    @endphp
                                                    <tr>
                                                        {{-- <td class="text-center">
                                                            @if ($item->image != '')
                                                                <img src="{{ url('public/upload/packages/large/' . $item->image) }}"
                                                                    width="50px" height="50px">
                                                            @else
                                                                <img src="{{ url('public/upload/packages/large/no-image.png') }}"
                                                                    width="50px" height="50px">
                                                            @endif
                                                        </td> --}}
                                                        <td class="text-center">{{ $item->package_item_name }}</td>

                                                        <td class="text-center">{{ $item->service_name }}</td>

                                                        <td class="text-center">{{ $item->subservice_name }}</td>

                                                        <td>
                                                            @php
                                                            if($order->moving_date != ''){
                                                                $moving_date = strtotime( $order->moving_date);
                                                             echo $mysqldate = date( 'F d, Y', $moving_date );
                                                            }else{
                                                                echo "-";
                                                            }
                                                            
                                                            @endphp
                                                        </td>

                                                        @php

                                                            if (
                                                                $item->product_discount_amount != 0 &&
                                                                $item->product_discount_amount != ''
                                                            ) {
                                                                $product_item_price = $item->product_discount_amount;
                                                            } else {
                                                                $product_item_price = $item->package_item_price;
                                                            }
                                                        @endphp

                                                        <td class="text-center">{{ $order->order_currency }}
                                                            {{ $product_item_price }}</td>
                                                        <td class="text-center">{{ $item->package_quantity }}</td>
                                                        @php

                                                            $total = $product_item_price * $item->package_quantity;
                                                            $sub_total += $total;
                                                        @endphp
                                                        <td class="text-end">{{ $order->order_currency }}
                                                            {{ $total }}</td>

                                                        <td class="text-end">

                                                            @if($item->is_return == 1)
                                                                {{ 'Canceled' }}

                                                            @else

                                                                {{'-'}}
                                                            @endif

                                                                </td>
                                                    </tr>
                                                @endforeach




                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4 ms-auto">
                                    <div class="table-responsive">
                                        <table class="invoice-table-two table">
                                            <tbody>
                                                <tr>
                                                    <th>Subtotal:</th>
                                                    <td><span>{{ $order->order_currency }} {{ $sub_total }}</span></td>
                                                </tr>
                                                @if ($order->coupondiscount != '' && $order->coupondiscount != 0)
                                                    <tr>
                                                        <th>Discount:</th>
                                                        <td><span>{{ $order->order_currency }}
                                                                {{ $order->coupondiscount }}</span>
                                                            @if($order->coupan_to_wallet == 1)
                                                                <span>(Credited to User Wallet)</span>
                                                            @endif</td>
                                                    </tr>
                                                @endif

                                                @if ($order->shippingcost != '' && $order->shippingcost != 0)
                                                    <tr>
                                                        <th>Shipping:</th>
                                                        <td><span>{{ $order->order_currency }}
                                                                {{ $order->shippingcost }}</span></td>
                                                    </tr>
                                                @endif

                                                @if ($order->vatcharge != '' && $order->vatcharge != 0)
                                                    <tr>
                                                        <th>VAT 5% :</th>
                                                        <td><span>{{ $order->order_currency }}
                                                                {{ $order->vatcharge }}</span></td>
                                                    </tr>
                                                @endif

                                                @if ($order->sub_total != '' && $order->sub_total != 0)
                                                    <tr>
                                                        <th>Sub Total:</th>
                                                        <td><span>{{ $order->sub_total }}</span></td>
                                                    </tr>
                                                @endif

                                                @if ($order->front_wallet_amount != '' && $order->front_wallet_amount != 0)
                                                <tr>
                                                    <th>Wallet Amount:</th>
                                                    <td><span> - {{ $order->order_currency }} {{ $order->front_wallet_amount }}</span></td>
                                                </tr>
                                                @endif

                                                @php
                                                    $order_new = round($order->order_total);
                                                @endphp

                                                <tr>
                                                    <th>Total Amount:</th>
                                                    <td><span>{{ $order->order_currency }}
                                                            {{ $order_new }}</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif


                        @if($order->order_from  == 1 && $order->order_from  != 2)
                        <div class="invoice-item invoice-table-wrap">
                            <div class="row">
                                <strong class="customer-text" style="font-size: 18px;color:#272b41;">Order Summary</strong>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="invoice-table table table-bordered">
                                            <thead>
                                                
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sub_total = 0;
                                                @endphp
                                                @foreach ($order->items as $item)
                                                    @php
                                                        /*echo "<pre>";print_r($item);echo "</pre>"; */

                                                        if($item->how_often_do_you_need_cleaning != ''){

                                                            $order_item_package_data = array();
                                                         }else{
                                                            $order_item_package_data = DB::table('ci_order_item_packages')
                                                                                    ->where('order_id',$item->order_id)
                                                                                    ->where('order_item_id',$item->id)
                                                                                    ->get()->toArray();
                                                        // echo"<pre>";print_r($item);echo"</pre>";exit;
                                                         }
                                                    @endphp



                                                    <tr>
                                                                                                            
                                                        <td class="text-center">Service Type</td>

                                                        <td class="text-end">{!! Helper::subservicename(strval($item->subservice_id)) !!}  </td>
                                                    </tr>

                                                    @if($item->how_often_do_you_need_cleaning != '')
                                                    <tr>
                                                        
                                                        <td class="text-center">No. of Cleaners</td>

                                                        <td class="text-end"> {{ $item->how_many_cleaners_do_you_need  }} </td>
                                                    </tr>

                                                    <tr>                                                       
                                                        <td class="text-center">No. of Hours</td>
                                                        <td class="text-end"> {{ $item->how_many_hours_should_they_stay  }} </td>
                                                    </tr>

                                                    <tr>                                                       
                                                        <td class="text-center">Frequency</td>
                                                        <td class="text-end"> {{ $item->how_often_do_you_need_cleaning  }} </td>
                                                    </tr>
                                                    @if($item->which_day_of_the_week_do_you_want_the_service != '')
                                                    <tr>                                                       
                                                        <td class="text-center">Days of the week</td>
                                                        <td class="text-end"> {{ $item->which_day_of_the_week_do_you_want_the_service  }} </td>
                                                    </tr>
                                                    @endif
                                                    <tr>                                                       
                                                        <td class="text-center">Materials</td>
                                                        <td class="text-end"> {{ $item->do_you_need_cleaning_material  }} </td>
                                                    </tr>
                                                    @endif

                                                    @if(!empty($order_item_package_data))

                                                    <tr>                                                       
                                                        <td class="text-center">Services</td>
                                                        <td class="text-end"> 
                                                            @foreach($order_item_package_data as $package_data)
                                                                {!! $package_data->package_item_name !!} * {!! $package_data->package_quantity !!}<br>
                                                            @endforeach
                                                        </td>
                                                    </tr>

                                                    @endif


                                                    <tr>                                                       
                                                        <td class="text-center">Date</td>
                                                        <td class="text-end"> {{ $item->bookingdate}} {{ $item->month}} {{ $item->bookingyear}}</td>
                                                    </tr>
                                                    <tr>                                                       
                                                        <td class="text-center">Start Time</td>
                                                        <td class="text-end"> {!! Helper::timeslotname(strval($item->time_slot)) !!} </td>
                                                    </tr>
                                                    <tr>                                                       
                                                        <td class="text-center">Address</td>
                                                        <td class="text-end"> {{ $item->city}} , {{ $item->area}} , {{ $item->building_street_no}} , {{ $item->apartment_villa_no}}   </td>
                                                    </tr>
                                                @endforeach




                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4 ms-auto">
                                    <div class="table-responsive">
                                        <table class="invoice-table-two table">
                                            <tbody>
                                                <tr>
                                                    <th>Service Charges:</th>
                                                    <td><span>{{ $order->service_charge }}</span></td>
                                                </tr>

                                                <tr>
                                                    <th>Promo Discount :</th>
                                                    <td><span>{{ $order->promo_discount }}</span></td>
                                                </tr>

                                                <tr>
                                                    <th>Additional Charges:</th>
                                                    <td><span>{{ $order->additional_charge }}</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Timing fee:</th>
                                                    <td><span>{{ $order->timing_charge }}</span></td>
                                                </tr>
                                                @if($order->cod_charge > 0)
                                                <tr>
                                                    <th>Delivery charge:</th>
                                                    <td><span>{{ $order->cod_charge }}</span></td>
                                                </tr>
                                                @endif

                                                <tr>
                                                    <th>Service Fee:</th>
                                                    <td><span>{{ $order->service_fee }}</span></td>
                                                </tr>
                                                <tr>
                                                @php
                                                $sub_total_new = 
                                                        (float)$order->service_charge + 
                                                        (float)$order->promo_discount + 
                                                        (float)$order->additional_charge + 
                                                        (float)$order->timing_charge + 
                                                        (float)$order->service_fee + 
                                                        (float)$order->cod_charge;

                                                @endphp
                                                    <th>Sub Total:</th>
                                                    <td><span>{{ $sub_total_new }}</span></td>
                                                </tr>
                                                @if ($order->coupondiscount != '' && $order->coupondiscount != 0)
                                                <tr>
                                                    <th>Discount:</th>
                                                    <td><span> - {{ $order->order_currency }} {{ $order->coupondiscount }}</span>
                                                    @if($order->coupan_to_wallet == 1)
                                                        <span>(Credited to User Wallet)</span>
                                                    @endif
                                                    </td>
                                                </tr>
                                                @endif 
                                                <tr>
                                                    <th>VAT (5%):</th>
                                                    <td><span>{{ $order->vatcharge }}</span></td>
                                                </tr>

                                                @if ($order->front_wallet_amount != '' && $order->front_wallet_amount != 0)
                                                <tr>
                                                    <th>Wallet Amount:</th>
                                                    <td><span> - {{ $order->order_currency }} {{ $order->front_wallet_amount }}</span></td>
                                                </tr>
                                                @endif
                                                @php
                                                $order_new = round($order->order_total);
                                                @endphp
                                                <tr>
                                                    <th>Total Amount:</th>
                                                    <td><span>{{ $order_new }}</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($order->order_from  == 2 && $order->order_from  != 1 && $order->order_from  != 0)
                        <div class="invoice-item invoice-table-wrap">
                            <div class="row">
                                <strong class="customer-text" style="font-size: 18px;color:#272b41;">Booking Summary</strong>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="invoice-table table table-bordered">
                                            <thead>
                                                
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sub_total = 0;
                                                @endphp
                                                @foreach ($order->items as $item)
                                                    @php
                                                        /*echo "<pre>";print_r($item);echo "</pre>"; */

                                                        if($item->how_often_do_you_need_cleaning != ''){

                                                            $order_item_package_data = array();
                                                         }else{
                                                            $order_item_package_data = DB::table('ci_order_item_packages')
                                                                                    ->where('order_id',$item->order_id)
                                                                                    ->where('order_item_id',$item->id)
                                                                                    ->get()->toArray();
                                                         }
                                                    @endphp



                                                    <tr>
                                                                                                            
                                                        <td class="text-center">Service Type</td>

                                                        <td class="text-end">{!! Helper::subservicename(strval($item->subservice_id)) !!}  </td>
                                                    </tr>

                                                    @if($item->type_of_painting != '')
                                                    <tr>
                                                        
                                                        <td class="text-center">Service</td>

                                                        <td class="text-end"> {{ $item->type_of_painting  }} </td>
                                                    </tr>

                                                    <tr>                                                       
                                                        <td class="text-center">Size of home</td>
                                                        <td class="text-end"> {{ $item->selected_type_home.' - '.$item->selected_size_home  }} </td>
                                                    </tr>

                                                    <tr>                                                       
                                                        <td class="text-center">Home Furnished</td>
                                                        <td class="text-end"> {{ $item->is_home_furnished  }} </td>
                                                    </tr>
                                                   
                                                    <tr>                                                       
                                                        <td class="text-center">Colors</td>
                                                        <td class="text-end"> {{ $item->your_walls_now_color.' to '.$item->you_want_paint_color  }} </td>
                                                    </tr>
                                                    <tr>                                                       
                                                        <td class="text-center">Ceilings</td>
                                                        <td class="text-end"> {{ $item->no_of_ceilings ? : "-"  }} </td>
                                                    </tr>
                                                    @endif

                                                    @if(!empty($order_item_package_data))

                                                    <tr>                                                       
                                                        <td class="text-center">Services</td>
                                                        <td class="text-end"> 
                                                            @foreach($order_item_package_data as $package_data)
                                                                {!! $package_data->package_item_name !!} * {!! $package_data->package_quantity !!}<br>
                                                            @endforeach
                                                        </td>
                                                    </tr>

                                                    @endif


                                                    <tr>                                                       
                                                        <td class="text-center">Date</td>
                                                        <td class="text-end"> {{ $item->bookingdate}} {{ $item->month}} {{ $item->bookingyear}}</td>
                                                    </tr>
                                                    <tr>                                                       
                                                        <td class="text-center">Start Time</td>
                                                        <td class="text-end"> {!! Helper::timeslotname(strval($item->time_slot)) !!} </td>
                                                    </tr>
                                                    <tr>                                                       
                                                        <td class="text-center">Address</td>
                                                        <td class="text-end"> {{ $item->city}} , {{ $item->area}} , {{ $item->building_street_no}} , {{ $item->apartment_villa_no}}   </td>
                                                    </tr>
                                                @endforeach




                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-4 ms-auto">
                                    <div class="table-responsive">
                                        <table class="invoice-table-two table">
                                            <tbody>
                                                <tr>
                                                    <th>Service Charges:</th>
                                                    <td><span>{{ $order->service_charge }}</span></td>
                                                </tr>

                                                <tr>
                                                    <th>Promo Discount :</th>
                                                    <td><span>{{ $order->promo_discount }}</span></td>
                                                </tr>

                                                <tr>
                                                    <th>Additional Charges:</th>
                                                    <td><span>{{ $order->additional_charge }}</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Timing fee:</th>
                                                    <td><span>{{ $order->timing_charge }}</span></td>
                                                </tr>
                                                @if($order->cod_charge > 0)
                                                <tr>
                                                    <th>Delivery charge:</th>
                                                    <td><span>{{ $order->cod_charge }}</span></td>
                                                </tr>
                                                @endif

                                                <tr>
                                                    <th>Service Fee:</th>
                                                    <td><span>{{ $order->service_fee }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Sub Total:</th>
                                                    <td><span>{{ $order->sub_total }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th>VAT (5%):</th>
                                                    <td><span>{{ $order->vatcharge }}</span></td>
                                                </tr>
                                                @if ($order->front_wallet_amount != '' && $order->front_wallet_amount != 0)
                                                <tr>
                                                    <th>Wallet Amount:</th>
                                                    <td><span> - {{ $order->order_currency }} {{ $order->front_wallet_amount }}</span></td>
                                                </tr>
                                                @endif
                                                @php
                                                $order_new = round($order->order_total);
                                                @endphp
                                                <tr>
                                                    <th>Total Amount:</th>
                                                    <td><span>{{ $order_new }}</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- /Invoice Item -->

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

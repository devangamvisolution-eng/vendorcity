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
                                        <strong>Order:</strong> #{{ $order->order_id }} <br>
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
                                            @if ($order->address1 != '')
                                                {{ $order->address1 }},
                                            @endif
                                            @if ($order->address2 != '')
                                                {{ $order->address2 }},
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

                                            @if ($order->country != '')
                                                {{ Helper::countryname($order->country) }}
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

                        <!-- Invoice Item -->
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

                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Totals</th>
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
                                                                {{ $order->coupondiscount }}</span></td>
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

                                                @if ($order->front_wallet_amount != '' && $order->front_wallet_amount != 0)
                                                    <tr>
                                                        <th>Wallet Amount :</th>
                                                        <td><span>- {{ $order->order_currency }}
                                                                {{ $order->front_wallet_amount }}</span></td>
                                                    </tr>
                                                @endif

                                                

                                                <tr>
                                                    <th>Total Amount:</th>
                                                    <td><span>{{ $order->order_currency }}
                                                            {{ $order->order_total }}</span></td>
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

@include('front.includes.header')
<style>
    .quantity-num-one {
        border: none;
        border-radius: 4px 0 0 4px;
        font-size: 15px;
        height: 56px;
        max-width: 140px;
        outline: none;
        padding: 0;
        text-align: center;
        width: 100%;
    }
    .shopping_cart_table .vendorTopContent img {
        width:100% !important;
    }
    .shopping_cart_table .table_body tr td:first-child{
        width:68% !important;
    }

    @media only screen and (max-width: 600px) {
        .table_body  tr .desc{display: none !important;}
    }
	.currency_dhiram {
    display: inline-block;
        width: 18px;
    height: 18px;

    background-color: currentColor;

    -webkit-mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;
    mask: url('{{ asset("public/site/icons/dirham.svg") }}') no-repeat center;

    -webkit-mask-size: contain;
    mask-size: contain;
}
.float-end,.cart-price{
        display: flex;
    align-items: center;
    gap: 2px;
}
</style>
<!-- Shop Cart Area -->
<section class="pt40 pb0 mt120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-title">
                    <h2 class="title">Cart</h2>
                    <!-- <p class="text mb-0">Give your visitor a smooth online experience with a solid UX design</p> -->
                </div>
            </div>
        </div>
    </div>
</section>
<section class="shop-checkout pt-0">

    <div class="container">
        @if (Cart::count() > 0)
            <div id="mydiv_pc">
                <div class="row wow fadeInUp" data-wow-delay="300ms">
                    <div class="col-lg-8">
                        <div class="shopping_cart_table table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th class="pl30" scope="col">Product</th>
                                        <th class="ps-0" scope="col">Quantity</th>
                                        <th class="ps-0" scope="col">Price</th>
  
                                        {{-- <th class="ps-0" scope="col">Subtotal</th> --}}
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody class="table_body">
                                    @php
                                        $subtotal = 0;
                                        // echo '<pre>';
                                        // print_r(Cart::content());
                                        // echo '</pre>';
                                    @endphp
                                    @foreach (Cart::content() as $items)
                                        <tr>
                                            <td class="pl30 ">
                                                <div class="cart_list d-flex align-items-center">
                                                    {{-- <div class="cart-img">
                                                        @if ($items->options->image)
                                                            <a
                                                                href="{{ url('package-detail/' . $items->options->page_url) }}"><img
                                                                    src="{{ asset('public/upload/packages/large/' . $items->options->image) }}"
                                                                    alt="cart-1.png" width="60px" height="74px"></a>
                                                        @else
                                                            <a
                                                                href="{{ url('package-detail/' . $items->options->page_url) }}"><img
                                                                    src="images/shop/cart-1.png" alt="cart-1.png"></a>
                                                        @endif
                                                    </div> --}}
                                                    <a href="{{ url('package-detail/' . $items->options->page_url) }}">
                                                        <h5 class="mb-0">{{ $items->name }}</h5>
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="product-quantity" data-title="Quantity">
                                                <div class="quantity" style="margin-left:-33px;">
                                                    <div class="quantity-block">
                                                        <button class="quantity-arrow-minus"
                                                            onclick="minus_qty('{{ $items->rowId }}', '{{ $items->qty }}');">
                                                            <span class="fa fa-minus"></span>
                                                        </button>
                                                        <input class="quantity-num-one qty_input_{{ $items->rowId }}"
                                                            type="text" value="{{ $items->qty }}" />
                                                        <button
                                                            class="quantity-arrow-plus plus_button_{{ $items->rowId }}"
                                                            onclick="plus_qty('{{ $items->rowId }}', '{{ $items->qty }}');">
                                                            <span class="fas fa-plus"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>

                                            @php

                                                if ($items->options->discount_type != '') {
                                                    if ($items->options->discount_type == 0) {
                                                        //percentage
                                                        $disc_price_new =
                                                            ($items->price * $items->options->discount) / 100;

                                                        $disc_price = $items->price - $disc_price_new;

                                                        $p_price = $disc_price;
                                                    } elseif ($items->options->discount_type == 1) {
                                                        $disc_price = $items->price - $items->options->discount;
                                                        $p_price = $disc_price;
                                                    } else {
                                                        $disc_price = '0';
                                                        $p_price = $items->price;
                                                    }
                                                } else {
                                                    $disc_price = '0';
                                                }
                                            @endphp

                                            <td>
                                                <div class="cart-price">
                                                    @if ($disc_price != '0')
                                                        <del><span class="currency_dhiram"></span> {{ $items->price }}</del>
                                                        <span class="currency_dhiram"></span> {{ $disc_price }}
                                                    @else
                                                        <span class="currency_dhiram"></span> {{ $items->price }}
                                                    @endif

                                                </div>
                                            </td>

                                            <!-- <input class="cart_count text-center" placeholder="2" type="number"> -->

                                            {{-- <td>
                                                <div class="cart-subtotal pl5">
                                                    @php
                                                        if ($disc_price != '0') {
                                                            $price_tot = $disc_price;
                                                        } else {
                                                            $price_tot = $items->price;
                                                        }

                                                    @endphp
                                                    <span class="currency_dhiram"></span> {{ $price_tot * $items->qty }}

                                                </div>
                                            </td> --}}
                                            <td>
                                                <div class="cart-delete">
                                                    <a href="javascript:void(0)"
                                                        onclick="remove_to_cart('{{ $items->rowId }}'); return false;"><span
                                                            class="flaticon-delete"></span>
                                                </div>
                                            </td>
                                        </tr>

                                        @php

                                    if ($items->qty >= 1) {
                                        $subtotal += $items->qty * round($p_price);
                                    } else {
                                        $subtotal += round($p_price);
                                    }
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    

                    @php
                        $subtotal_new = $subtotal;
                        $formattedSubtotal = number_format((float)$subtotal_new, 2, '.', '');
                    @endphp

                    <div class="col-lg-4">
                        <div id="sidebar_cart">
                            <div class="shop-sidebar ms-lg-auto">
                                <div class="order_sidebar_widget default-box-shadow1">

                                    <h4 class="title">Order Summary</h4>
                                    <p class="text bdrb1 pb10">
                                        Subtotal <span class="float-end"><span class="currency_dhiram"></span> {{ $formattedSubtotal }}</span>
                                    </p>
                                    <p class="text">
                                        Total <span class="float-end"><span class="currency_dhiram"></span> {{ $formattedSubtotal }}</span>
                                    </p>
                                    @php
                                        $userData = Session::get('user');
                                        $userId = isset($userData['userid']) ? $userData['userid'] : null;
                                    @endphp



                                    @if ($userId !== null)
                                        <div class="d-grid mt40">
                                            <a class="ud-btn btn-thm" href="{{ url('/checkout') }}">Proceed to
                                                Checkout<i class="fal fa-arrow-right-long"></i></a>
                                        </div>
                                    @else
                                        <div class="d-grid mt40">
                                            <a class="ud-btn btn-thm" href="{{ route('Sign-in') }}">Proceed to
                                                Checkout<i class="fal fa-arrow-right-long"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
       
    </div>
  
    @if ($items->options->subservice_description != '')
        <td class="desc" style="border-bottom: none;">
            {!! html_entity_decode($items->options->subservice_description) !!}</td>
    @endif

    @else
    <p>No Product Found in Cart</p>
    @endif

</section>
@include('front.includes.footer')

<script>
    function plus_qty(rowid, qty) {
        var input = $('.qty_input_' + rowid);
        var count = parseInt(input.val()) + 1;

        // alert(max_qty);


        // count = count;


        // $('.qty_input_' + rowid).val(count);
        // $('.quantity-arrow-plus').prop('disabled', true);

        var url = '{{ url('update_cart') }}';

        $.ajax({
            url: url,
            type: 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                'rowid': rowid,
                'qty': qty,
                'count': count,
            },
            success: function(msg) {
                input.val(count);
                $("#sidebar_cart").load(location.href + " #sidebar_cart");
                $("#header_cart").load(location.href + " #header_cart");
                $("#header_cart_count").load(location.href + " #header_cart_count");
                $('.plus_button_' + rowid).prop("disabled", false);
                //$("#total_cart_value").load(location.href + " #total_cart_value");
            }
        });

        return false;
    }


    function minus_qty(rowid, qty) {
        var input = $('.qty_input_' + rowid);
        var count = parseInt(input.val()) - 1;

        if (count <= 1) {
            count = 1;
        }

        // Disable the button during the AJAX request
        // $('.qty_input_' + rowid).val(count);
        $('.quantity-arrow-minus').prop('disabled', true);

        $.ajax({
            url: '{{ url('update_cart') }}',
            type: 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                'rowid': rowid,
                'qty': qty,
                'count': count,
            },
            success: function(msg) {
                // Update the input value
                input.val(count);
                $("#sidebar_cart").load(location.href + " #sidebar_cart");
                $("#header_cart").load(location.href + " #header_cart");
                $("#header_cart_count").load(location.href + " #header_cart_count");
            },
            complete: function() {

                $('.quantity-arrow-minus').prop('disabled', false);
            }
        });

        return false;
    }
</script>

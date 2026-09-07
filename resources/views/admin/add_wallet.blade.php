@extends('admin.includes.Template')

@section('content')
    <div class="content container-fluid">


        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Wallet</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('wallet.index') }}">Wallet</a></li>
                        <li class="breadcrumb-item active">Add Wallet</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->


        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="wallet_form" action="{{ route('wallet.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">Price</label>
                                    <input id="price" name="price" type="text" class="form-control"
                                        placeholder="Enter Price" value=""
                                        onkeypress="return validateNumber(event)" />
                                    <p class="form-error-text" id="price_error" style="color: red; margin-top: 10px;"></p>
                                </div>

                                <div class="form-group">
                                    <label style="width: 100%;">Payment Type</label>
                                    <div style="padding: 9px 0;">
                                        <input type="radio" name="payment" value="0" id="cash">
                                        Cash
                                        <input type="radio" name="payment" value="1" id="online">
                                        Online
                                    </div>
                                    <p class="form-error-text" id="payment_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>



                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('wallet.index') }}"> Cancel</a>


                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>


                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:wallet_validation()">Submit</button>
                                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
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
        function wallet_validation() {
            var price = jQuery("#price").val();
            if (price == '') {
                jQuery('#price_error').html("Please Enter Price");
                jQuery('#price_error').show().delay(0).fadeIn('show');
                jQuery('#price_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#price').offset().top - 150
                }, 1000);
                return false;
            }

            var isPaymentChecked = jQuery('input[name="payment"]:checked');

            if (isPaymentChecked.length === 0) {
                jQuery('#payment_error').html("Please Select Payment Type");
                jQuery('#payment_error').show().delay(0).fadeIn('show');
                jQuery('#payment_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: jQuery('.form-group').offset().top - 150
                }, 1000);
                return false;
            }



            $('#spinner_button').show();
            $('#submit_button').hide();


            $('#wallet_form').submit();
        }

        function validateNumber(event) {

            var key = window.event ? event.keyCode : event.which;

            if (event.keyCode === 8 || event.keyCode === 46) {

                return true;

            } else if (key < 48 || key > 57) {

                return false;

            } else {

                return true;

            }

        }
    </script>

@stop

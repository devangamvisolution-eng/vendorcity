@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Admin Wallet</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('adminwallet.index') }}">Admin Wallet</a></li>

                        <li class="breadcrumb-item active">Add Admin Wallet</li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- /Page Header -->



        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">

            <span id="login_error"></span>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <div class="alert alert-danger alert-dismissible fade show failed_show" style="display: none;">
            <strong>Failed! </strong><span id="failed_message" style="color: red;"></span>
        </div>



        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-body">

                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form id="category_form" action="{{ route('adminwallet.store') }}" method="POST">

                            @csrf

                            <div class="row">



                                <div class="form-group">

                                    <label for="name">Vendor</label>

                                    <select name="vendor_id" id="vendor_id" class="form-control select2">

                                        <option value=""> Select Vendor</option>

                                        @foreach ($all_vendor as $all_vendor_data)

                                            <option value="{{ $all_vendor_data->id }}">{{ $all_vendor_data->name }}

                                            </option>

                                        @endforeach

                                    </select>
                                    <p class="form-error-text" id="vendor_id_error" style="color: red; margin-top: 10px;"></p>

                                </div>

                                <div class="form-group">

                                    <label for="name">Payment Type</label>

                                    <select name="payment_type" id="payment_type" class="form-control">
                                        <option value=""> Select Payment Type</option>
                                        <option value="0"> Cash</option>
                                        <option value="1"> Online</option>
                                        <option value="2"> Cheque</option>
                                        <option value="3"> Refund</option>
                                        <option value="4"> Deduct</option>
                                    </select>
                                    <p class="form-error-text" id="payment_type_error" style="color: red; margin-top: 10px;"></p>
                                </div>

                                <div class="form-group" id="deduct_reason_container" style="display: none;">

                                    <label for="reason">Reason For Deduction</label>

                                    <input class="form-control" id="deduct_reason" name="deduct_reason" type="text"
                                    placeholder="Enter Deduct Reason" value="" /> 

                                    <p class="form-error-text" id="deduct_reason_error" style="color: red; margin-top:10px;"></p>
                                </div>



                                <div class="form-group">

                                    <label for="name">Price</label>

                                    <input id="price" name="price" type="number" class="form-control"

                                        placeholder="Enter Price" value="" />
                                <p class="form-error-text" id="price_error" style="color: red; margin-top: 10px;"></p>
                                </div>

                                {{-- <div class="form-group">

                                    <label for="name">Page Url</label>

                                    <input id="page_url" name="page_url" type="text" class="form-control"

                                        placeholder="Enter Page Url" value="" />

                                </div> --}}

                            </div>



                            {{-- <div class="col-md-12">

                                <div class="form-group">

                                    <label>Meta Title</label>

                                    <input type="text" class="form-control" id="meta_title" name="meta_title"

                                        placeholder="Enter Meta Title">

                                    <p id="meta_title_error" style="display: none;color: red"></p>

                                    @error('meta_title')

                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>

                                    @enderror

                                </div>



                            </div> --}}



                            {{-- <div class="col-md-12">

                                <div class="form-group">

                                    <label>Meta Keywords</label>

                                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"

                                        placeholder="Enter Meta Keywords">

                                    <p id="meta_keywords_error" style="display: none;color: red"></p>

                                    @error('meta_keywords')

                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>

                                    @enderror

                                </div>



                            </div> --}}



                            {{-- <div class="col-md-12">

                                <div class="form-group">

                                    <label>Meta Description</label>

                                    <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description"></textarea>

                                    <p id="meta_description_error" style="display: none;color: red"></p>

                                </div>

                            </div> --}}





                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('adminwallet.index') }}"> Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"

                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"

                                    onclick="javascript:category_validation()">Submit</button>

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

    {{-- <script>

        $(function() {

            $("#name").keyup(function() {

                var Text = $(this).val();

                Text = Text.toLowerCase();

                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');

                $("#page_url").val(Text);

            });

        });

    </script> --}}



    <script>

        function category_validation() {



            var vendor_id = jQuery("#vendor_id").val();

            if (vendor_id == '') {
                jQuery('#vendor_id_error').html("Please Select Vendor");
                jQuery('#vendor_id_error').show().delay(0).fadeIn('show');
                jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#vendor_id').offset().top - 150
                }, 1000);
                return false;
            }

            var payment_type = jQuery("#payment_type").val();

            if (payment_type == '') {
                jQuery('#payment_type_error').html("Please Select Payment Type");
                jQuery('#payment_type_error').show().delay(0).fadeIn('show');
                jQuery('#payment_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#payment_type').offset().top - 150
                }, 1000);
                return false;
            }

            if(payment_type == 4){
            var deduct_reason = jQuery("#deduct_reason").val();

            if (deduct_reason == '') {
                jQuery('#deduct_reason_error').html("Please Enter Deduction Reason");
                jQuery('#deduct_reason_error').show().delay(0).fadeIn('show');
                jQuery('#deduct_reason_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#deduct_reason').offset().top - 150
                }, 1000);
                return false;
            }
            }




            var price = jQuery("#price").val();

            if (price == '') {
                jQuery('#price_error').html("Please Enter price");
                jQuery('#price_error').show().delay(0).fadeIn('show');
                jQuery('#price_error').show().delay(2000).fadeOut('show');
                
                return false;
            }
            var vendor_id = $('#vendor_id').val();
            var payment_type = $('#payment_type').val();

            // alert(vendor_id);
            // alert(payment_type);
            if(payment_type == 4){

                $.ajax({
                    type: "post",
                    url: "{{ url('vendor_wallet_check') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "vendor_id": vendor_id,
                        "payment_type": payment_type,
                        "price":price
                    },
                    success: function(returndata) {
                        if(returndata == 2){
                            $('#failed_message').text('The Deducted amount is greater than the vendor wallet balance.');
                            $('.failed_show').show().delay(0).fadeIn('show');
                            $('.failed_show').show().delay(5000).fadeOut('show');
                            $('html, body').animate({
                                scrollTop: $('#failed_message').offset().top - 150
                            }, 1000);
                            return false;
                            // $('#is_active_toggle').prop('checked', false);
                        }
                        if(returndata == 1){
                            $('#success_message').text('The Amount Deducted successfully');
                            $('.success_show').show().delay(0).fadeIn('show');
                            $('.success_show').show().delay(5000).fadeOut('show');

                            $('#spinner_button').show();

                            $('#submit_button').hide();

                            $('#category_form').submit();
                        }
                    }
                });

            }else{
                $('#spinner_button').show();
                $('#submit_button').hide();
                $('#category_form').submit();
            }
            




            

        }

        $("#vendor_id").select2();

    </script>
    <script>
        document.getElementById('payment_type').addEventListener('change', function() {
            var selectedValue = this.value;
            var deductReasonField = document.getElementById('deduct_reason_container');
            
            if (selectedValue == '4') {
                deductReasonField.style.display = 'block'; // Show the deduct reason field
            } else {
                deductReasonField.style.display = 'none'; // Hide the deduct reason field
            }
        });
    </script>

    {{-- <script>

        function category_change(group_id) {



            var url = '{{ url('group_shows_category') }}';



            $.ajax({

                url: url,

                type: 'post',

                data: {

                    "_token": "{{ csrf_token() }}",

                    "group_id": group_id

                },

                success: function(msg) {

                    document.getElementById('cat_id').innerHTML = msg;

                }



            });

        }

    </script> --}}


@stop


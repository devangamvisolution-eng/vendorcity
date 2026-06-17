@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Vendor Listing Price</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('price.index') }}">Vendor Listing Price</a></li>

                        <li class="breadcrumb-item active">Add Vendor Listing Price</li>

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

                        <form id="group_form" action="{{ route('price.store') }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="width: 100%;">Service Type</label>
                                        <div style="padding: 9px 0;">
                                            <label>
                                                <input type="radio" name="service_type" value="Based on Booking Services"
                                                    id="service_type">
                                                Based on Booking Services
                                            </label>
                                            <label>
                                                <input type="radio" name="service_type" value="Based on Listing Criteria"
                                                    id="service_type">
                                                Based on Listing Criteria
                                            </label>
                                        </div>
                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;">
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label for="name">Vendor Listing Price</label>

                                    <input id="price" name="price" type="text" class="form-control"
                                        placeholder="Enter Price" value="" />
                                    <p class="form-error-text" id="price_error" style="color: red; margin-top: 10px;"></p>

                                </div>





                            </div>






                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('price.index') }}"> Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:group_validation()">Submit</button>

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
        $(function() {

            $("#name").keyup(function() {

                var Text = $(this).val();

                Text = Text.toLowerCase();

                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');

                $("#page_url").val(Text);

            });

        });
    </script>



    <script>
        var radioButtons = document.querySelectorAll('input[type="radio"][name="service_type"]');

        function isRadioButtonSelected() {
            for (var i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    return true;
                }
            }
            return false;
        }

        function group_validation() {

            if (!isRadioButtonSelected()) {

                jQuery('#service_error').html("Please Select Service Type");
                jQuery('#service_error').show().delay(0).fadeIn('show');
                jQuery('#service_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#serviceid').offset().top - 150
                }, 1000);
                return false;

            }



            var price = jQuery("#price").val();

            if (price == '') {

                jQuery('#price_error').html("Please Enter Price");

                jQuery('#price_error').show().delay(0).fadeIn('show');

                jQuery('#price_error').show().delay(2000).fadeOut('show');

                return false;

            }


            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#group_form').submit();

        }
    </script>

@stop

@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit State</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="{{ route('state.index') }}">State</a></li>

                        <li class="breadcrumb-item active">Edit State</li>

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

                        <form id="category_form" action="{{ route('state.update', $state->id) }}" method="POST"

                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                <div class="form-group">

                                    <label for="name">Country</label>

                                    <select name="country_id" id="country_id" class="form-control">

                                        <option value=""> Select Country</option>

                                        @foreach ($all_country as $all_country_data)

                                            <option value="{{ $all_country_data['id'] }}"

                                                @if ($all_country_data['id'] == $state->country_id) {{ 'selected' }} @endif>

                                                {{ $all_country_data['country'] }}</option>

                                        @endforeach

                                    </select>
                                     <p class="form-error-text" id="country_id_error" style="color: red; margin-top: 10px;"></p>

                                </div>



                                <div class="form-group">

                                    <label for="name">State</label>

                                    <input id="state" name="state" type="text" class="form-control"

                                        placeholder="Enter State" value="{{ $state->state }}" />

                                         <p class="form-error-text" id="state_error" style="color: red; margin-top: 10px;"></p>

                                </div>



                            </div>



                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="{{ route('state.index') }}"> Cancel</a>



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

           var country_id = jQuery("#country_id").val();

            if (country_id == '') {
                jQuery('#country_id_error').html("Please Select Country");
                jQuery('#country_id_error').show().delay(0).fadeIn('show');
                jQuery('#country_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#country_id').offset().top - 150
                }, 1000);
                return false;
            }





            var state = jQuery("#state").val();

            if (state == '') {
                jQuery('#state_error').html("Please Enter State");
                jQuery('#state_error').show().delay(0).fadeIn('show');
                jQuery('#state_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#state').offset().top - 150
                }, 1000);
                return false;
            }







            $('#spinner_button').show();

            $('#submit_button').hide();



            $('#category_form').submit();

        }

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


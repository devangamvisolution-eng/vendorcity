@extends('admin.includes.Template')
@section('content')
    <style>
        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Packages Enquiry Detail</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Packages Enquiry Detail</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @php
            $userId = Auth::id();
        @endphp
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{-- route('delete_price') --}}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover">
                                    @if ($packages_enquiry != '')
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($packages_enquiry as $packages_enquiry_data)
                                            @if ($packages_enquiry_data->formfield_value != '')
                                                @if ($packages_enquiry_data->form_field_id != $i)
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>{!! Helper::form_fields($packages_enquiry_data->form_field_id) !!}</th>
                                                        </tr>
                                                    </thead>
                                                @endif
                                            @endif
                                            <tbody>
                                                <tr>
                                                    {{-- @if ($packages_enquiry_data->formfield_value != '')
                                                        <td>{{ $packages_enquiry_data->formfield_value }}</td>
                                                    @endif --}}
                                                    @if ($packages_enquiry_data->formfield_value != '')
                                                        @if (is_numeric($packages_enquiry_data->formfield_value) && $packages_enquiry_data->form_field_id != 30)
                                                            <td> {!! Helper::form_fields_attr($packages_enquiry_data->formfield_value) !!}</td>
                                                        @else
                                                            @php
                                                                $imageExtensions = [
                                                                    'jpg',
                                                                    'jpeg',
                                                                    'png',
                                                                    'gif',
                                                                    'jfif',
                                                                ];
                                                                $extension = pathinfo(
                                                                    $packages_enquiry_data->formfield_value,
                                                                    PATHINFO_EXTENSION,
                                                                );
                                                            @endphp
                                                            @if (in_array(strtolower($extension), $imageExtensions))
                                                                <td> <a class=""
                                                                        href="{{ url('admin/download/' . $packages_enquiry_data->formfield_value) }}">
                                                                        Download</a></td>
                                                            @else
                                                                <td>{{ $packages_enquiry_data->formfield_value }}</td>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </tr>
                                            </tbody>
                                            @php
                                                $get_more_id = DB::table('more_formfields_details_att')
                                                    ->where('form_id', '=', $packages_enquiry_data->form_field_id)
                                                    ->where(
                                                        'package_inquiry_id',
                                                        '=',
                                                        $packages_enquiry_data->package_inquiry_id,
                                                    )
                                                    ->get()
                                                    ->toArray();
                                            @endphp
                                            @if (isset($get_more_id) && count($get_more_id) > 0)
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Type of Home</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @foreach ($get_more_id as $get_more_id_data)
                                                            <td> {!! Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) !!}</td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            @endif
                                            @php
                                                $i = $packages_enquiry_data->form_field_id;
                                            @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>no data found</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto" style="float: inline-end;">
            <a class="btn btn-primary me-1"
                href="{{ route('accpet_form', [$packages_enquiry_data->package_inquiry_id, $userId]) }}">Accept</a>
            <a class="btn btn-danger" href="javascript:void('0');"
                onclick="Enquiry('{{ $packages_enquiry_data->package_inquiry_id }}','{{ $userId }}');">Reject
            </a>
        </div>
    </div>
    <!-- Delete  Modal -->
    <div class="modal custom-modal fade" id="delete_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure want to Accept</h3>
                        <p></p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal custom-modal fade" id="reject_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text ">
                        <!-- <h3>Delete Expense Category</h3> -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="invoice-table table table-bordered">
                                        <tbody>
                                            <form id="reject_form" method="post"
                                                action="{{ route('reason_reject_form') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="name">Reason</label><br><br><br>
                                                        <input type="hidden" name="inquiry_id" id="inquiry_id"
                                                            value="">
                                                        <input type="hidden" name="vendor_id" id="vendor_id"
                                                            value="">
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason1" value="I do not serve this city"><span> I do not
                                                            serve this city</span><br>
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason2" value="I do not provide this service"><span> I do
                                                            not provide this
                                                            service</span><br>
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason3"
                                                            value="I do not have availailty on this date"><span> I do not
                                                            have
                                                            availailty on this date</span><br>
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reason4"
                                                            value="Request includes goods that require special handling"><span>
                                                            Request
                                                            includes goods that require special handling </span><br>
                                                        <input type="radio" class="reject_reason" name="reject_reason"
                                                            id="reject_reason" value="Other"><span> Other</span><br>
                                                        <textarea name="reject_reason_text" id="reject_reason_textarea" cols="30" rows="10" class="form-control"
                                                            style="display: none;"></textarea>
                                                    </div>
                                                </div>
                                                <p class="form-error-text" id="reject_error"
                                                    style="color: red; margin-top: 10px;">
                                                </p>
                                                <button class="btn btn-primary" style="float: inline-end;" type="button"
                                                    onclick="javascript:reject_validation()">Add</button>
                                            </form>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->
    <form id="form_new" action="{{ route('accept_vendor_inquiry') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="inquiry_id" id="inquiry1_id" value="">
        <input type="hidden" name="vendor_id" id="vendor1_id" value="">
    </form>
@stop
@section('footer_js')
    <script>
        function delete_category(id, vendor_id) {
            $('#inquiry1_id').val(id);
            $('#vendor1_id').val(vendor_id);
            $('#delete_model').modal('show');
        }

        function form_sub() {
            $('#form_new').submit();
        }
    </script>
    <script>
        function Enquiry(id, userId) {
            $('#inquiry_id').val(id);
            $('#vendor_id').val(userId);
            $('#reject_model').modal('show');
        }
    </script>
    <script>
        function reject_validation() {
            if ($('input[name="reject_reason"]:checked').length === 0) {
                jQuery('#reject_error').html("Please Enter Reason");
                jQuery('#reject_error').show().delay(0).fadeIn('show');
                jQuery('#reject_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#reject_reason_textarea').offset().top - 150
                }, 1000);
                return false;
            }
            if ($('#reject_reason').is(':checked') && $('#reject_reason').val() === 'Other') {
                var textareaField = $('#reject_reason_textarea').val();
                if (textareaField == "") {
                    jQuery('#reject_error').html("Please Enter Reason");
                    jQuery('#reject_error').show().delay(0).fadeIn('show');
                    jQuery('#reject_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#reject_reason_textarea').offset().top - 150
                    }, 1000);
                    return false;
                }
            }
            $('#reject_form').submit();
        }
    </script>
    <script>
        $(document).ready(function() {
            // Add change event listener to the radio button
            $('.reject_reason').change(function() {
                // alert(this);
                // Check if the "Other" option is selected
                if ($(this).is(':checked') && $(this).val() === 'Other') {
                    // Show the textarea
                    $('#reject_reason_textarea').show();
                } else {
                    // Hide the textarea
                    $('#reject_reason_textarea').hide();
                }
            });
        });
    </script>
@stop

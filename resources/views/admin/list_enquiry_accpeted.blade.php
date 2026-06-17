@extends('admin.includes.Template')
@section('content')
    <style>
        /* Modern UI Variables */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --bg-light: #f8fafc;
        }

        .detail-card {
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .detail-header {
            background: #4c7aef;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-classic);
        }

        .detail-header h4 {
            color: #ffffff;
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .info-item {
            padding: 1rem;
            background: var(--bg-light);
            border-radius: 8px;
            border: 1px solid var(--border-classic);
            transition: all 0.2s ease;
        }

        .info-item:hover {
            border-color: var(--action-blue);
            background: #fff;
        }

        .info-label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .info-value {
            display: block;
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 500;
            word-break: break-word;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            background: var(--action-blue);
            color: white !important;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-home-type {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-top: 0.5rem;
        }

        #delete_model_1 .modal-dialog {
            max-width: 50% !important;
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Packages Enquiry Detail</h3>
                    <ul class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Packages Enquiry Detail</li>
                    </ul>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="detail-card">
            <div class="detail-header">
                <h4><i class="fas fa-info-circle me-2"></i>Enquiry Information</h4>
            </div>

            <div class="card-body p-0">
                <div class="info-grid">
                    @if ($packages_enquiry != '' && count($packages_enquiry) > 0)
                        @foreach ($packages_enquiry as $packages_enquiry_data)
                            @if ($packages_enquiry_data->formfield_value != '')
                                <div class="info-item shadow-sm">
                                    <span class="info-label">{!! Helper::form_fields($packages_enquiry_data->form_field_id) !!}</span>
                                    <span class="info-value">
                                        @if (is_numeric($packages_enquiry_data->formfield_value) && $packages_enquiry_data->form_field_id != 30)
                                            {!! Helper::form_fields_attr($packages_enquiry_data->formfield_value) !!}
                                        @else
                                            @php
                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
                                                $extension = pathinfo(
                                                    $packages_enquiry_data->formfield_value,
                                                    PATHINFO_EXTENSION,
                                                );
                                            @endphp
                                            @if (in_array(strtolower($extension), $imageExtensions))
                                                <a class="download-btn"
                                                    href="{{ url('admin/download/' . $packages_enquiry_data->formfield_value) }}">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                            @else
                                                {{ $packages_enquiry_data->formfield_value }}
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            @endif

                            {{-- Logic for "More" attributes --}}
                            @php
                                $get_more_id = DB::table('more_formfields_details_att')
                                    ->where('form_id', '=', $packages_enquiry_data->form_field_id)
                                    ->where('package_inquiry_id', '=', $packages_enquiry_data->package_inquiry_id)
                                    ->get();
                            @endphp

                            @if (isset($get_more_id) && count($get_more_id) > 0)
                                <div class="info-item shadow-sm ">
                                    <span class="info-label">Type of Home / Additional Details</span>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($get_more_id as $get_more_id_data)
                                            <span class="badge-home-type">
                                                {!! Helper::form_fields_attr_more($get_more_id_data->more_form_attributes_id) !!}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if (isset($userdata))
                            @if (isset($userdata->name))
                                <div class="info-item shadow-sm">
                                    <span class="info-label">Customer Name</span>
                                    <span class="info-value">
                                        {{ $userdata->name }}
                                    </span>
                                </div>
                            @endif
                            @if (isset($userdata->name))
                                <div class="info-item shadow-sm">
                                    <span class="info-label">Customer Mobile</span>
                                    <span class="info-value">
                                        {{ $userdata->mobile }}
                                    </span>
                                </div>
                            @endif
                            @if (isset($userdata->name))
                                <div class="info-item shadow-sm">
                                    <span class="info-label">Customer Email</span>
                                    <span class="info-value">
                                        {{ $userdata->email }}
                                    </span>
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="text-center p-5 w-100">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No inquiry data found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS - Kept exactly as original --}}
    <div class="modal custom-modal fade" id="delete_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure want to Accept</h3>
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
                    <div class="modal-text">
                        <form id="reject_form" method="post" action="{{ route('reason_reject_form') }}">
                            @csrf
                            <div class="form-group">
                                <label class="mb-3 fw-bold">Select Reason for Rejection</label>
                                <input type="hidden" name="inquiry_id" id="inquiry_id" value="">
                                <input type="hidden" name="vendor_id" id="vendor_id" value="">

                                <div class="mb-2"><input type="radio" class="reject_reason" name="reject_reason"
                                        id="reason1" value="I do not serve this city"><span> I do not serve this
                                        city</span></div>
                                <div class="mb-2"><input type="radio" class="reject_reason" name="reject_reason"
                                        id="reason2" value="I do not provide this service"><span> I do not provide this
                                        service</span></div>
                                <div class="mb-2"><input type="radio" class="reject_reason" name="reject_reason"
                                        id="reason3" value="I do not have availailty on this date"><span> I do not have
                                        availailty on this date</span></div>
                                <div class="mb-2"><input type="radio" class="reject_reason" name="reject_reason"
                                        id="reason4" value="Request includes goods that require special handling"><span>
                                        Request includes goods that require special handling </span></div>
                                <div class="mb-2"><input type="radio" class="reject_reason" name="reject_reason"
                                        id="reject_reason" value="Other"><span> Other</span></div>

                                <textarea name="reject_reason_text" id="reject_reason_textarea" cols="30" rows="4"
                                    class="form-control mt-2" style="display: none;"></textarea>
                            </div>
                            <p class="form-error-text" id="reject_error" style="color: red; margin-top: 10px;"></p>
                            <div class="text-end mt-3">
                                <button class="btn btn-primary" type="button"
                                    onclick="javascript:reject_validation()">Submit Rejection</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

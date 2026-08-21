@extends('admin.includes.Template')
<link rel="stylesheet" href="{{ asset('public/site/css/intlTelInput.css') }}">
<style>
    .iti {
        width: 100%;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
    }
</style>
<script src="{{ asset('public/site/js/intlTelInput.min.js') }}"></script>
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Add General Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('general-enquiries.index') }}">Enquiries</a></li>
                        <li class="breadcrumb-item active">Add Enquiry</li>
                    </ul>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('general-enquiries.store') }}" method="POST" id="addEnquiryForm">
                            @csrf
                            <div class="row">
                                <!-- Customer Selection -->
                                <div class="col-md-12 mb-4">
                                    <h5>Customer Details</h5>
                                    <hr>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Select Existing Customer (Optional)</label>
                                    <select class="form-select select2" name="customer_id" id="customer_id">
                                        <option value="">-- Manual Entry (New Customer) --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}
                                                ({{ $customer->mobile }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3"></div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name">
                                    <p class="form-error-text" id="name_error"
                                        style="color: red; margin-top: 10px; display: none;"></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Customer Email</label>
                                    <input type="email" class="form-control" name="customer_email" id="customer_email">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="hidden" name="country_code" id="country_code" value="">
                                    <input id="customer_phone" name="customer_phone" type="text" class="form-control"
                                        placeholder="Enter Mobile" value="" style="width: 100%;" />
                                    <p class="form-error-text" id="phone_error"
                                        style="color: red; margin-top: 10px; display: none;"></p>
                                </div>

                                <!-- Enquiry Details -->
                                <div class="col-md-12 mb-4 mt-3">
                                    <h5>Enquiry Details</h5>
                                    <hr>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Enquiry Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="enquiry_date" id="enquiry_date"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Service <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="service_id" id="service_id">
                                        <option value="">-- Select Service --</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->servicename }}</option>
                                        @endforeach
                                        <option value="other">Other / Unknown</option>
                                    </select>
                                    <p class="form-error-text" id="service_error"
                                        style="color: red; margin-top: 10px; display: none;"></p>
                                </div>

                                <div class="col-md-4 mb-3" id="other_service_div" style="display: none;">
                                    <label class="form-label">Specify Unknown Service <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="other_service" id="other_service">
                                    <p class="form-error-text" id="other_service_error"
                                        style="color: red; margin-top: 10px; display: none;"></p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sub Service</label>
                                    <select class="form-select select2" name="subservice_id" id="subservice_id">
                                        <option value="">-- Select Sub Service --</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Source of Lead</label>
                                    <select class="form-select select2" name="source_lead_id[]" id="source_lead_id"
                                        multiple>
                                        @foreach ($source_leads as $source)
                                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select select2" name="status" id="status">
                                        <option value="Pending">Pending</option>
                                        <option value="Followup">Followup</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Booked">Booked</option>
                                        <option value="Lost">Lost</option>
                                        <option value="Invalid">Invalid</option>
                                        <option value="Vendor">Vendor</option>
                                        <option value="Job">Job</option>
                                    </select>
                                </div>
                            </div>
                            <!--
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Notes</label>
                                                <textarea class="form-control" name="notes" id="notes" rows="3"
                                                    placeholder="Enter any notes or special requests here..."></textarea>
                                            </div>
                                        </div>
                                        -->

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Save
                                    Enquiry</button>
                                <button class="btn btn-primary btn-lg" type="button" disabled id="spinnerBtn"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Auto-fill customer details
            $('#customer_id').on('change', function() {
                var customerId = $(this).val();
                if (customerId) {
                    $.ajax({
                        url: "{{ route('general-enquiries.get-customer-details') }}",
                        type: "POST",
                        data: {
                            customer_id: customerId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#customer_name').val(response.name);
                                $('#customer_email').val(response.email);
                                $('#customer_phone').val(response.phone);
                                $('#country_code').val(response.country_code);
                            }
                        }
                    });
                } else {
                    $('#customer_name').val('');
                    $('#customer_email').val('');
                    $('#customer_phone').val('');
                    $('#country_code').val('+971');
                }
            });

            // Sub Service dependent dropdown & Other Service Check
            $('#service_id').on('change', function() {
                var serviceId = $(this).val();

                if (serviceId === 'other') {
                    $('#other_service_div').show();
                    $('#subservice_id').empty();
                    $('#subservice_id').append('<option value="">-- Select Sub Service --</option>');
                } else {
                    $('#other_service_div').hide();
                    $('#other_service').val('');

                    if (serviceId) {
                        $.ajax({
                            url: "{{ route('general-enquiries.get-subservices') }}",
                            type: "POST",
                            data: {
                                service_id: serviceId,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                $('#subservice_id').empty();
                                $('#subservice_id').append(
                                    '<option value="">-- Select Sub Service --</option>');
                                $.each(data, function(key, value) {
                                    $('#subservice_id').append('<option value="' + value
                                        .id + '">' + value.subservicename +
                                        '</option>');
                                });
                            }
                        });
                    } else {
                        $('#subservice_id').empty();
                        $('#subservice_id').append('<option value="">-- Select Sub Service --</option>');
                    }
                }
            });

            // Form Submit Interception for Duplicate Check & Validation
            $('#addEnquiryForm').on('submit', function(e) {
                e.preventDefault();

                // Validation
                var name = $('#customer_name').val();
                if (name == '') {
                    $('#name_error').html("Please Enter Name");
                    $('#name_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#customer_name').offset().top - 150
                    }, 1000);
                    return false;
                }

                var phone = $('#customer_phone').val();
                if (phone == '') {
                    $('#phone_error').html("Please Enter Phone");
                    $('#phone_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#customer_phone').offset().top - 150
                    }, 1000);
                    return false;
                }

                var service = $('#service_id').val();
                if (service == '') {
                    $('#service_error').html("Please Select Service");
                    $('#service_error').show().delay(2000).fadeOut('show');
                    $('html, body').animate({
                        scrollTop: $('#service_id').offset().top - 150
                    }, 1000);
                    return false;
                }

                if (service === 'other') {
                    var otherService = $('#other_service').val();
                    if (otherService == '') {
                        $('#other_service_error').html("Please Specify Unknown Service");
                        $('#other_service_error').show().delay(2000).fadeOut('show');
                        $('html, body').animate({
                            scrollTop: $('#other_service').offset().top - 150
                        }, 1000);
                        return false;
                    }
                }

                var customerId = $('#customer_id').val();

                $('#submitBtn').prop('disabled', true);

                // If manual entry, check if mobile exists
                if (!customerId && phone) {
                    $.ajax({
                        url: "{{ route('general-enquiries.check-customer-exist') }}",
                        type: "POST",
                        data: {
                            phone: phone,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.exists) {
                                Swal.fire({
                                    title: 'Customer Exists!',
                                    text: "A customer (" + response.name +
                                        ") with this mobile number already exists. Do you want to use the existing customer?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, use existing'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Set dropdown to existing and submit
                                        $('#customer_id').val(response.customer_id)
                                            .trigger('change');
                                        // small delay to let change event finish
                                        setTimeout(function() {
                                            $('#submitBtn').hide();
                                            $('#spinnerBtn').show();
                                            $('#addEnquiryForm')[0].submit();
                                        }, 500);
                                    } else {
                                        $('#submitBtn').prop('disabled', false);
                                    }
                                });
                            } else {
                                // Safe to submit, no duplicate
                                $('#submitBtn').hide();
                                $('#spinnerBtn').show();
                                $('#addEnquiryForm')[0].submit();
                            }
                        },
                        error: function() {
                            $('#submitBtn').prop('disabled', false);
                        }
                    });
                } else {
                    $('#submitBtn').hide();
                    $('#spinnerBtn').show();
                    $('#addEnquiryForm')[0].submit();
                }
            });

            // intlTelInput initialization
            const Otpphoneinput = document.querySelector("#customer_phone");
            const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
                initialCountry: "ae",
                separateDialCode: true,
                autoPlaceholder: "aggressive",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });

            const countryCodeInput = document.querySelector("#country_code");

            function setCountryCode() {
                const countryData = Otpphoneinputnew.getSelectedCountryData();
                countryCodeInput.value = "+" + countryData.dialCode;
            }

            setCountryCode();
            Otpphoneinput.addEventListener("countrychange", function() {
                setCountryCode();
            });
        });
    </script>
@endsection

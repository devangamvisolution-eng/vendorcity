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
                    <h3 class="page-title">Edit General Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('general-enquiries.index') }}">Enquiries</a></li>
                        <li class="breadcrumb-item active">Edit Enquiry</li>
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
                        <form action="{{ route('general-enquiries.update', $enquiry->id) }}" method="POST"
                            id="editEnquiryForm">
                            @csrf
                            @method('PUT')
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
                                            <option value="{{ $customer->id }}"
                                                {{ $enquiry->customer_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->mobile }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3"></div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="customer_name" id="customer_name"
                                        value="{{ $enquiry->customer_name }}">
                                    <p class="form-error-text" id="name_error"
                                        style="color: red; margin-top: 10px; display: none;"></p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Customer Email</label>
                                    <input type="email" class="form-control" name="customer_email" id="customer_email"
                                        value="{{ $enquiry->customer_email }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="hidden" name="country_code" id="country_code"
                                        value="{{ $enquiry->country_code ?: '+971' }}">
                                    <input id="customer_phone" name="customer_phone" type="text" class="form-control"
                                        placeholder="Enter Mobile" value="{{ $enquiry->customer_phone }}"
                                        style="width: 100%;" />
                                    <p class="form-error-text" id="phone_error"
                                        style="color: red; margin-top: 10px; display: none;"></p>
                                </div>

                                <!-- Enquiry Details -->
                                <div class="col-md-12 mb-4 mt-3">
                                    <h5>Enquiry Details</h5>
                                    <hr>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Service <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="service_id" id="service_id">
                                        <option value="">-- Select Service --</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $enquiry->service_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->servicename }}</option>
                                        @endforeach
                                    </select>
                                    <p class="form-error-text" id="service_error"
                                        style="color: red; margin-top: 10px; display: none;"></p>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sub Service</label>
                                    <select class="form-select select2" name="subservice_id" id="subservice_id">
                                        <option value="">-- Select Sub Service --</option>
                                        @foreach ($subservices as $sub)
                                            <option value="{{ $sub->id }}"
                                                {{ $enquiry->subservice_id == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->subservicename }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Source of Lead</label>
                                    @php
                                        $selectedSources = explode(',', $enquiry->source_lead_id);
                                    @endphp
                                    <select class="form-select select2" name="source_lead_id[]" id="source_lead_id"
                                        multiple>
                                        @foreach ($source_leads as $source)
                                            <option value="{{ $source->id }}"
                                                {{ in_array($source->id, $selectedSources) ? 'selected' : '' }}>
                                                {{ $source->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select select2" name="status" id="status">
                                        <option value="Pending" {{ $enquiry->status == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Followup" {{ $enquiry->status == 'Followup' ? 'selected' : '' }}>
                                            Followup</option>
                                        <option value="Completed" {{ $enquiry->status == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="Booked" {{ $enquiry->status == 'Booked' ? 'selected' : '' }}>Booked
                                        </option>
                                        <option value="Lost" {{ $enquiry->status == 'Lost' ? 'selected' : '' }}>Lost
                                        </option>
                                        <option value="Invalid" {{ $enquiry->status == 'Invalid' ? 'selected' : '' }}>
                                            Invalid</option>
                                        <option value="Vendor" {{ $enquiry->status == 'Vendor' ? 'selected' : '' }}>Vendor
                                        </option>
                                        <option value="Job" {{ $enquiry->status == 'Job' ? 'selected' : '' }}>Job
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" id="notes" rows="3"
                                        placeholder="Enter any notes or special requests here...">{{ $enquiry->notes }}</textarea>
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Update
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
                }
            });

            // Sub Service dependent dropdown
            $('#service_id').on('change', function() {
                var serviceId = $(this).val();
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
                                    .id + '">' + value.subservicename + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subservice_id').empty();
                    $('#subservice_id').append('<option value="">-- Select Sub Service --</option>');
                }
            });

            // Form Submit Interception for Duplicate Check & Validation
            $('#editEnquiryForm').on('submit', function(e) {
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

                var customerId = $('#customer_id').val();

                $('#submitBtn').prop('disabled', true);

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
                                        $('#customer_id').val(response.customer_id)
                                            .trigger('change');
                                        setTimeout(function() {
                                            $('#submitBtn').hide();
                                            $('#spinnerBtn').show();
                                            $('#editEnquiryForm')[0].submit();
                                        }, 500);
                                    } else {
                                        $('#submitBtn').prop('disabled', false);
                                    }
                                });
                            } else {
                                $('#submitBtn').hide();
                                $('#spinnerBtn').show();
                                $('#editEnquiryForm')[0].submit();
                            }
                        },
                        error: function() {
                            $('#submitBtn').prop('disabled', false);
                        }
                    });
                } else {
                    $('#submitBtn').hide();
                    $('#spinnerBtn').show();
                    $('#editEnquiryForm')[0].submit();
                }
            });

            // intlTelInput initialization
            function getCountryCodeFromDialCode(dialCode) {
                const countryData = window.intlTelInputGlobals.getCountryData();
                for (let i = 0; i < countryData.length; i++) {
                    if (countryData[i].dialCode == dialCode) return countryData[i].iso2;
                }
                return "ae"; // fallback
            }

            const Otpphoneinput = document.querySelector("#customer_phone");
            const countryCodeInput = document.querySelector("#country_code");
            const savedDialCode = countryCodeInput.value ? countryCodeInput.value.replace('+', '') : null;

            const Otpphoneinputnew = window.intlTelInput(Otpphoneinput, {
                initialCountry: savedDialCode ? getCountryCodeFromDialCode(savedDialCode) : "ae",
                separateDialCode: true,
                autoPlaceholder: "aggressive",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
            });

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

@extends('admin.includes.Template')
@section('content')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/formnew.css') }}">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Enquiry</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('erp_enquiry.lists') }}">Enquiry</a></li>
                            <li class="breadcrumb-item active">Edit Enquiry</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="custom-card">
                    <div class="card-header">
                        <h4><i class="fas fa-edit me-2"></i> Update Enquiry: {{ $erp_enquiry->quote_no }}</h4>
                    </div>
                    <div class="card-body">

                        <form id="erp_enquiry_form" action="{{ route('erp_enquiry.update', $erp_enquiry->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger mb-4"
                                    style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 8px;">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong style="font-weight: 700;">Please correct the following errors:</strong>
                                    </div>
                                    <ul class="mb-0" style="padding-left: 1.5rem; font-size: 13px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Basic Information -->
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Basic Information
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label" for="customer_type">Customer Type<span
                                            class="required-star">*</span></label>
                                    <select name="customer_type" id="customer_type" class="form-select select">
                                        <option value="">Select Customer Type</option>
                                        @foreach ($customer_type as $customer_type_data)
                                            <option value="{{ $customer_type_data->id }}"
                                                {{ old('customer_type', $erp_enquiry->customer_type) == $customer_type_data->id ? 'selected' : '' }}>
                                                {{ $customer_type_data->customer_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_type')
                                        <div class="form-error-text text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-error-text text-danger" id="customer_type_error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label" for="service">Service<span
                                            class="required-star">*</span></label>
                                    <select name="service" id="service" class="form-select select"
                                        onchange="service_change(this.value)">
                                        <option value="">Select Service</option>
                                        @foreach ($service_data as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('service', $erp_enquiry->service) == $data->id ? 'selected' : '' }}>
                                                {{ $data->servicename }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service')
                                        <div class="form-error-text text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-error-text text-danger" id="service_error"></div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label" for="enquiry_date">Enquiry Date<span
                                            class="required-star">*</span></label>
                                    <input id="enquiry_date" name="enquiry_date" type="text" class="form-control"
                                        value="{{ old('enquiry_date', $erp_enquiry->enquiry_date) }}"
                                        placeholder="YYYY-MM-DD" autocomplete="off" />
                                    @error('enquiry_date')
                                        <div class="form-error-text text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-error-text text-danger" id="enquiry_date_error"></div>
                                </div>
                            </div>

                            <!-- Client Details Toggle -->
                            <div class="checkbox-group mt-4">
                                <input type="checkbox" id="client_box" name="client_box" value="1"
                                    onchange="clientvisibility()"
                                    {{ old('client_box', $erp_enquiry->client_box) == 0 ? 'checked' : '' }}>
                                <label for="client_box">Enable Client Details</label>
                            </div>

                            <div id="client_fields"
                                class="{{ old('client_box', $erp_enquiry->client_box) == 0 ? '' : 'hidden' }}">
                                <div class="section-title">
                                    <i class="fas fa-user-tie"></i> Client Details
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="client_name">Client Name<span
                                                class="required-star">*</span></label>
                                        <input id="client_name" name="client_name" type="text" class="form-control"
                                            value="{{ old('client_name', $erp_enquiry->client_name) }}"
                                            placeholder="Enter Client Name" />
                                        @error('client_name')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="client_name_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="client_email">Client Email</label>
                                        <input id="client_email" name="client_email" type="email" class="form-control"
                                            value="{{ old('client_email', $erp_enquiry->client_email) }}"
                                            placeholder="Enter Client Email" />
                                        @error('client_email')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="client_email_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="client_mobile">Client Mobile<span
                                                class="required-star">*</span></label>
                                        <input id="client_mobile" name="client_mobile" type="text"
                                            class="form-control"
                                            value="{{ old('client_mobile', $erp_enquiry->client_mobile) }}"
                                            placeholder="Enter Client Mobile" />
                                        @error('client_mobile')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="client_mobile_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="contact_person">Contact Person</label>
                                        <input id="contact_person" name="contact_person" type="text"
                                            class="form-control"
                                            value="{{ old('contact_person', $erp_enquiry->contact_person) }}"
                                            placeholder="Enter Contact Person" />
                                        @error('contact_person')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="contact_person_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="contact_person_mobile">Contact Person
                                            Mobile</label>
                                        <input id="contact_person_mobile" name="contact_person_mobile" type="text"
                                            class="form-control"
                                            value="{{ old('contact_person_mobile', $erp_enquiry->contact_person_mobile) }}"
                                            placeholder="Enter Contact Mobile" />
                                        @error('contact_person_mobile')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="contact_person_mobile_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="address">Address<span
                                                class="required-star">*</span></label>
                                        <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter Address">{{ old('address', $erp_enquiry->address) }}</textarea>
                                        <div class="form-error-text text-danger" id="address_error"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Move Details Toggle -->
                            <div id="origin_desti_move_div" class="checkbox-group mt-3"
                                style="{{ old('service', $erp_enquiry->service) == 30 ? '' : 'display: none;' }}">
                                <input type="checkbox" id="origin_desti_move" name="origin_desti_move"
                                    onchange="originmovevisibility()" value="1"
                                    {{ old('origin_desti_move', $erp_enquiry->origin_desti_move) == 0 ? 'checked' : '' }}>
                                <label for="origin_desti_move">Enable Move Details</label>
                            </div>

                            <div id="origin_desti_move_fields"
                                class="{{ old('origin_desti_move', $erp_enquiry->origin_desti_move) == 0 ? '' : 'hidden' }}">
                                <div class="section-title">
                                    <i class="fas fa-truck-moving"></i> Move Details
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="desc_of_goods">Description of Goods<span
                                                class="required-star">*</span></label>
                                        <input id="desc_of_goods" name="desc_of_goods" type="text"
                                            class="form-control"
                                            value="{{ old('desc_of_goods', $erp_enquiry->desc_of_goods) }}"
                                            placeholder="Enter Description" />
                                        @error('desc_of_goods')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="desc_of_goods_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="service_required">Service Required</label>
                                        <input id="service_required" name="service_required" type="text"
                                            class="form-control"
                                            value="{{ old('service_required', $erp_enquiry->service_required) }}"
                                            placeholder="Enter Service Required" />
                                        @error('service_required')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="service_required_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="mode_of_transport">Mode of Transport</label>
                                        <input id="mode_of_transport" name="mode_of_transport" type="text"
                                            class="form-control"
                                            value="{{ old('mode_of_transport', $erp_enquiry->mode_of_transport) }}"
                                            placeholder="Enter Transport Mode" />
                                        @error('mode_of_transport')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="mode_of_transport_error"></div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label" for="estimated_volume">Estimated Volume (CBM)</label>
                                        <input id="estimated_volume" name="estimated_volume" type="text"
                                            class="form-control"
                                            value="{{ old('estimated_volume', $erp_enquiry->estimated_volume) }}"
                                            placeholder="Enter Volume" />
                                        @error('estimated_volume')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="estimated_volume_error"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Origin -->
                                    <div class="col-lg-6 mt-4">
                                        <div class="section-title mt-0">
                                            <i class="fas fa-map-marker-alt"></i> Origin / Pickup
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input name="origin_add" type="text" class="form-control"
                                                value="{{ old('origin_add', $erp_enquiry->origin_add) }}"
                                                placeholder="Origin Address" />
                                            @error('origin_add')
                                                <div class="form-error-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Country</label>
                                            <select name="origin_country" class="form-select">
                                                <option value="">Select Country</option>
                                                @foreach ($country_data as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('origin_country', $erp_enquiry->origin_country) == $country->id ? 'selected' : '' }}>
                                                        {{ $country->country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">State</label>
                                                <input name="origin_state" type="text" class="form-control"
                                                    value="{{ old('origin_state', $erp_enquiry->origin_state) }}"
                                                    placeholder="State" />
                                                @error('origin_state')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">City</label>
                                                <input name="origin_city" type="text" class="form-control"
                                                    value="{{ old('origin_city', $erp_enquiry->origin_city) }}"
                                                    placeholder="City" />
                                                @error('origin_city')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Location</label>
                                                <input name="origin_location" type="text" class="form-control"
                                                    value="{{ old('origin_location', $erp_enquiry->origin_location) }}"
                                                    placeholder="Location" />
                                                @error('origin_location')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">ZIP Code</label>
                                                <input name="origin_zip_post" type="text" class="form-control"
                                                    value="{{ old('origin_zip_post', $erp_enquiry->origin_zip_post) }}"
                                                    placeholder="ZIP" />
                                                @error('origin_zip_post')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Destination -->
                                    <div class="col-lg-6 mt-4">
                                        <div class="section-title mt-0">
                                            <i class="fas fa-map-pin"></i> Destination / Delivery
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input name="desti_add" type="text" class="form-control"
                                                value="{{ old('desti_add', $erp_enquiry->desti_add) }}"
                                                placeholder="Destination Address" />
                                            @error('desti_add')
                                                <div class="form-error-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Country</label>
                                            <select name="desti_country" class="form-select">
                                                <option value="">Select Country</option>
                                                @foreach ($country_data as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('desti_country', $erp_enquiry->desti_country) == $country->id ? 'selected' : '' }}>
                                                        {{ $country->country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">State</label>
                                                <input name="desti_state" type="text" class="form-control"
                                                    value="{{ old('desti_state', $erp_enquiry->desti_state) }}"
                                                    placeholder="State" />
                                                @error('desti_state')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">City</label>
                                                <input name="desti_city" type="text" class="form-control"
                                                    value="{{ old('desti_city', $erp_enquiry->desti_city) }}"
                                                    placeholder="City" />
                                                @error('desti_city')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Location</label>
                                                <input name="desti_location" type="text" class="form-control"
                                                    value="{{ old('desti_location', $erp_enquiry->desti_location) }}"
                                                    placeholder="Location" />
                                                @error('desti_location')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">ZIP Code</label>
                                                <input name="desti_zip_post" type="text" class="form-control"
                                                    value="{{ old('desti_zip_post', $erp_enquiry->desti_zip_post) }}"
                                                    placeholder="ZIP" />
                                                @error('desti_zip_post')
                                                    <div class="form-error-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- General Information Toggle -->
                            <div class="checkbox-group mt-4">
                                <input type="checkbox" id="general_info_details" name="general_info_details"
                                    onchange="general_infovisibility()" value="1"
                                    {{ old('general_info_details', $erp_enquiry->general_info_details) == 0 ? 'checked' : '' }}>
                                <label for="general_info_details">Enable General Information</label>
                            </div>

                            <div id="general_info_fields"
                                class="{{ old('general_info_details', $erp_enquiry->general_info_details) == 0 ? '' : 'hidden' }}">
                                <div class="section-title">
                                    <i class="fas fa-cogs"></i> General Information
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <label class="form-label">Source Of Contact<span
                                                class="required-star">*</span></label>
                                        <select name="sourcelead_id" class="form-select">
                                            <option value="">Select Source</option>
                                            @foreach ($sourcelead_data as $sourcelead)
                                                <option value="{{ $sourcelead->id }}"
                                                    {{ old('sourcelead_id', $erp_enquiry->sourcelead_id) == $sourcelead->id ? 'selected' : '' }}>
                                                    {{ $sourcelead->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sourcelead_id')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-error-text text-danger" id="sourcelead_id_error"></div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label class="form-label">Enquiry Mode<span class="required-star">*</span></label>
                                        <select name="enquiry_mode" class="form-select">
                                            <option value="">Select Mode</option>
                                            @foreach ($enquiry_mode_data as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('enquiry_mode', $erp_enquiry->enquiry_mode) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->enquiry_mode }}</option>
                                            @endforeach
                                        </select>
                                        @error('enquiry_mode')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label class="form-label">Status<span class="required-star">*</span></label>
                                        <select name="status_id" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="0"
                                                {{ old('status_id', $erp_enquiry->status_id) == '0' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="1"
                                                {{ old('status_id', $erp_enquiry->status_id) == '1' ? 'selected' : '' }}>
                                                Completed
                                            </option>
                                        </select>
                                        @error('status_id')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label class="form-label">Assign To<span class="required-star">*</span></label>
                                        <select name="salesperson_id" class="form-select">
                                            <option value="">Select Salesperson</option>
                                            @foreach ($salesperson_data as $salesperson)
                                                <option value="{{ $salesperson->id }}"
                                                    {{ old('salesperson_id', $erp_enquiry->salesperson_id) == $salesperson->id ? 'selected' : '' }}>
                                                    {{ $salesperson->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('salesperson_id')
                                            <div class="form-error-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label class="form-label">Notes</label>
                                        <textarea id="notes" name="notes" class="form-control">{{ old('notes', $erp_enquiry->notes) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-12 text-end">
                                    <a href="{{ route('erp_enquiry.lists') }}" class="btn-cancel">
                                        <i class="fas fa-times me-2"></i> Cancel
                                    </a>
                                    <button type="button" class="btn-submit" id="submit_button"
                                        onclick="category_validation()">
                                        <i class="fas fa-check-circle"></i> Update Enquiry
                                    </button>
                                    <button class="btn-submit" type="button" disabled id="spinner_button"
                                        style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Processing...
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('footer_js')
    @if ($message = Session::get('success'))
        <script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Success!',
                    text: "{{ $message }}",
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                    background: '#ffffff',
                    iconColor: '#10b981'
                });
            });
        </script>
    @endif
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor

            .create(document.querySelector('#notes'))

            .catch(error => {

                console.error(error);

            });
    </script>
    <script>
        $(document).ready(function() {
            // Call it once on page load using the current selected value
            service_change($('#service').val());
        });

        function service_change(value) {

            if (value == 30) {
                $('#origin_desti_move_div').show();
                // Trigger checkbox visibility check
                originmovevisibility();
            } else {
                $('#origin_desti_move_div').hide();
                $('#origin_desti_move_fields').addClass('hidden');
            }

        }

        function clientvisibility() {
            const checkbox = document.getElementById('client_box');
            const container = document.getElementById('client_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function originmovevisibility() {
            const checkbox = document.getElementById('origin_desti_move');
            const container = document.getElementById('origin_desti_move_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function general_infovisibility() {
            const checkbox = document.getElementById('general_info_details');
            const container = document.getElementById('general_info_fields');
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
    <script>
        function category_validation() {
            var customer_type = jQuery("#customer_type").val();
            if (customer_type == '') {
                Swal.fire({
                    title: 'Required Field',
                    text: "Please select Customer Type",
                    icon: 'error',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            var service = jQuery("#service").val();
            if (service == '') {
                Swal.fire({
                    title: 'Required Field',
                    text: "Please select Service",
                    icon: 'error',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            var enquiry_date = jQuery("#enquiry_date").val();
            if (enquiry_date == '') {
                Swal.fire({
                    title: 'Required Field',
                    text: "Please select Enquiry Date",
                    icon: 'error',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            // Client Details Validation (if enabled)
            if ($("#client_box").is(":checked")) {
                if (jQuery("#client_name").val() == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please enter Client Name",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
                var client_mobile = jQuery("#client_mobile").val();
                if (client_mobile == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please enter Client Mobile",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
                if (client_mobile != '' && (client_mobile.length < 7 || client_mobile.length > 15)) {
                    Swal.fire({
                        title: 'Invalid Input',
                        text: "Please enter a valid Mobile Number",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
                if (jQuery("#address").val() == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please enter Address",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
            }

            // Move Details Validation (if enabled)
            if ($("#service").val() == 30 && $("#origin_desti_move").is(":checked")) {
                if (jQuery("#desc_of_goods").val() == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please enter Description of Goods",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
            }

            // General Information Validation (if enabled)
            if ($("#general_info_details").is(":checked")) {
                if (jQuery("select[name='sourcelead_id']").val() == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please select Source of Contact",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
                if (jQuery("select[name='enquiry_mode']").val() == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please select Enquiry Mode",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
                if (jQuery("select[name='status_id']").val() == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please select Status",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
                if (jQuery("select[name='salesperson_id']").val() == '') {
                    Swal.fire({
                        title: 'Required Field',
                        text: "Please select Assign To",
                        icon: 'error',
                        confirmButtonColor: '#3b82f6'
                    });
                    return false;
                }
            }

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#erp_enquiry_form').submit();
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
    <script type="text/javascript">
        $(function() {
            $('#enquiry_date').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true
            });
        });
    </script>
@stop

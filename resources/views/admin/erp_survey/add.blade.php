@extends('admin.includes.Template')
@section('content')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/formnew.css') }}">
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Survey Asssign</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('erp_survey.lists') }}">Survey</a></li>
                        <li class="breadcrumb-item active">Add Survey Asssign</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="custom-card">
                    <div class="card-header">
                        <h4><i class="fas fa-plus-circle me-2"></i> Assign Survey Details</h4>
                    </div>
                    <div class="card-body">

                        <form id="erp_enquiry_form" action="{{ route('erp_survey.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Enquiry ID</label>
                                    <input type="text" class="form-control" value="{{ $followup_data->quote_no }}"
                                        readonly />
                                    <input id="inquiry_id_hidden" name="inquiry_id_hidden" type="hidden"
                                        class="form-control" value="{{ $followup_data->id }}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Survey ID</label>
                                    <input type="text" class="form-control" value="{{ $followup_data->survey_id }}"
                                        readonly />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Client Name</label>
                                    <input type="text" class="form-control" value="{{ $followup_data->client_name }}"
                                        readonly />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Client Mobile</label>
                                    <input type="text" class="form-control" value="{{ $followup_data->client_mobile }}"
                                        readonly />
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" rows="2" readonly>{{ $followup_data->address }}</textarea>
                                </div>
                            </div>

                            <!-- Move Details Section (Conditional) -->
                            @if ($followup_data->service == 30)
                                <div class="section-subtitle">
                                    <i class="fas fa-truck-moving"></i> Move Details
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Description of Goods</label>
                                        <input type="text" class="form-control"
                                            value="{{ $followup_data->desc_of_goods }}" readonly />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Service Required</label>
                                        <input type="text" class="form-control"
                                            value="{{ $followup_data->service_required }}" readonly />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Mode of Transport</label>
                                        <input type="text" class="form-control"
                                            value="{{ $followup_data->mode_of_transport }}" readonly />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Estimated Volume (CBM)</label>
                                        <input type="text" class="form-control"
                                            value="{{ $followup_data->estimated_volume }}" readonly />
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <div class="fw-bold text-primary mb-3"
                                                style="font-size: 11px; letter-spacing: 0.05em;"> <i
                                                    class="fas fa-map-marker-alt"></i> ORIGIN / PICK-UP</div>
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $followup_data->origin_add }}" readonly />
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label">Country</label>
                                                    @php $o_country = DB::table('countries')->where('id', $followup_data->origin_country)->first(); @endphp
                                                    <input type="text" class="form-control"
                                                        value="{{ $o_country->country ?? '' }}" readonly />
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">State</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->origin_state }}" readonly />
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">City</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->origin_city }}" readonly />
                                                </div>

                                            </div>
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->origin_location }}" readonly />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">ZIP Code</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->origin_zip_post }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <div class="fw-bold text-primary mb-3"
                                                style="font-size: 11px; letter-spacing: 0.05em;"> <i
                                                    class="fas fa-map-pin"></i> DESTINATION / DELIVERY
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $followup_data->desti_add }}" readonly />
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label">Country</label>
                                                    @php $d_country = DB::table('countries')->where('id', $followup_data->desti_country)->first(); @endphp
                                                    <input type="text" class="form-control"
                                                        value="{{ $d_country->country ?? '' }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">State</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->desti_state }}" readonly />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">City</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->desti_city }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->desti_location }}" readonly />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">ZIP Code</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $followup_data->desti_zip_post }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Survey Assignment Section -->
                            <div class="section-subtitle">
                                <i class="fas fa-clipboard-list"></i> Survey Assignment
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3 text-uppercase">
                                    <label class="form-label">Google Maps Link</label>
                                    <input id="map_link" name="map_link" type="text" class="form-control"
                                        value="{{ old('map_link', $followup_data->map_link ?? '') }}"
                                        placeholder="PASTE MAP LOCATION LINK HERE..." autocomplete="off" />
                                    @error('map_link')
                                        <span class="alert-error-mini">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Survey Type <span class="mandatory">*</span></label>
                                    <select class="form-select select" id="survey_type" name="survey_type">
                                        <option value="">SELECT SURVEY TYPE</option>
                                        @foreach ($surveyor_type as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('survey_type', $followup_data->survey_type) == $type->id ? 'selected' : '' }}>
                                                {{ strtoupper($type->surveyor_type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('survey_type')
                                        <span class="alert-error-mini">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Survey Date <span class="mandatory">*</span></label>
                                    <input id="survey_date" name="survey_date" type="text" class="form-control"
                                        value="{{ old('survey_date', $followup_data->s_date !== '0000-00-00' ? $followup_data->s_date : '') }}"
                                        autocomplete="off" placeholder="YYYY-MM-DD" />
                                    @error('survey_date')
                                        <span class="alert-error-mini">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Surveyor <span class="mandatory">*</span></label>
                                    <select name="surveyor_name" id="surveyor_name" class="form-select select">
                                        <option value="">SELECT SURVEYOR</option>
                                        @foreach ($vendors_data as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                {{ old('surveyor_name', $followup_data->surveyor) == $vendor->id ? 'selected' : '' }}>
                                                {{ strtoupper($vendor->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('surveyor_name')
                                        <span class="alert-error-mini">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="mandatory">*</span></label>
                                    <select name="status_id" id="status_id" class="form-select select">
                                        <option value="">SELECT STATUS</option>
                                        <option value="1"
                                            {{ old('status_id', $enquiry_status->status) == '1' ? 'selected' : '' }}>ACTIVE
                                        </option>
                                        <option value="2"
                                            {{ old('status_id', $enquiry_status->status) == '2' ? 'selected' : '' }}>
                                            COMPLETED</option>
                                        <option value="3"
                                            {{ old('status_id', $enquiry_status->status) == '3' ? 'selected' : '' }}>
                                            FOLLOWUP</option>
                                        <option value="4"
                                            {{ old('status_id', $enquiry_status->status) == '4' ? 'selected' : '' }}>LOST
                                        </option>
                                    </select>
                                    @error('status_id')
                                        <span class="alert-error-mini">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Survey Notes</label>
                                    <textarea id="notes" name="notes">{{ old('notes', $enquiry_status->notes ?? '') }}</textarea>
                                    @error('notes')
                                        <span class="alert-error-mini">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="btn-group-actions text-end">
                                <a class="btn-cancel" href="{{ route('erp_survey.lists') }}">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                                <button class="btn-submit" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Processing...
                                </button>
                                <button type="button" class="btn-submit" onclick="validate_survey()"
                                    id="submit_button">
                                    <i class="fas fa-check-circle"></i> Assign Survey
                                </button>
                            </div>

                    </div>


                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Survey Type:</label>
                                <select class="form-control form-select select" id="survey_type" name="survey_type">
                                    <option value="">Select Survey Type</option>
                                    @foreach ($surveyor_type as $surveyor_type_data)
                                        <option value="{{ $surveyor_type_data->id }}"
                                            @if ($surveyor_type_data->id == $followup_data->survey_type) {{ 'selected' }} @endif>
                                            {{ $surveyor_type_data->surveyor_type }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="form-error-text" id="survey_type_error" style="color: red;"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Survey Date:</label>
                                <input id="survey_date" name="survey_date" type="text" class="form-control"
                                    value="{{ $followup_data->s_date !== '0000-00-00' ? $followup_data->s_date : '' }}"
                                    autocomplete="off" />
                                <p class="form-error-text" id="survey_date_error" style="color: red;"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Surveyor:</label>
                                <select name="surveyor_name" id="surveyor_name" class="form-control form-select select">
                                    <option value="">Select Surveyor</option>
                                    @foreach ($vendors_data as $data)
                                        <option value="{{ $data->id }}"
                                            @if ($data->id == $followup_data->surveyor) {{ 'selected' }} @endif>
                                            {{ $data->name }}</option>
                                    @endforeach
                                </select>
                                <p class="form-error-text" id="surveyor_name_error" style="color: red;"></p>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="name">Status:</label>
                            <select name="status_id" id="status_id"
                                class="form-control form-select gen_info_val_blank select">
                                <option value="">Select Status</option>
                                <option value="1" {{ $enquiry_status->status == '1' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="2" {{ $enquiry_status->status == '2' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="3" {{ $enquiry_status->status == '3' ? 'selected' : '' }}>
                                    Followup</option>
                                <option value="4" {{ $enquiry_status->status == '4' ? 'selected' : '' }}>Lost
                                </option>
                            </select>
                            <p class="form-error-text" id="status_id_error" style="color: red;"></p>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="name">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" placeholder="Enter Notes">{{ $enquiry_status->notes ?? '' }}</textarea>
                            <p class="form-error-text" id="notes_error" style="color: red;"></p>
                        </div>
                    </div> --}}

                    {{-- 
                    <div class="text-end mt-4 ">
                        <a class="btn btn-primary" href="{{ route('erp_enquiry.lists') }}"> Cancel</a>
                        <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                            style="display: none;">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="button" class="btn btn-primary" onclick="javascript:category_validation()"
                            id="submit_button">Submit</button>
                        <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
                    </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
@section('footer_js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script type="text/javascript"></script>
    <script>
        let editor;
        ClassicEditor
            .create(document.querySelector('#notes'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        $(document).ready(function() {
            $('#survey_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            $('#surveyor_name').select2({
                placeholder: "SELECT SURVEYOR",
                allowClear: true,
                width: '100%'
            });
        });

        function validate_survey() {
            const survey_type = $("#survey_type").val();
            const survey_date = $("#survey_date").val();
            const surveyor_name = $("#surveyor_name").val();
            const status_id = $("#status_id").val();

            if (!survey_type || !survey_date || !surveyor_name || !status_id) {
                Swal.fire({
                    title: 'MISSING INFORMATION',
                    text: "PLEASE FILL IN ALL MANDATORY FIELDS MARKED WITH (*)",
                    icon: 'warning',
                    confirmButtonColor: '#3b82f6',
                    background: '#ffffff',
                });
                return false;
            }

            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#erp_enquiry_form').submit();
        }
    </script>


@stop

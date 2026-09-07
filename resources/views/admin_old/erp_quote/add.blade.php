@extends('admin.includes.Template')
@section('content')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/formnew.css') }}">

    <div class="content container-fluid">

        @php

            if ($current_route == 'erp_quote.revisequote') {
                $heading = 'Revise Quotation';
                $action = 'revise-quotation';
            } elseif ($current_route == 'erp_acceptedquote.revisequote') {
                $heading = 'Revise Quotation';
                $action = 'revise-quotation';
            } else {
                $heading = 'Quotation';
                $action = '';
            }

        @endphp
        <!-- Page Header -->

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">{{ $heading }}</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('erp_enquiry.lists') }}">{{ $heading }}</a>
                            </li>
                            <li class="breadcrumb-item active">Add {{ $heading }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>



        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="custom-card">
                    <div class="card-header">
                        <h4><i class="fas fa-plus-circle me-2"></i> {{ $heading }}</h4>
                    </div>
                    <div class="card-body">

                        <form id="erp_enquiry_form" action="{{ route('erp_quote.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="action" value="{{ $action ?? '' }}">
                            <input type="hidden" name="inquiry_id_hidden" value="{{ $followup_data->id }}">
                            <input type="hidden" name="current_route" value="{{ $current_route ?? '' }}">

                            <div class="section-title">
                                <i class="fas fa-info-circle"></i> Basic Quotation Details
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Quote ID</label>
                                    <input type="text" class="form-control" value="{{ $followup_data->quote_id ?? '' }}"
                                        readonly
                                        style="background-color: #f1f5f9; font-weight: 700; color: var(--primary-blue);">
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Enquiry ID</label>
                                    <input type="text" class="form-control" value="{{ $followup_data->quote_no ?? '' }}"
                                        readonly
                                        style="background-color: #f1f5f9; font-weight: 700; color: var(--primary-blue);">
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Survey ID</label>
                                    <input type="text" class="form-control"
                                        value="{{ $followup_data->survey_id ?? '' }}" readonly
                                        style="background-color: #f1f5f9; font-weight: 700; color: var(--primary-blue);">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Quotation Date <span class="text-danger">*</span></label>
                                    <input type="text" name="quotation_date" id="quotation_date" class="form-control"
                                        value="{{ $followup_data->quotation_date ?? date('Y-m-d') }}"
                                        placeholder="YYYY-MM-DD">
                                    <div id="quotation_date_error" class="text-danger small mt-1"></div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label class="form-label">Volume (CBM)</label>
                                    <input type="text" name="volume_in_cbm" id="volume_in_cbm" class="form-control"
                                        value="{{ $followup_data->volume_in_cbm ?? '' }}" placeholder="Enter Volume">
                                </div>
                            </div>



                            <div class="row d-none">
                                <div class="form-group col-lg-6">
                                    <label for="name">Client Name</label>
                                    <input id="client_name" name="client_name" type="text" class="form-control"
                                        value="{{ $followup_data->client_name }}" placeholder="Enter Client Name"
                                        readonly />
                                    <p class="form-error-text" id="client_name_error" style="color: red;"></p>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="name">Client Mobile</label>
                                    <input id="client_mobile" name="client_mobile" type="text" class="form-control"
                                        value="{{ $followup_data->client_mobile }}" placeholder="Enter Client Mobile"
                                        readonly />
                                    <p class="form-error-text" id="client_mobile_error" style="color: red;"></p>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="name">Contact Person</label>
                                    <input id="contact_person" name="contact_person" type="text"
                                        class="form-control " value="{{ $followup_data->contact_person }}"
                                        placeholder="Enter Contact Person" readonly />
                                    <p class="form-error-text" id="contact_person_error" style="color: red;"></p>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="name">Contact Person Mobile</label>
                                    <input id="contact_person_mobile" name="contact_person_mobile" type="text"
                                        class="form-control " value="{{ $followup_data->contact_person_mobile }}"
                                        placeholder="Enter Contact Person Mobile" readonly />
                                    <p class="form-error-text" id="contact_person_mobile_error" style="color: red;"></p>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="name">Address:</label>
                                    <textarea name="address" id="address" cols="5" rows="5" class="form-control "
                                        placeholder="Enter Address" readonly>{{ $followup_data->address }}</textarea>
                                </div>
                            </div>

                            @if ($followup_data->service == 30)
                                <div class="row d-none">

                                    <div class="form-group col-lg-12">
                                        <h5>Move Details:</h5>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Description of Goods</label>
                                        <input id="desc_of_goods" name="desc_of_goods" type="text"
                                            class="form-control " value="{{ $followup_data->desc_of_goods }}"
                                            placeholder="Enter Description of Goods" readonly />
                                        <p class="form-error-text" id="desc_of_goods_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Service Required</label>
                                        <input id="service_required" name="service_required" type="text"
                                            class="form-control " value="{{ $followup_data->service_required }}"
                                            placeholder="Enter Service Required" readonly />
                                        <p class="form-error-text" id="service_required_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Mode of Transport</label>
                                        <input id="mode_of_transport" name="mode_of_transport" type="text"
                                            class="form-control " value="{{ $followup_data->mode_of_transport }}"
                                            placeholder="Enter Mode of Transport" readonly />
                                        <p class="form-error-text" id="mode_of_transport_error" style="color: red;"></p>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name">Estimated Volume (CBM)</label>
                                        <input id="estimated_volume" name="estimated_volume" type="text"
                                            class="form-control " value="{{ $followup_data->estimated_volume }}"
                                            placeholder="Enter Estimated Volume (CBM)" readonly />
                                        <p class="form-error-text" id="estimated_volume_error" style="color: red;"></p>
                                    </div>
                                    <div class="col-lg-6"><b>Origin:/Pick up</b>
                                        <div class="form-group ">
                                            <label for="name">Address:</label>
                                            <input id="origin_add" name="origin_add" type="text"
                                                class="form-control " placeholder="Enter Origin Address"
                                                value="{{ $followup_data->origin_add }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Country:</label>
                                            <select name="origin_country" id="origin_country"
                                                class="form-select form-control " disabled />
                                            <option value="">Select Country</option>
                                            @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ $country->id == $followup_data->origin_country ? 'selected' : '' }}>
                                                    {{ $country->country }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">State:</label>
                                            <input id="origin_state" name="origin_state" type="text"
                                                class="form-control " placeholder="Enter Origin State"
                                                value="{{ $followup_data->origin_state }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">City:</label>
                                            <input id="origin_city" name="origin_city" type="text"
                                                class="form-control " placeholder="Enter Origin City"
                                                value="{{ $followup_data->origin_city }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Location:</label>
                                            <input id="origin_location" name="origin_location" type="text"
                                                class="form-control " placeholder="Enter Origin Location"
                                                value="{{ $followup_data->origin_location }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">ZIP/POST Code:</label>
                                            <input id="origin_zip_post" name="origin_zip_post" type="text"
                                                class="form-control " placeholder="Enter Origin ZIP/POST Code"
                                                value="{{ $followup_data->origin_zip_post }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-6"><b>Destination:/Delivery</b>
                                        <div class="form-group">
                                            <label for="name">Address:</label>
                                            <input id="desti_add" name="desti_add" type="text" class="form-control "
                                                placeholder="Enter Destination Address"
                                                value="{{ $followup_data->desti_add }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Country:</label>
                                            <select name="desti_country" id="desti_country"
                                                class="form-select form-control " disabled />
                                            <option value="">Select Country</option>
                                            @foreach ($country_data as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ $country->id == $followup_data->desti_country ? 'selected' : '' }}>
                                                    {{ $country->country }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">State:</label>
                                            <input id="desti_state" name="desti_state" type="text"
                                                class="form-control " placeholder="Enter Destination State"
                                                value="{{ $followup_data->desti_state }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">City:</label>
                                            <input id="desti_city" name="desti_city" type="text"
                                                class="form-control " placeholder="Enter Destination City"
                                                value="{{ $followup_data->desti_city }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Location:</label>
                                            <input id="desti_location" name="desti_location" type="text"
                                                class="form-control " placeholder="Enter Destination Location"
                                                value="{{ $followup_data->desti_location }}" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">ZIP/POST Code:</label>
                                            <input id="desti_zip_post" name="desti_zip_post" type="text"
                                                class="form-control " placeholder="Enter Destination ZIP/POST Code"
                                                value="{{ $followup_data->desti_zip_post }}" readonly />
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <div class="section-title mt-2">
                                <i class="fas fa-list-ul"></i> Quotation Line Items
                            </div>

                            <div class="table-responsive">
                                <table class="quote-table" id="quote_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 45%;">Description</th>
                                            <th style="width: 15%;">Qty</th>
                                            <th style="width: 15%;">Unit Price</th>
                                            <th style="width: 15%;">Total</th>
                                            <th style="width: 10%;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($costing_attribute) && count($costing_attribute) > 0)
                                            @foreach ($costing_attribute as $child)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="updateid1xxx[]"
                                                            value="{{ $child->id }}">
                                                        <input type="text" name="descriptionu[]"
                                                            class="form-control description-input"
                                                            value="{{ $child->description }}"
                                                            placeholder="Item description..." list="description_options"
                                                            oninput="calculateRowValues()">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="qtyu[]" class="form-control qty"
                                                            value="{{ $child->qty }}" placeholder="0"
                                                            oninput="calculateRowValues()">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="provu[]"
                                                            class="form-control prov" value="{{ $child->prov }}"
                                                            placeholder="0.00" oninput="calculateRowValues()">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="totalu[]"
                                                            class="form-control row-total" value="{{ $child->total }}"
                                                            readonly style="background: #f8fafc;">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger rounded-circle delete-existing-row"
                                                            data-url="{{ route('erp_quote.remove', ['enquiry_id' => $followup_data->id, 'id' => $child->id]) }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <input type="text" name="description[]"
                                                        class="form-control description-input"
                                                        placeholder="Item description..." list="description_options"
                                                        oninput="calculateRowValues()">
                                                </td>
                                                <td>
                                                    <input type="number" name="qty[]" class="form-control qty"
                                                        placeholder="0" oninput="calculateRowValues()">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="prov[]"
                                                        class="form-control prov" placeholder="0.00"
                                                        oninput="calculateRowValues()">
                                                </td>
                                                <td>
                                                    <input type="text" name="total[]" class="form-control row-total"
                                                        readonly style="background: #f8fafc;">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger remove-row rounded-circle">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <datalist id="description_options">
                                @if (isset($descriptionofgoods))
                                    @foreach ($descriptionofgoods as $item)
                                        <option value="{{ $item->name }}">
                                    @endforeach
                                @endif
                            </datalist>

                            <button type="button" class="btn-add-row" id="addRows">
                                <i class="fas fa-plus-circle me-1"></i> Add Another Line Item
                            </button>

                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="section-title mt-0">
                                        <i class="fas fa-cog"></i> Visibility & Settings
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Email to Customer?</label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="mail_to_customer"
                                                    id="mail_yes" value="1"
                                                    {{ isset($followup_data) && $followup_data->mail_to_customer == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mail_yes">Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="mail_to_customer"
                                                    id="mail_no" value="0"
                                                    {{ !isset($followup_data) || $followup_data->mail_to_customer == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="mail_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" type="checkbox" name="vat_charge"
                                            id="vat_charge" value="1"
                                            {{ isset($followup_data) && $followup_data->vat_charge == 1 ? 'checked' : '' }}
                                            onchange="calculateRowValues()">
                                        <label class="form-check-label fw-bold" for="vat_charge">Apply 5% VAT
                                            Charge</label>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Prepared By</label>
                                        <input type="text" name="prepared_by" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly
                                            placeholder="Name of person preparing quote">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Estimated Time to Complete</label>
                                        <input type="text" name="est_time_to_complete" class="form-control"
                                            value="{{ $followup_data->est_time_to_complete ?? '' }}"
                                            placeholder="e.g. 2-3 Days">
                                    </div>
                                </div>

                                <div class="col-md-5 offset-md-1">
                                    <div class="calculation-summary">
                                        <div class="summary-row">
                                            <span class="summary-label">Margin (%)</span>
                                            <div style="width: 100px;">
                                                <input type="number" name="margin" id="margin"
                                                    class="form-control form-control-sm text-end fw-bold"
                                                    value="{{ $followup_data->margin_percent ?? '0' }}"
                                                    oninput="calculateRowValues('margin')">
                                            </div>
                                        </div>
                                        <div class="summary-row">
                                            <span class="summary-label">Margin Amount</span>
                                            <div style="width: 120px;">
                                                <input type="number" name="margin_amount" id="margin_amount"
                                                    class="form-control form-control-sm text-end fw-bold text-success"
                                                    value="{{ $followup_data->margin_amount ?? '0' }}"
                                                    oninput="calculateRowValues('margin_amount')">
                                            </div>
                                        </div>
                                        <div class="summary-row bg-white rounded p-2 my-2 border-light"
                                            style="display: none;" id="vat_summary_row">
                                            <span class="summary-label text-danger">VAT (5% on Subtotal)</span>
                                            <span class="summary-value text-danger" id="summary_vat">0.00</span>
                                        </div>
                                        <div class="summary-row mt-3 pt-3" style="border-top: 2px dashed #cbd5e1;">
                                            <span class="summary-label text-dark" style="font-size: 16px;">Grand
                                                Total</span>
                                            <div style="width: 150px;">
                                                <input type="text" name="total_sum" id="total_sum"
                                                    class="form-control text-end border-0 bg-transparent fw-800 text-primary"
                                                    style="font-size: 20px; padding: 0;"
                                                    value="{{ $followup_data->total_sum ?? '0.00' }}" readonly>
                                                <input type="hidden" name="grand_total" id="grand_total"
                                                    value="{{ $followup_data->total_sum ?? '0.00' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="section-title mt-5">
                                <i class="fas fa-pen-nib"></i> Scope & Detailed Terms
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="bg-white p-3 rounded border border-light shadow-sm">
                                        <label class="form-label text-primary"><i class="fas fa-search me-1"></i> Scope of
                                            Job</label>
                                        <textarea name="scope_of_job" id="scope_of_job" class="form-control">{{ $followup_data->scope_of_job ?? ($servicedata->scope_of_job ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="bg-white p-3 rounded border border-light shadow-sm">
                                        <label class="form-label text-success"><i class="fas fa-plus-circle me-1"></i>
                                            Price
                                            Includes</label>
                                        <textarea name="price_includes" id="price_includes" class="form-control">{{ $followup_data->price_includes ?? ($servicedata->price_includes ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="bg-white p-3 rounded border border-light shadow-sm">
                                        <label class="form-label text-danger"><i class="fas fa-minus-circle me-1"></i>
                                            Price
                                            Excludes</label>
                                        <textarea name="price_excludes" id="price_excludes" class="form-control">{{ $followup_data->price_excludes ?? ($servicedata->price_excludes ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="bg-white p-3 rounded border border-light shadow-sm">
                                        <label class="form-label text-warning"><i
                                                class="fas fa-exclamation-triangle me-1"></i> Disclaimer</label>
                                        <textarea name="disclaimer" id="disclaimer" class="form-control">{{ $followup_data->disclaimer ?? ($servicedata->disclaimer ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="bg-white p-3 rounded border border-light shadow-sm">
                                        <label class="form-label text-info"><i class="fas fa-shield-alt me-1"></i>
                                            Insurance</label>
                                        <textarea name="insurance" id="insurance" class="form-control">{{ $followup_data->insurance ?? ($servicedata->insurance ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-5">
                                    <div class="bg-white p-3 rounded border font-weight-bold shadow-sm"
                                        style="border-left: 4px solid var(--primary-blue) !important;">
                                        <label class="form-label"><i class="fas fa-credit-card me-1"></i> Payment
                                            Terms</label>
                                        <textarea name="payment_terms" id="payment_terms" class="form-control">{{ $followup_data->payment_terms ?? ($servicedata->payment_terms ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end border-top pt-4">
                                <a href="{{ route('erp_quote.lists') }}" class="btn-cancel">Cancel</a>
                                <button type="button" class="btn-submit" id="submit_button"
                                    onclick="validate_quotation()">
                                    <i class="fas fa-check-circle me-1"></i> Save Quotation
                                </button>
                                <button type="button" class="btn-submit" id="spinner_button" disabled
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Processing...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        let editors = {};
        const editorFields = ['scope_of_job', 'price_includes', 'price_excludes', 'disclaimer', 'insurance',
            'payment_terms'
        ];

        editorFields.forEach(id => {
            ClassicEditor.create(document.querySelector('#' + id), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'blockQuote', 'undo', 'redo'
                    ]
                })
                .then(editor => {
                    editors[id] = editor;
                })
                .catch(error => {
                    console.error('Error initializing editor for ' + id, error);
                });
        });

        $(document).ready(function() {
            $('#quotation_date').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true
            });

            // Add Row functionality
            $("#addRows").click(function() {
                var html = `
                    <tr>
                        <td>
                            <input type="text" name="description[]" class="form-control description-input" placeholder="Item description..." list="description_options">
                        </td>
                        <td>
                            <input type="number" name="qty[]" class="form-control qty" placeholder="0" oninput="calculateRowValues()">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="prov[]" class="form-control prov" placeholder="0.00" oninput="calculateRowValues()">
                        </td>
                        <td>
                            <input type="text" name="total[]" class="form-control row-total" readonly style="background: #f8fafc;">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row rounded-circle">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>`;
                $("#quote_table tbody").append(html);
            });

            $(document).on('click', '.remove-row', function() {
                let row = $(this).closest('tr');
                Swal.fire({
                    title: 'Remove Row?',
                    text: "This item will be removed from the quote.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, remove it',
                    background: '#ffffff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        row.remove();
                        calculateRowValues();
                    }
                });
            });

            $(document).on('click', '.delete-existing-row', function() {
                let url = $(this).data('url');
                Swal.fire({
                    title: 'Delete Item?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Yes, delete it',
                    background: '#ffffff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });

            // Initial calculation
            calculateRowValues();
        });

        // --- Core Calculation Logic (Preserving special handling for Security Deposit) ---
        // function calculateRowValues(changedBy = 'margin') {
        //     let normalSubtotal = 0;
        //     let securityDepositTotal = 0;

        //     $("#quote_table tbody tr").each(function() {
        //         let row = $(this);
        //         let description = row.find('.description-input').val().toLowerCase().trim();
        //         let qty = parseFloat(row.find('.qty').val()) || 0;
        //         let prov = parseFloat(row.find('.prov').val()) || 0;
        //         let total = qty * prov;
        //         row.find('.row-total').val(total.toFixed(2));

        //         // Identify Security Deposit (Refundable) - usually exempt from Margin & VAT
        //         if (description.includes("security deposit") && description.includes("refundable")) {
        //             securityDepositTotal += total;
        //         } else {
        //             normalSubtotal += total;
        //         }
        //     });

        //     let margin = parseFloat($('#margin').val()) || 0;
        //     let margin_amount = parseFloat($('#margin_amount').val()) || 0;

        //     let marginValue = 0;
        //     if (changedBy === 'margin') {
        //         // Margin applied to normal items only
        //         marginValue = Math.round(normalSubtotal * (margin / 100));
        //         $('#margin_amount').val(marginValue);
        //     } else {
        //         marginValue = margin_amount;
        //         if (normalSubtotal > 0) {
        //             margin = ((marginValue / normalSubtotal) * 100).toFixed(2);
        //         } else {
        //             margin = 0;
        //         }
        //         $('#margin').val(margin);
        //     }

        //     let normalWithMargin = normalSubtotal + marginValue;

        //     let vatAmount = 0;
        //     if (document.getElementById("vat_charge").checked) {
        //         // VAT applied to normal items with margin only
        //         vatAmount = normalWithMargin * 0.05;
        //     }

        //     // Grand Total = (Normal + Margin + VAT) + Security Deposit (Raw)
        //     let finalTotal = normalWithMargin + vatAmount + securityDepositTotal;

        //     $('#total_sum').val(finalTotal.toFixed(2));
        //     $('#grand_total').val(finalTotal.toFixed(2));
        // }
        function calculateRowValues(changedBy = 'margin') {

            let subtotalAll = 0; // ALL items (for margin)
            let depositTotal = 0; // Deposit items
            let nonDepositTotal = 0; // Non-deposit items

            // 1. Loop through rows
            $("#quote_table tbody tr").each(function() {

                let row = $(this);
                let description = (row.find('.description-input').val() || '').toLowerCase().trim();
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let prov = parseFloat(row.find('.prov').val()) || 0;

                let total = qty * prov;

                // Update row total UI
                row.find('.row-total').val(total.toFixed(2));

                // Detect deposit
                let isDeposit =
                    description.includes("security") ||
                    description.includes("deposit") ||
                    description.includes("refundable");

                // Add to subtotal (for margin)
                subtotalAll += total;

                if (isDeposit) {
                    depositTotal += total;
                } else {
                    nonDepositTotal += total;
                }
            });

            // 2. Margin Calculation (on ALL items)
            let margin = parseFloat($('#margin').val()) || 0;
            let margin_amount = parseFloat($('#margin_amount').val()) || 0;

            let marginValue = 0;

            if (changedBy === 'margin') {
                marginValue = Math.round(subtotalAll * (margin / 100));
                $('#margin_amount').val(marginValue);
            } else {
                marginValue = margin_amount;

                if (subtotalAll > 0) {
                    margin = ((marginValue / subtotalAll) * 100).toFixed(2);
                } else {
                    margin = 0;
                }

                $('#margin').val(margin);
            }

            // 3. Split margin (for VAT logic)
            let depositMargin = 0;
            let nonDepositMargin = 0;

            if (subtotalAll > 0) {
                depositMargin = (depositTotal / subtotalAll) * marginValue;
                nonDepositMargin = (nonDepositTotal / subtotalAll) * marginValue;
            }

            // 4. VAT Calculation (ONLY on NON-DEPOSIT + its margin)
            let vatAmount = 0;
            let applyVat = $('#vat_charge').is(':checked');

            if (applyVat) {
                vatAmount = (nonDepositTotal + nonDepositMargin) * 0.05;
                $('#vat_summary_row').show();
            } else {
                vatAmount = 0;
                $('#vat_summary_row').hide();
            }

            // 5. FINAL TOTAL
            let finalTotal =
                subtotalAll + // all items
                marginValue + // margin on all
                vatAmount; // VAT only on taxable

            // 6. Update UI
            $('#total_sum').val(finalTotal.toFixed(2));
            $('#grand_total').val(finalTotal.toFixed(2));
            $('#summary_vat').text(vatAmount.toFixed(2));

            // Optional UI fields (if you have)
            // $('#summary_subtotal').text(subtotalAll.toFixed(2));
            // $('#summary_vat').text(vatAmount.toFixed(2));
            // $('#summary_total').text(finalTotal.toFixed(2));

            // Debug (optional)
            /*
            console.log({
                subtotalAll,
                depositTotal,
                nonDepositTotal,
                marginValue,
                depositMargin,
                nonDepositMargin,
                vatAmount,
                finalTotal
            });
            */
        }

        function validate_quotation() {
            var date = $('#quotation_date').val();
            if (date == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Date Required',
                    text: 'Please select a quotation date.',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            // Show loading
            $('#submit_button').hide();
            $('#spinner_button').show();

            // Sync CKEditor
            for (let id in editors) {
                if (editors[id]) {
                    document.querySelector('#' + id).value = editors[id].getData();
                }
            }

            $('#erp_enquiry_form').submit();
        }

        @if ($message = Session::get('success'))
            Swal.fire({
                title: 'Saved!',
                text: "{{ $message }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                background: '#ffffff'
            });
        @endif
    </script>

@stop

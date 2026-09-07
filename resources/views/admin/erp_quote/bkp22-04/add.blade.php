@extends('admin.includes.Template')
@section('content')
    <style>
        .hidden {
            display: none;
        }

        .checkbox-color {
            color: #0f548e !important;
        }

        input[type="checkbox"] {
            accent-color: #0f548e;
            /* Set the desired color */
        }

        .bg-color {
            background-color: #ccc;
            pointer-events: none;
            /* Disable any interaction */
            cursor: not-allowed;
            /* Change cursor to indicate no interaction */
        }

        .table-responsive .form-control {
            padding: 2px;
        }

        .table>tbody>tr>td {
            padding: 2px;
        }
    </style>
    <style>
        ul li {
            list-style: inherit !important;
        }
    </style>
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
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{ $heading }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Add {{ $heading }}</li>
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

        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <form id="erp_enquiry_form" action="{{ route('erp_quote.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="action" value="{{ $action ?? '' }}">
                            <input type="hidden" name="current_route" value="{{ $current_route ?? '' }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Quotation ID</label>
                                        <input id="inquiry_id" name="inquiry_id" type="text" class="form-control"
                                            value="{{ $followup_data->quote_id }}" readonly />
                                        <input id="inquiry_id_hidden" name="inquiry_id_hidden" type="hidden"
                                            class="form-control" value="{{ $followup_data->id }}" />
                                        <p class="form-error-text" id="name_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Enquiry ID</label>
                                        <input id="inquiry_id" name="inquiry_id" type="text" class="form-control"
                                            value="{{ $followup_data->quote_no }}" readonly />
                                        <input id="inquiry_id_hidden" name="inquiry_id_hidden" type="hidden"
                                            class="form-control" value="{{ $followup_data->id }}" />
                                        <p class="form-error-text" id="name_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Survey ID</label>
                                        <input id="survey_id" name="survey_id" type="text" class="form-control"
                                            value="{{ $followup_data->survey_id }}" readonly />
                                        <input id="survey_id" name="survey_id" type="hidden" class="form-control"
                                            value="{{ $followup_data->survey_id }}" />
                                        <input id="survey_id_hidden" name="survey_id_hidden" type="hidden"
                                            class="form-control" value="{{ $followup_data->survey_id }}" />
                                    </div>
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
                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Quotation Date:</label>
                                        <input id="quotation_date" name="quotation_date" type="text"
                                            class="form-control"
                                            value="{{ $followup_data->quotation_date !== '0000-00-00' ? $followup_data->quotation_date : '' }}"
                                            autocomplete="off" />
                                        <p class="form-error-text" id="survey_date_error" style="color: red;"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Volume In CBM:</label>
                                        <input id="volume_in_cbm" name="volume_in_cbm" type="text"
                                            class="form-control"
                                            value="{{ $followup_data->volume_in_cbm !== '0000-00-00' ? $followup_data->volume_in_cbm : '' }}"
                                            autocomplete="off" />
                                        <p class="form-error-text" id="volume_in_cbm_error" style="color: red;"></p>
                                    </div>
                                </div>

                                <div class="table-responsive mt-4 add-more-fields">
                                    <table class="table table-center table-hover">
                                        <thead style="background-color:#3484C3">
                                            <tr>

                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Prov.</th>

                                                <th>Total</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                                <td style="width:37%;">
                                                    <input type="text" name="head_description" class="form-control"
                                                        value="{!! Helper::servicename($followup_data->service) !!}" />
                                                </td>

                                                <td style="width:22%;">
                                                    <input type="number" class="form-control bg-color" />
                                                </td>
                                                <td style="width:19%;">
                                                    <input type="number" class="form-control bg-color" />
                                                </td>

                                                <td style="width:22%;">
                                                    <input type="number" class="form-control " id="grand_total"
                                                        name="grand_total"
                                                        value="{{ isset($followup_data->grand_total) ? $followup_data->grand_total : '' }}"
                                                        readonly />
                                                </td>

                                            </tr>
                                            {{-- <input type="hidden" class="form-control" id="code" name="code[]">
                                                    <input type="hidden" class="form-control" id="description" name="description[]">
                                                    <input type="hidden" class="form-control" id="qty" name="qty[]">
                                                    <input type="hidden" class="form-control" id="unit" name="unit[]">
                                                    <input type="hidden" class="form-control" id="prov" name="prov[]">
                                                    <input type="hidden" class="form-control" id="egp" name="egp[]">
                                                    <input type="hidden" class="form-control" id="egp_percentage" name="egp_percentage[]">
                                                    <input type="hidden" class="form-control" id="selling" name="selling[]">
                                                    <input type="hidden" class="form-control" id="prov_sum" name="prov_sum[]">
                                                    <input type="hidden" class="form-control" id="selling_sum" name="selling_sum[]">
                                                    <input type="hidden" class="form-control" id="total" name="total[]">
                                                    <input type="hidden" class="form-control" id="egp_sum"  name="egp_sum[]"> --}}
                                            <div class="input_fields_wrap12">
                                            </div>
                                            @if ($costing_attribute != '' && count($costing_attribute) > 0 && !empty($costing_attribute))
                                                @foreach ($costing_attribute as $i => $costing)
                                                    <input type="hidden" name="updateid1xxx[]"
                                                        id="updateid1xxx{{ $i + 1 }}"
                                                        value="{{ $costing->id }}">
                                                    <tr>

                                                        <td style="width:37%;">
                                                            <input type="text" class="form-control description-input"
                                                                id="description" name="descriptionu[]"
                                                                value="{{ $costing->description }}" autocomplete="off">
                                                        </td>
                                                        <td style="width:17%;">
                                                            <input type="number" class="form-control qty" id="qty"
                                                                name="qtyu[]" value="{{ $costing->qty }}">
                                                        </td>

                                                        <td style="width:19%;">
                                                            <input type="number" class="form-control prov"
                                                                id="prov" name="provu[]"
                                                                value="{{ $costing->prov }}">
                                                        </td>


                                                        <td style="width:22%;">
                                                            <input type="number" class="form-control" id="total"
                                                                name="totalu[]" value="{{ $costing->total }}" readonly>
                                                        </td>


                                                        <td class="add-remove text-end">


                                                            <i class="fas fa-minus-circle"
                                                                onclick="singledelete('{{ route('erp_quote.remove', ['enquiry_id' => $costing->enquiry_id, 'id' => $costing->id]) }}')"></i>
                                                            @if ($i === 0)
                                                                <i class="fas fa-plus-circle add-row"></i>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>

                                                    <td style="width:37%;">
                                                        <input type="text" class="form-control description-input"
                                                            id="description" name="description[]" autocomplete="off">
                                                    </td>
                                                    <td style="width:17%;">
                                                        <input type="number" class="form-control qty" id="qty"
                                                            name="qty[]">
                                                    </td>

                                                    <td style="width:19%;">
                                                        <input type="number" class="form-control prov" id="prov"
                                                            name="prov[]">
                                                    </td>

                                                    <td style="width:22%;">
                                                        <input type="number" class="form-control" id="total"
                                                            name="total[]" readonly>
                                                    </td>


                                                    <td class="add-remove text-end">
                                                        <i class="fas fa-plus-circle add-row"></i>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>


                                <div class="col-md-4 mt-4">
                                    <div class="form-group">
                                        <label for="name">Margin %:</label>
                                        <input type="number" name="margin" class="form-control" id="margin"
                                            value="{{ isset($followup_data->margin_percent) ? $followup_data->margin_percent : '' }}">
                                    </div>
                                </div>

                                <div class="col-md-4 mt-4">
                                    <div class="form-group">
                                        <label for="name">Margin (AED):</label>
                                        <input type="number" name="margin_amount" class="form-control"
                                            id="margin_amount"
                                            value="{{ isset($followup_data->margin_amount) ? $followup_data->margin_amount : '' }}">
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 mt-3">
                                            <div class="form-group">
                                                <label for="name">Selling Amt without Indiv Margin(AED):</label>
                                                <input type="number" name="with_margin_amount" class="form-control" id="with_margin_amount" value="{{ isset($followup_data->selling_amount) ? $followup_data->selling_amount : "" }}" readonly>
                                            </div>
                                        </div> --}}

                                <div class="col-md-2 mt-3">
                                    <div class="form-group">
                                        <label for="name">Total Sum(AED):</label>
                                        <input type="number" name="total_sum" class="form-control" id="total_sum"
                                            value="{{ isset($followup_data->total_sum) ? $followup_data->total_sum : '' }}"
                                            readonly>
                                    </div>
                                </div>

                                <input type="hidden" name="newgrandtotal" id="newgrandtotal" value="0">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Prepared By</label>
                                        <input id="prepared_by" name="prepared_by" type="text" class="form-control"
                                            value="{{ Auth::user()->name }}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Est Time to Complete</label>
                                        <input id="est_time_to_complete" name="est_time_to_complete" type="text"
                                            class="form-control"
                                            value="{{ isset($followup_data->est_time_to_complete) ? $followup_data->est_time_to_complete : '' }}" />
                                    </div>
                                </div>




                            </div>

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <input type="checkbox" name="vat_charge" id="vat_charge" value="1"
                                            @if (isset($followup_data) && $followup_data->vat_charge == '1') checked @endif>
                                        <label for="vat_charge">VAT ( 5% )</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div>
                                    <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                                        <li class="nav-item"><a class="nav-link active"
                                                href="#solid-rounded-justified-tab1" data-bs-toggle="tab">Scope Of Job</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab2"
                                                data-bs-toggle="tab">Price Includes</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab3"
                                                data-bs-toggle="tab">Price Excludes</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab4"
                                                data-bs-toggle="tab">Disclaimer</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab5"
                                                data-bs-toggle="tab">Insurance</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#solid-rounded-justified-tab6"
                                                data-bs-toggle="tab">Payment Terms</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                                            <div class="form-group col-lg-12">
                                                <textarea id="scope_of_job" name="scope_of_job" class="form-control" placeholder="Enter Scope Of Job">{{ $followup_data->scope_of_job ?? ($servicedata->scope_of_job ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="solid-rounded-justified-tab2">
                                            <div class="form-group col-lg-12">
                                                <textarea id="price_includes" name="price_includes" class="form-control" placeholder="Enter Price Includes">{{ $followup_data->price_includes ?? ($servicedata->price_includes ?? '') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="solid-rounded-justified-tab3">
                                            <div class="form-group col-lg-12">
                                                <textarea id="price_excludes" name="price_excludes" class="form-control" placeholder="Enter Price Excludes">{{ $followup_data->price_excludes ?? ($servicedata->price_excludes ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="solid-rounded-justified-tab4">
                                            <div class="form-group col-lg-12">
                                                <textarea id="disclaimer" name="disclaimer" class="form-control" placeholder="Enter Disclaimer">{{ $followup_data->disclaimer ?? ($servicedata->disclaimer ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="solid-rounded-justified-tab5">
                                            <div class="form-group col-lg-12">
                                                <textarea id="insurance" name="insurance" class="form-control" placeholder="Enter Insurance">{{ $followup_data->insurance ?? ($servicedata->insurance ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="solid-rounded-justified-tab6">
                                            <div class="form-group col-lg-12">
                                                <textarea id="payment_terms" name="payment_terms" class="form-control" placeholder="Enter Payment Terms">{{ $followup_data->payment_terms ?? ($servicedata->payment_terms ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">Mail To Customer</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="mail_yes" name="mail_to_customer" value="1"
                                            @if (isset($followup_data) && $followup_data->mail_to_customer == '1') checked @endif> <label for="mail_yes">
                                            Yes</label>
                                        <input type="radio" id="mail_no" name="mail_to_customer" value="0"
                                            @if ((isset($followup_data) && $followup_data->mail_to_customer == '0') || $followup_data->mail_to_customer == null) checked @endif> <label for="mail_no">
                                            No</label>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                    <label class="col-form-label col-md-2">Assign To</label>
                                    <div class="col-md-6">
                                        <select name="assign_to" id="assign_to" class="form-control form-select gen_info_val_blank select">
                                            <option value="">Select Assign To</option>
                                            @foreach ($salesperson_data as $salesperson)
                                            <option value="{{ $salesperson->id }}" @if ($salesperson->id == $followup_data->assign_to){{'selected'}} @endif>{{ $salesperson->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}


                            <div class="text-end mt-4 ">
                                <a class="btn btn-primary" href="{{ route('erp_quote.lists') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" onclick="javascript:category_validation()"
                                    id="submit_button">Submit</button>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        var descriptionList = @json($descriptionofgoods->pluck('name'));

        function initializeAutocomplete() {
            $(".description-input").autocomplete({
                source: descriptionList,
                minLength: 1
            });
        }

        $(document).ready(function() {
            initializeAutocomplete();
        });
    </script>

    <script>
        ClassicEditor

            .create(document.querySelector('#notes'))

            .catch(error => {

                console.error(error);

            });

        ClassicEditor
            .create(document.querySelector('#scope_of_job'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });


        ClassicEditor
            .create(document.querySelector('#price_includes'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#price_excludes'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#disclaimer'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#insurance'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#payment_terms'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        let rowCounter = 1;
        $(document).on('click', '.add-row', function() {
            let newRow = `<tr data-row-id="${rowCounter}">
                        
                        <td style="width:37%;"><input type="text" class="form-control description-input" id="description" name="description[]"></td>
                        <td style="width:17%;"><input type="number" class="form-control qty" id="qty" name="qty[]" value="0"></td>
                        
                        <td style="width:19%;"><input type="number" class="form-control prov" id="prov" name="prov[]" value="0"></td>
                        
                        <td style="width:22%;"><input type="number" class="form-control total" id="total" name="total[]" readonly></td>
                        
                        <td class="add-remove text-end"><i class="fas fa-minus-circle remove-row"></i></td>
                      </tr>`;

            // Append the new row to the table
            $(".add-more-fields table tbody").append(newRow);

            // Increment the row counter
            rowCounter++;
            initializeAutocomplete();

            // Recalculate totals after adding a new row
            // calculateRowValues();
            // initializeAutocomplete();
            // initializeAutocompletedesc();
        });

        let editingField = 'margin';

        $(document).ready(function() {

            calculateRowValues();


            let editingField = null;
            // Input events for qty and prov (recalculate without margin change)
            $(document).on('input', '#qty, #prov', function() {

                editingField = 'margin';
                calculateRowValues('margin');
            });



            // Input event for margin percentage
            $(document).on('input', '#margin', function() {
                //alert(editingField);
                if (editingField !== 'margin') {
                    editingField = 'margin';
                    calculateRowValues('margin');
                    editingField = null;
                } else {
                    editingField = 'margin';
                    calculateRowValues('margin');
                }
            });

            // Input event for margin amount
            $(document).on('input', '#margin_amount', function() {
                if (editingField !== 'amount') {
                    editingField = 'amount';
                    calculateRowValues('amount');
                    editingField = null;
                }
            });

            $('#vat_charge').on('change', function() {
                calculateRowValues();
            });

        });

        // function calculateRowValues(changedBy = 'margin') {
        //         // Loop through each row and calculate the total
        //     $('tr').each(function () {
        //         let row = $(this); // Get the current row
        //         let qty = parseFloat(row.find('#qty').val()) || 0;
        //         let prov = parseFloat(row.find('#prov').val()) || 0;
        //         let margin = parseFloat($('#margin').val()) || 0;
        //         let margin_amount = parseFloat($('#margin_amount').val()) || 0;
        //         let total = qty * prov;

        //         // Update the total field for the current row
        //         row.find('#total').val(total.toFixed(2)); // Update total for the row

        //         // Update the hidden input with the total value for each row
        //         let hiddenFieldId = row.data('row-id') + '-total'; // Unique hidden field ID for each row
        //         let hiddenField = $("#" + hiddenFieldId);

        //         if (hiddenField.length === 0) {
        //             // row.append(`<input type="hidden" id="${hiddenFieldId}" name="total741[]" value="${total.toFixed(2)}">`);
        //         } else {
        //             hiddenField.val(total.toFixed(2)); // Update existing hidden field value
        //         }
        //     });

        //     // Call function to update the global total sum
        //     let margin = parseFloat($('#margin').val()) || 0;
        //     let margin_amount = parseFloat($('#margin_amount').val()) || 0;
        //     updateGlobalSum(margin,margin_amount,changedBy);
        // }

        function calculateRowValues(changedBy = 'margin') {

            $("table tbody tr").each(function() {

                let row = $(this);

                let qty = parseFloat(row.find('.qty').val()) || 0;
                let prov = parseFloat(row.find('.prov').val()) || 0;

                let total = qty * prov;

                row.find('#total').val(total.toFixed(2));

            });

            let margin = parseFloat($('#margin').val()) || 0;
            let margin_amount = parseFloat($('#margin_amount').val()) || 0;

            updateGlobalSum(margin, margin_amount, changedBy);
        }

        // Update the global sum of all rows
        function updateGlobalSum(margin, margin_amount, changedBy = 'margin') {

            let normalTotal = 0;
            let securityTotal = 0;

            $("table tbody tr").each(function() {

                let description = $(this).find('.description-input').val() || "";
                description = description.trim().toLowerCase();

                let rowTotal = parseFloat($(this).find('#total').val()) || 0;

                if (description === "security deposit (refundable)") {
                    securityTotal += rowTotal;
                } else {
                    normalTotal += rowTotal;
                }

            });

            let globalTotal = normalTotal + securityTotal;

            let marginValue = 0;
            let withMargin = 0;

            if (changedBy === 'margin') {

                marginValue = Math.round(globalTotal * (margin / 100));
                withMargin = globalTotal + marginValue;

                $('#margin_amount').val(marginValue);

            } else {

                marginValue = parseFloat(margin_amount);
                margin = ((marginValue / globalTotal) * 100).toFixed(2);

                $('#margin').val(margin);

                withMargin = globalTotal + marginValue;

            }

            let normalMargin = Math.round(normalTotal * (margin / 100));
            let securityMargin = Math.round(securityTotal * (margin / 100));

            let normalWithMargin = normalTotal + normalMargin;
            let securityWithMargin = securityTotal + securityMargin;

            let vatChecked = document.getElementById("vat_charge").checked;

            let vatAmount = 0;

            if (vatChecked) {
                vatAmount = normalWithMargin * 0.05;
            }

            let finalTotal = normalWithMargin + securityWithMargin + vatAmount;

            $('#total_sum').val(finalTotal.toFixed(2));
            $('#grand_total').val(finalTotal.toFixed(2));
            $('#newgrandtotal').val(finalTotal.toFixed(2));

        }

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            calculateRowValues(); // Recalculate after removing
        });





        $(function() {
            $('#quotation_date').datepicker({
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });

        $(document).ready(function() {
            $('#surveyor_name').select2({
                placeholder: "Select Surveyor",
                allowClear: true
            });
        });

        $(document).ready(function() {
            // Call it once on page load using the current selected value
            service_change($('#service').val());
        });

        function service_change(value) {

            if (value == 30) {
                $('#origin_desti_move_div').show();
            } else {
                $('#origin_desti_move_div').hide();
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

        function singledelete(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');
            if (t) {
                window.location.href = url;
            } else {
                return false;
            }
        }
    </script>
    <script>
        function category_validation() {

            var survey_type = jQuery("#survey_type").val();
            if (survey_type == '') {
                jQuery('#survey_type_error').html("Please Select Survey Type");
                jQuery('#survey_type_error').show().delay(0).fadeIn('show');
                jQuery('#survey_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#survey_type').offset().top - 150
                }, 1000);
                return false;
            }

            var survey_date = jQuery("#survey_date").val();
            if (survey_date == '') {
                jQuery('#survey_date_error').html("Please Select Survey Date");
                jQuery('#survey_date_error').show().delay(0).fadeIn('show');
                jQuery('#survey_date_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#survey_date').offset().top - 150
                }, 1000);
                return false;
            }

            var surveyor_name = jQuery("#surveyor_name").val();
            if (surveyor_name == '') {
                jQuery('#surveyor_name_error').html("Please Select Surveyor Name");
                jQuery('#surveyor_name_error').show().delay(0).fadeIn('show');
                jQuery('#surveyor_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#surveyor_name').offset().top - 150
                }, 1000);
                return false;
            }

            var status_id = jQuery("#status_id").val();
            if (status_id == '') {
                jQuery('#status_id_error').html("Please Select Status");
                jQuery('#status_id_error').show().delay(0).fadeIn('show');
                jQuery('#status_id_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#status_id').offset().top - 150
                }, 1000);
                return false;
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
                format: 'yyyy-mm-dd', // Set the desired date format yyyy-mm-dd
                // autoclose: true,
                todayHighlight: true
            });
        });
    </script>




@stop

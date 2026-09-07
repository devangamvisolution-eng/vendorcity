@extends('admin.includes.Template')
@section('content')
    <style>
        /* Modern Layout Variables - Carried over from Enquiry List */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        /* Modern Action Card container */
        .action-card {
            overflow: visible !important;
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /* Modern Table Styling */
        .action-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .action-table thead th {
            background: #4c7aef;
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #ffffff;
            border-bottom: 2px solid var(--border-classic);
            position: sticky;
            top: var(--admin-header-height);
            z-index: 100;
        }

        .action-table tbody tr:hover {
            background-color: var(--hover-bg) !important;
        }

        .action-table td {
            padding: 12px;
            vertical-align: middle;
            font-size: 13px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-classic);
        }

        /* Filter Card refinement */
        .filter-card-modern {
            background: #f8fafc;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
        }

        @media only screen and (max-width: 767px) {
            .action-card {
                overflow-x: auto !important;
            }
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Accepted Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Accepted Leads</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary me-2" href="javascript:void('0');" onclick="excel_download();">
                        Excel Download
                    </a>
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
        </div>

        {{-- Hidden Filter Form for Excel --}}
        <form method="GET" action="{{ url('filter_data') }}" id="filter_data">
            <input type="hidden" name="startdate_fil" id="startdate_fil" value="{{ $startdate ?: '' }}">
            <input type="hidden" name="enddate_fil" id="enddate_fil" value="{{ $enddate ?: '' }}">
            <input type="hidden" name="filter_vendor_id_fil" id="filter_vendor_id_fil"
                value="{{ is_array($filter_vendor_id) ? implode(', ', $filter_vendor_id) : ($filter_vendor_id ?: '') }}">
        </form>

        @php
            $css =
                !empty($startdate) || !empty($enddate) || !empty($filter_vendor_id)
                    ? 'display:block;'
                    : 'display:none;';
        @endphp

        <div id="filter_inputs" class="action-card mb-4" style="{{ $css }}">
            <div class="card-body p-4">
                <form id="filter_form" action="{{ route('enquiry_accept') }}" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="filter">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Start Date</label>
                            <input type="date" class="form-control" name="s_date" id="s_date"
                                value="{{ $startdate ?: '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">End Date</label>
                            <input type="date" class="form-control" name="e_date" id="e_date"
                                value="{{ $enddate ?: '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Vendor</label>
                            <select multiple="multiple" class="select form-select" id="vendor_id" name="vendor_id[]">
                                <option value="all">All Vendors</option>
                                @if (!empty($all_vendor))
                                    @foreach ($all_vendor as $all_vendor_data)
                                        <option value="{{ $all_vendor_data->id }}"
                                            @if (!empty($filter_vendor_id) && in_array($all_vendor_data->id, $filter_vendor_id)) selected @endif>
                                            {{ $all_vendor_data->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="form-error-text" id="vendor_id_error"
                                style="color: red; margin-top: 5px; font-size: 12px;"></p>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="filter_validation()">Submit</button>
                            <a class="btn btn-light border w-100" href="{{ route('enquiry_accept') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="action-card">
            <div class="card-body p-4">
                <form id="form" action="" enctype="multipart/form-data">
                    <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                    @csrf
                    <div class="table-responsive">
                        <table class="action-table table-hover" id="example">
                            <thead>
                                <tr>
                                    <th style="display: none">Sr No</th>
                                    <th>Date</th>
                                    <th>Vendor Name</th>
                                    <th>Inquiry No</th>
                                    <th>Accepted Date</th>
                                    <th>Customer Name</th>
                                    <th>Service</th>
                                    {{-- <th>Sub Service</th> --}}
                                    <th class="text-end">Lead Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($package_inquiry_accepted != '')
                                    @php $i = 1; @endphp
                                    @foreach ($package_inquiry_accepted as $package_inquiry_accepted_data)
                                        @php
                                            $packages_enquiry_data = DB::table('packages_enquiry')
                                                ->where('id', $package_inquiry_accepted_data->packages_inquiry_id)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td style="display: none">{{ $i }}</td>
                                            <td>{{ date('d-m-Y', strtotime($packages_enquiry_data->added_date)) }}</td>
                                            <td><span class="fw-bold">{!! Helper::vendorsname($package_inquiry_accepted_data->vendor_id) !!}</span></td>
                                            <td><span
                                                    class="fw-bold text-primary">#{{ $packages_enquiry_data->inquiry_id }}</span>
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($package_inquiry_accepted_data->added_date)) }}
                                            </td>
                                            <td><span class="fw-bold">{{ $packages_enquiry_data->name ?? '' }}</span></td>
                                            <td>
                                                @if ($packages_enquiry_data->service_id ?? '')
                                                    <div class="fw-bold">{!! Helper::servicename(strval($packages_enquiry_data->service_id)) !!}</div>
                                                    @if ($packages_enquiry_data->subservice_id ?? '')
                                                        <div class="small text-muted">{!! Helper::subservicename(strval($packages_enquiry_data->subservice_id)) !!}</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold text-success">
                                                {{ $package_inquiry_accepted_data->price_of_lead ?? '0' }}
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer_js')
    {{-- Modals and Scripts remain identical to preserve logic --}}
    <div class="modal custom-modal fade" id="delete_model" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div class="modal-text text-center">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>
                </div>
            </div>
        </div>
    </div>

    @foreach ($package_inquiry_accepted as $package_inquiry_accepted_data)
        @php
            $packge_inquiry_data = DB::table('packages_enquiry')
                ->where('id', $package_inquiry_accepted_data->packages_inquiry_id)
                ->first();
            $quote_includes_data = DB::table('qoute_includes')
                ->where('package_inquiry_accepted_id', $package_inquiry_accepted_data->id)
                ->get()
                ->toArray();
        @endphp
        <div class="modal custom-modal fade" id="show_comment_model_{{ $package_inquiry_accepted_data->id }}"
            role="dialog">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 50% !important;">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-text text-center" id="dropdownreplace">
                            <div class="row">
                                <div id="quotes_leads">
                                    <table class="table table-bordered">
                                        <h6 class="mb-3">{{ $packge_inquiry_data->name }}</h6>
                                        <tr>
                                            <td>Status</td>
                                            <td>
                                                @php $i = 0; @endphp
                                                @foreach ($quote_includes_data as $quote_includes_data_new)
                                                    @if ($i == 0)
                                                        {{ $quote_includes_data_new->accept_lead == 'Enter Qoute' ? 'Quoted' : 'Requested a Survey' }}
                                                    @endif
                                                    @php $i++; @endphp
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Service Requested</td>
                                            <td>{{ $packge_inquiry_data->form_type ?? 'NA' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $packge_inquiry_data->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>{{ $packge_inquiry_data->mobile }}</td>
                                        </tr>
                                        @foreach ($quote_includes_data as $quote_data)
                                            <tr>
                                                <td>{{ $quote_data->qoute_includes_name }}</td>
                                                <td>{{ $quote_data->qoute_include_value }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function excel_download() {
            $('#filter_data').submit();
        }

        $('#vendor_id').select2({
            placeholder: "Select Vendors",
            allowClear: false
        });

        $('#vendor_id').on("select2:select", function(e) {
            var data = e.params.data.text;
            if (data === 'All Vendors') {
                $("#vendor_id > option").prop("selected", "selected");
                $("#vendor_id").trigger("change");
            }
        });

        function filter_validation() {
            var vendor_id = jQuery("#vendor_id").val();
            if (vendor_id == '') {
                jQuery('#vendor_id_error').html("Please Select Vendor");
                jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');
                return false;
            }
            $('#filter_form').submit();
        }

        function quotes_leads(id) {
            $('#show_comment_model_' + id).modal('show');
        }

        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }
            $('#example').dataTable({
                "searching": true,
                "language": {
                    "paginate": {
                        "next": '<i class="fa fa-angle-right"></i>',
                        "previous": '<i class="fa fa-angle-left"></i>'
                    }
                }
            });
        });
    </script>
@stop

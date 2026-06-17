    @extends('admin.includes.Template')
    @section('content')
        <style>
            /* Modern Layout Variables - Synced from Leads Enquiry */
            :root {
                --action-blue: #2563eb;
                --border-classic: #e2e8f0;
                --text-dark: #0f172a;
                --hover-bg: #f7df7e;
                --admin-header-height: 60px;
                /* Adjust based on your actual header height */
            }

            .content {
                overflow: visible !important;
            }

            /* Modern Bento-style Card */
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
                top: 0;
                z-index: 10;
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

            /* DataTables Pagination styling override */
            .dataTables_wrapper .dataTables_paginate {
                padding: 15px;
                display: flex;
                justify-content: flex-end;
                gap: 5px;
            }

            /* Custom Modal Table Styling */
            #table_new {
                border: 1px solid var(--border-classic) !important;
                border-radius: 8px;
                overflow: hidden;
            }

            #table_new td {
                padding: 10px;
                border: 1px solid var(--border-classic);
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
                        <h3 class="page-title">Garden & Mouse Accepted Leads</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Garden & Mouse Accepted Leads</li>
                        </ul>
                    </div>
                    <div class="col-auto d-flex gap-2">
                        <a class="btn btn-primary" href="javascript:void('0');" onclick="excel_download();">
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

            <form method="GET" action="{{ url('garden_accept_filter_data') }}" id="filter_data">
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
                    <form id="filter_form" action="{{ route('garden_accept') }}" method="POST">
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
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Vendor</label>
                                <select multiple="multiple" class="select select2-hidden-accessible" id="vendor_id"
                                    name="vendor_id[]">
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
                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="button" class="btn btn-primary w-100"
                                    onclick="filter_validation()">Submit</button>
                                <a class="btn btn-light border w-100" href="{{ route('garden_accept') }}">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="action-card">
                <div class="card-body p-4">
                    <form id="form" action="" enctype="multipart/form-data">
                        <input type="hidden" name="hidPgRefRan" value="<?php echo rand(); ?>">
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
                                        <th>Sub Service</th>
                                        <th>Lead Amount</th>
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
                                                        class="badge bg-primary-light text-primary">#{{ $packages_enquiry_data->inquiry_id }}</span>
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($package_inquiry_accepted_data->added_date)) }}
                                                </td>
                                                <td>{{ $packages_enquiry_data->name ?? '' }}</td>
                                                <td>
                                                    @if ($packages_enquiry_data->service_id ?? '')
                                                        <div class="fw-bold">{!! Helper::servicename(strval($packages_enquiry_data->service_id)) !!}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($packages_enquiry_data->subservice_id ?? '')
                                                        <div class="small text-muted">{!! Helper::subservicename(strval($packages_enquiry_data->subservice_id)) !!}</div>
                                                    @endif
                                                </td>
                                                <td class="fw-bold text-success">
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
        <script>
            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }
            $(document).ready(function() {
                $('#example').dataTable({
                    "searching": true
                });
            })
        </script>
    @stop

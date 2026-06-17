@extends('admin.includes.Template')
@section('content')
    <style>
        /* Modern Layout Variables */
        :root {
            --action-blue: #2563eb;
            --border-classic: #e2e8f0;
            --text-dark: #0f172a;
            --hover-bg: #f7df7e;
        }

        .content {
            overflow: visible !important;
        }

        /* Matches the Action Card style from Vendor List */
        .action-card {
            overflow: visible !important;
            background: #fff;
            border: 1px solid var(--border-classic);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        /* Consistent Table Header and Hover effects */
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

        /* Toggle Switch Styling */
        .toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .toggle input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #8B0000;
            transition: 0.4s;
            border-radius: 17px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #22c55e;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        /* DataTables Pagination styling */
        .dataTables_wrapper .dataTables_paginate {
            padding: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 5px;
        }

        .th-4 {
            width: 130px;
        }

        .th-7 {
            width: 80px;
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
                    <h3 class="page-title">Leads Enquiry</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Leads Enquiry</li>
                    </ul>
                </div>
                <div class="col-auto d-flex">
                    {{-- <div class="d-flex me-2">
                        <label class="toggle me-1">
                            <input type="checkbox" id="is_active_toggle"
                                {{ $system->auto_accept_package == 1 ? 'checked' : '' }}
                                onchange="fun_status(this.checked ? 1 : 0)" value="0">
                            <span class="slider"></span>
                        </label>
                        <p style="margin-top: 10px;">Auto Accept</p>
                    </div>
                    <a class="btn btn-primary me-2" href="{{ route('admin.movingenquiryadd') }}">
                        Add New Enquiry
                    </a>
                    <a class="btn btn-primary me-2" href="javascript:void('0');" onclick="excel_download();">
                        Excel Download
                    </a> --}}
                    <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Alerts Section --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
       
        @php
            $css =
                !empty($startdate) || !empty($enddate) || !empty($filter_service_id) || !empty($all_search)
                    ? 'display:block;'
                    : 'display:none;';
        @endphp

        <div id="filter_inputs" class="action-card mb-4" style="{{ $css }}">
            <div class="card-body p-4">
                <form id="filter_form" action="{{ route('evchargingleads.lists') }}" method="get">
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
                            <label class="form-label small fw-bold">Search</label>
                            <input type="text" class="form-control" name="all_search" id="all_search"
                                value="{{ $all_search ?: '' }}">
                        </div>
                        
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="filter_validation()">Submit</button>
                            <a class="btn btn-light border w-100" href="{{ route('evchargingleads.lists') }}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="action-card">
            <div class="card-body p-4"> {{-- p-0 to allow table to touch edges like vendor list --}}
                <form id="form" action="" enctype="multipart/form-data">
                    <input type="hidden" name="hidPgRefRan" value="<?php echo rand(); ?>">
                    @csrf
                    <div class="table-responsive">
                        <table class="action-table table-hover" id="example">
                            <thead>
                                <tr>
                                    <th style="display: none">Sr No</th>
                                    <th>Date</th>
                                    <th>Inquiry No</th>                                    
                                    <th>Customer Info</th>
                                    <th class="th-7">Service Info</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($packages_data as $data)
                                    <tr>
                                        <td style="display: none">{{ $i }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->added_date)) }}</td>
                                        <td><span class="fw-bold text-primary">#{{ $data->inquiry_id }}</span></td>
                                        
                                        <td>
                                            <span class="fw-bold">{{ $data->name }}</span>
                                            <div class="small">{{ $data->email }}</div>
                                            <div class="text-muted small">{{ $data->mobile }}</div>
                                        </td>
                                        
                                        <td>
                                            <div class="fw-bold">{!! Helper::servicename($data->service_id) !!}</div>
                                            <div class="small text-muted">{!! Helper::subservicename($data->subservice_id) !!}</div>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a class="btn btn-sm btn-outline-primary"
                                                    href="{{ route('evchargingleads.details', ['enquiry_id'=>$data->id]) }}" title="View Info">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                               
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
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
        
        

        function filter_validation() {
            // var vendor_id = jQuery("#vendor_id").val();
            // if (vendor_id == '') {
            //     jQuery('#vendor_id_error').html("Please Select Vendor");
            //     jQuery('#vendor_id_error').show().delay(0).fadeIn('show');
            //     jQuery('#vendor_id_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#vendor_id').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            $('#filter_form').submit();
        }
    </script>
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

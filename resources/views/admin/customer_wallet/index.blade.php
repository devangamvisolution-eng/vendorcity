@extends('admin.includes.Template')

@section('content')
<style>
    .premium-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        background: #fff;
        margin-bottom: 24px;
    }

    .premium-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #e9ecef;
    }

    .premium-table thead th {
        background-color: #428df5;
        color: #ffffff;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #eef2f5;
        padding: 16px;
        white-space: nowrap;
        border-right: 1px solid rgba(255, 255, 255, 0.3);
    }

    .premium-table thead th:last-child {
        border-right: none;
    }

    .premium-table tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #555;
        border-bottom: 1px solid #e9ecef;
        border-right: 1px solid #e9ecef;
        font-size: 14px;
        transition: background-color 0.2s ease;
    }

    .premium-table tbody td:last-child {
        border-right: none;
    }

    .premium-table tbody tr:nth-child(even) td {
        background-color: #f9f9f9;
    }

    .premium-table tbody tr:hover td {
        background-color: #eaeaea;
    }

    .premium-table tbody tr:hover td:first-child {
        box-shadow: inset 3px 0 0 #ffc107;
    }

    .premium-table tbody tr:hover td:last-child {
        box-shadow: inset -3px 0 0 #ffc107;
    }
</style>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Customer Wallets</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customer Wallets</li>
                    </ul>
                </div>
                
                @if (in_array('86', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary filter-btn me-1" href="javascript:void(0);" id="wallet_filter_btn" title="Filter Transactions">
                            <i class="fas fa-filter"></i>
                        </a>
                        <a href="{{ route('customer-wallet.create') }}" class="btn btn-primary me-1" title="Add Wallet Money">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a href="{{ route('customer-wallet.edit') }}" class="btn btn-danger me-1" title="Deduct Wallet Money">
                            <i class="fas fa-minus"></i>
                        </a>
                    </div>
                @endif
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $isFilterApplied = request()->filled('start_date') ||
            request()->filled('end_date') ||
            request()->filled('customer_id') ||
            request()->filled('status');
    @endphp
    <div id="filter_inputs" class="card filter-card" style="display: {{ $isFilterApplied ? 'block' : 'none' }};">
        <div class="row mb-4 ">
            <div class="col-sm-12">
                <div class="card premium-card">
                    <div class="card-header pb-0 border-0 bg-white pt-3">
                        <h5 class="card-title mb-0" style="font-size: 16px; font-weight: 600; color: #333;">
                            <i class="fas fa-filter text-muted me-2"></i> Filter Transactions
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer-wallet.index') }}" method="GET" id="filterForm">
                            <div class="row align-items-end">
                                <div class="col-md-3 mb-3">
                                    <label style="font-size: 12px; font-weight: 500; color: #555;">Start Date</label>
                                    <input type="date" name="start_date" class="form-control form-control-sm"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label style="font-size: 12px; font-weight: 500; color: #555;">End Date</label>
                                    <input type="date" name="end_date" class="form-control form-control-sm"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label style="font-size: 12px; font-weight: 500; color: #555;">Customer</label>
                                    <select name="customer_id" class="form-control form-control-sm select2">
                                        <option value="">All</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} ({{ $customer->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label style="font-size: 12px; font-weight: 500; color: #555;">Status</label>
                                    <select name="status" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Added (+)</option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Deducted (-)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3 text-right">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('customer-wallet.index') }}" class="btn btn-light btn-sm"><i class="fas fa-undo"></i></a>
                                    <button type="submit" name="export" value="excel" class="btn btn-success btn-sm mt-1 mt-md-0" title="Download Excel">
                                        <i class="fas fa-file-excel"></i> Excel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table premium-table" id="example">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Date</th>
                                    <th>Customer Id</th>
                                    <th>Customer Info</th>
                                    <th>Note</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($transactions as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            @if($data->added_date && $data->added_date != '0000-00-00')
                                                {{ date('d-m-Y', strtotime($data->added_date)) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $data->customer_id }}</td>
                                        <td>
                                            <strong>{{ $data->name }}</strong><br>
                                            <span class="text-muted" style="font-size: 12px;">{{ $data->country_code }} {{ $data->mobile }}</span><br>
                                            <span class="text-muted" style="font-size: 12px;">{{ $data->email }}</span>
                                        </td>
                                        <td>{{ $data->note ?? '-' }}</td>
                                        <td>
                                            <strong>AED {{ number_format($data->wallet_amount, 2) }}</strong><br>
                                            @if($data->added_from == 0)
                                                <span class="badge bg-success">Added</span>
                                            @else
                                                <span class="badge bg-danger">Deducted</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#wallet_filter_btn').click(function(e) {
            e.preventDefault();
            $('#filter_inputs').slideToggle();
        });

        if ($('.select2').length > 0) {
            $('.select2').select2({
                placeholder: "Select a customer...",
                allowClear: true
            });
        }
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }
        $('#example').dataTable({
            "searching": true
        });
    });
</script>
@stop
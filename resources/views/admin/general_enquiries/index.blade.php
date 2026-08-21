@extends('admin.includes.Template')
@section('content')
    <style>
        .badge-pending {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .badge-followup {
            background-color: #fd7e14 !important;
            color: #fff !important;
        }

        .badge-completed {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        .badge-booked {
            background-color: #198754 !important;
            color: #fff !important;
        }

        .badge-lost {
            background-color: #dc3545 !important;
            color: #fff !important;
        }

        .badge-invalid {
            background-color: #6c757d !important;
            color: #fff !important;
        }

        .badge-vendor {
            background-color: #6f42c1 !important;
            color: #fff !important;
        }

        .badge-job {
            background-color: #d63384 !important;
            color: #fff !important;
        }

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

        .premium-table tbody tr:hover td {
            background-color: #eaeaea;
        }

        .premium-table tbody tr:hover td:first-child {
            box-shadow: inset 3px 0 0 #ffc107;
        }

        .premium-table tbody tr:hover td:last-child {
            box-shadow: inset -3px 0 0 #ffc107;
        }

        .btn-premium {
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
        }
    </style>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">General Enquiries</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Enquiries</li>
                    </ul>
                </div>
                @if (in_array('76', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary shadow-sm me-1" href="{{ route('general-enquiries.create') }}">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a class="btn btn-primary shadow-sm me-1" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        @php
            $isFilterApplied =
                request()->filled('start_date') ||
                request()->filled('end_date') ||
                request()->filled('customer_id') ||
                request()->filled('status') ||
                request()->filled('salesperson_id') ||
                request()->filled('source_lead_id') ||
                request()->filled('service_id') ||
                request()->filled('subservice_id');
        @endphp
        <div id="filter_inputs" class="card filter-card" style="display: {{ $isFilterApplied ? 'block' : 'none' }};">
            <div class="row mb-4 ">
                <div class="col-sm-12">
                    <div class="card premium-card">
                        <div class="card-header pb-0 border-0 bg-white pt-3">
                            <h5 class="card-title mb-0" style="font-size: 16px; font-weight: 600; color: #333;"><i
                                    class="fas fa-filter text-muted me-2"></i> Filter Enquiries</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('general-enquiries.index') }}" method="GET" id="filterForm">
                                <div class="row align-items-end">
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Start Date</label>
                                        <input type="date" name="start_date" class="form-control form-control-sm"
                                            value="{{ request('start_date') }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">End Date</label>
                                        <input type="date" name="end_date" class="form-control form-control-sm"
                                            value="{{ request('end_date') }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Customer</label>
                                        <select name="customer_id" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Status</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="Followup"
                                                {{ request('status') == 'Followup' ? 'selected' : '' }}>
                                                Followup</option>
                                            <option value="Completed"
                                                {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                                Completed</option>
                                            <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }}>
                                                Booked
                                            </option>
                                            <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Lost
                                            </option>
                                            <option value="Invalid" {{ request('status') == 'Invalid' ? 'selected' : '' }}>
                                                Invalid
                                            </option>
                                            <option value="Vendor" {{ request('status') == 'Vendor' ? 'selected' : '' }}>
                                                Vendor
                                            </option>
                                            <option value="Job" {{ request('status') == 'Job' ? 'selected' : '' }}>Job
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Salesperson</label>
                                        <select name="salesperson_id" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @foreach ($salespersons as $salesperson)
                                                <option value="{{ $salesperson->id }}"
                                                    {{ request('salesperson_id') == $salesperson->id ? 'selected' : '' }}>
                                                    {{ $salesperson->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Source of
                                            Lead</label>
                                        <select name="source_lead_id" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @foreach ($source_leads as $source)
                                                <option value="{{ $source->id }}"
                                                    {{ request('source_lead_id') == $source->id ? 'selected' : '' }}>
                                                    {{ $source->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Service</label>
                                        <select name="service_id" id="filter_service_id"
                                            class="form-control form-control-sm"
                                            onchange="getFilterSubServices(this.value)">
                                            <option value="">All</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                                    {{ $service->servicename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Sub Service</label>
                                        <select name="subservice_id" id="filter_subservice_id"
                                            class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @if (isset($subservices))
                                                @foreach ($subservices as $subservice)
                                                    <option value="{{ $subservice->id }}"
                                                        {{ request('subservice_id') == $subservice->id ? 'selected' : '' }}>
                                                        {{ $subservice->subservicename }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 text-end mt-2">
                                        <button type="submit" class="btn btn-sm btn-primary px-3 rounded"><i
                                                class="fas fa-search"></i> Search</button>
                                        <a href="{{ route('general-enquiries.index') }}"
                                            class="btn btn-sm btn-light border px-3 rounded"><i class="fas fa-sync"></i>
                                            Reset</a>
                                        <button type="submit" name="export" value="excel"
                                            class="btn btn-sm btn-success px-3 rounded ms-2"><i
                                                class="fas fa-file-excel"></i>
                                            Download Excel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Subservice Summary -->
            <div class="col-md-4 mb-3">
                <div class="card premium-card h-100">
                    <div class="card-header pb-2 pt-3 border-0" style="background-color: #f8f9fa;">
                        <h6 class="mb-0 text-uppercase"
                            style="font-size: 12px; font-weight: 600; color: #555; letter-spacing: 0.5px;">Subservice Wise
                            Count
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 250px;">
                            <table class="table table-sm table-borderless mb-0">
                                <tbody>
                                    @forelse($subservice_summary as $summary)
                                        <tr>
                                            <td class="px-3 py-2 border-bottom" style="font-size: 13px; color: #555;">
                                                {{ $summary->name ?? 'Unknown' }}
                                            </td>
                                            <td class="px-3 py-2 border-bottom text-end fw-bold"
                                                style="font-size: 13px; color: #333;">{{ $summary->total }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-3 py-2 text-muted text-center" style="font-size: 13px;">No Data
                                                Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Source of Lead Summary -->
            <div class="col-md-4 mb-3">
                <div class="card premium-card h-100">
                    <div class="card-header pb-2 pt-3 border-0" style="background-color: #f8f9fa;">
                        <h6 class="mb-0 text-uppercase"
                            style="font-size: 12px; font-weight: 600; color: #555; letter-spacing: 0.5px;">Source Wise
                            Count
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 250px;">
                            <table class="table table-sm table-borderless mb-0">
                                <tbody>
                                    @forelse($source_summary as $summary)
                                        <tr>
                                            <td class="px-3 py-2 border-bottom" style="font-size: 13px; color: #555;">
                                                {{ $summary->name ?? 'Unknown' }}
                                            </td>
                                            <td class="px-3 py-2 border-bottom text-end fw-bold"
                                                style="font-size: 13px; color: #333;">{{ $summary->total }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-3 py-2 text-muted text-center" style="font-size: 13px;">No Data
                                                Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Summary -->
            <div class="col-md-4 mb-3">
                <div class="card premium-card h-100">
                    <div class="card-header pb-2 pt-3 border-0" style="background-color: #f8f9fa;">
                        <h6 class="mb-0 text-uppercase"
                            style="font-size: 12px; font-weight: 600; color: #555; letter-spacing: 0.5px;">Status Wise
                            Count
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 250px;">
                            <table class="table table-sm table-borderless mb-0">
                                <tbody>
                                    @forelse($status_summary as $summary)
                                        <tr>
                                            <td class="px-3 py-2 border-bottom" style="font-size: 13px; color: #555;">
                                                @php
                                                    $statusName = $summary->name ?? 'Pending';
                                                    $badgeClass = 'badge-' . strtolower($statusName);
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ ucfirst($statusName) }}</span>
                                            </td>
                                            <td class="px-3 py-2 border-bottom text-end fw-bold"
                                                style="font-size: 13px; color: #333;">{{ $summary->total }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-3 py-2 text-muted text-center" style="font-size: 13px;">No Data
                                                Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card premium-card">
                    <div class="card-body">
                        <div class="table-responsive" style="min-height: 300px; overflow-x: auto;">
                            <table class="table premium-table" id="enquiry_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer Info</th>
                                        <th>Service & Sub Service</th>
                                        <th>Source of Lead</th>
                                        <th>Status</th>
                                        <th>Salesperson</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enquiries as $enquiry)
                                        <tr>
                                            <td>{{ $enquiry->id }}</td>
                                            <td>
                                                <strong>{{ $enquiry->customer_name ?: ($enquiry->c_name ?: 'Unknown / Guest') }}</strong><br>
                                                <small>{{ $enquiry->country_code }}
                                                    {{ $enquiry->customer_phone ?: ($enquiry->c_mobile ?: '-') }}</small>
                                            </td>
                                            <td>
                                                @if ($enquiry->service_id == 0)
                                                    <strong>{{ $enquiry->other_service }} <span class="badge bg-secondary"
                                                            style="font-size: 10px;">Unknown</span></strong><br>
                                                @else
                                                    <strong>{{ $enquiry->servicename }}</strong><br>
                                                    <small>{{ $enquiry->subservicename }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $sIds = $enquiry->source_lead_id
                                                        ? explode(',', $enquiry->source_lead_id)
                                                        : [];
                                                    $foundAny = false;
                                                @endphp
                                                @foreach ($source_leads as $sl)
                                                    @if (in_array($sl->id, $sIds))
                                                        <span
                                                            class="badge bg-info text-dark mb-1">{{ $sl->name }}</span><br>
                                                        @php $foundAny = true; @endphp
                                                    @endif
                                                @endforeach
                                                @if (!$foundAny)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $currentStatus = $enquiry->status ?? 'Pending';
                                                @endphp
                                                <select class="form-select form-select-sm status-dropdown"
                                                    data-id="{{ $enquiry->id }}" style="min-width: 110px;">
                                                    <option value="Pending"
                                                        {{ $currentStatus == 'Pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="Followup"
                                                        {{ $currentStatus == 'Followup' ? 'selected' : '' }}>Followup
                                                    </option>
                                                    <option value="Completed"
                                                        {{ $currentStatus == 'Completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                    <option value="Booked"
                                                        {{ $currentStatus == 'Booked' ? 'selected' : '' }}>Booked</option>
                                                    <option value="Lost"
                                                        {{ $currentStatus == 'Lost' ? 'selected' : '' }}>Lost</option>
                                                    <option value="Invalid"
                                                        {{ $currentStatus == 'Invalid' ? 'selected' : '' }}>Invalid
                                                    </option>
                                                    <option value="Vendor"
                                                        {{ $currentStatus == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                                                    <option value="Job"
                                                        {{ $currentStatus == 'Job' ? 'selected' : '' }}>Job</option>
                                                </select>
                                            </td>
                                            <td>
                                                @if ($enquiry->salesperson_id)
                                                    <strong>{{ $enquiry->salesperson_name }}</strong>
                                                @else
                                                    <span class="text-muted">Not Assigned</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d M Y', strtotime($enquiry->created_at)) }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-warning text-warning fw-bold"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                                        style="border: 1px solid #ffc107; background: transparent; padding: 4px 10px; border-radius: 6px;">
                                                        ...
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                                        @if (in_array('76', $edit_perm))
                                                            <li>
                                                                <a class="dropdown-item py-2"
                                                                    href="{{ route('general-enquiries.edit', $enquiry->id) }}">
                                                                    <i class="fas fa-edit text-primary me-2"></i> Edit
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item py-2 assign-btn"
                                                                href="javascript:void(0)" data-id="{{ $enquiry->id }}"
                                                                data-salesperson="{{ $enquiry->salesperson_id }}"
                                                                data-status="{{ $currentStatus }}">
                                                                <i class="fas fa-user-plus text-success me-2"></i> Assign
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-2 view-notes-btn"
                                                                href="javascript:void(0)" data-id="{{ $enquiry->id }}">
                                                                <i class="fas fa-sticky-note text-info me-2"></i> Notes
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('general-enquiries.destroy', $enquiry->id) }}"
                                                                method="POST" style="display:inline;"
                                                                class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="dropdown-item py-2 delete-btn text-danger">
                                                                    <i class="fas fa-trash me-2"></i> Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Removed server-side pagination links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Modal -->
    <div class="modal fade" id="notesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-sticky-note text-info me-2"></i> Enquiry Notes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="modal_notes_list" class="mb-4" style="max-height: 300px; overflow-y: auto;">
                        <!-- Notes will be injected here via AJAX -->
                    </div>

                    <hr>

                    <form id="addNoteForm">
                        <input type="hidden" id="note_enquiry_id" name="enquiry_id">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Add New Note</label>
                            <input type="date" class="form-control mb-2" id="new_note_date" name="note_date"
                                required>
                            <textarea class="form-control" id="new_note_text" name="note" rows="3"
                                placeholder="Enter your note here..." required></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" id="saveNoteBtn">Save Note</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Salesperson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="assignForm">
                        <input type="hidden" id="assign_enquiry_id" name="enquiry_id">
                        <div class="mb-3">
                            <label class="form-label">Salesperson</label>
                            <select class="form-select" id="assign_salesperson_id" name="salesperson_id">
                                <option value="">-- Select Salesperson --</option>
                                @foreach ($salespersons as $sp)
                                    <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveAssignBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('footer_js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
            if ($.fn.DataTable.isDataTable('#enquiry_table')) {
                $('#enquiry_table').DataTable().destroy();
            }
            $('#enquiry_table').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 10,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Showing _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                }
            });

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this enquiry!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            $(document).on('click', '.assign-btn', function() {
                var id = $(this).data('id');
                var salesperson = $(this).data('salesperson');

                $('#assign_enquiry_id').val(id);
                $('#assign_salesperson_id').val(salesperson);

                $('#assignModal').modal('show');
            });

            $('#saveAssignBtn').on('click', function() {
                var btn = $(this);
                btn.prop('disabled', true).html('Saving...');

                $.ajax({
                    url: "{{ route('general-enquiries.assign') }}",
                    type: "POST",
                    data: {
                        enquiry_id: $('#assign_enquiry_id').val(),
                        salesperson_id: $('#assign_salesperson_id').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#assignModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                            btn.prop('disabled', false).html('Save changes');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred while saving.', 'error');
                        btn.prop('disabled', false).html('Save changes');
                    }
                });
            });

            // View Notes logic
            $(document).on('click', '.view-notes-btn', function() {
                var enquiryId = $(this).data('id');
                $('#note_enquiry_id').val(enquiryId);
                $('#new_note_date').val('');
                $('#new_note_text').val('');

                loadNotes(enquiryId);
                $('#notesModal').modal('show');
            });

            $('#addNoteForm').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#saveNoteBtn');
                var enquiryId = $('#note_enquiry_id').val();

                btn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: "{{ url('admin/general-enquiries') }}/" + enquiryId + "/notes",
                    type: "POST",
                    data: {
                        note_date: $('#new_note_date').val(),
                        note: $('#new_note_text').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#new_note_date').val('');
                            $('#new_note_text').val('');
                            loadNotes(enquiryId);
                        } else {
                            Swal.fire('Error', response.message || 'Error saving note.',
                                'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred while saving the note.', 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).text('Save Note');
                    }
                });
            });

            function loadNotes(enquiryId) {
                var notesList = $('#modal_notes_list');
                notesList.html(
                    '<div class="text-center p-3"><span class="spinner-border spinner-border-sm"></span> Loading notes...</div>'
                    );

                $.ajax({
                    url: "{{ url('admin/general-enquiries') }}/" + enquiryId + "/notes",
                    type: "GET",
                    success: function(response) {
                        if (response.success) {
                            if (response.notes.length === 0) {
                                notesList.html(
                                    '<div class="text-muted text-center p-3">No notes available.</div>'
                                    );
                            } else {
                                var html = '';
                                response.notes.forEach(function(note) {
                                    var creator = note.creator_name ? note.creator_name :
                                        'Unknown';
                                    var date = note.note_date ? new Date(note.note_date)
                                        .toLocaleDateString() : '';
                                    html += `
                                        <div class="card mb-2 border-0 bg-light">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <strong>${creator}</strong>
                                                    <span class="text-muted small"><i class="fas fa-calendar-alt"></i> ${date}</span>
                                                </div>
                                                <div style="white-space: pre-wrap; font-size: 14px; color: #444;">${note.note}</div>
                                            </div>
                                        </div>
                                    `;
                                });
                                notesList.html(html);
                            }
                        }
                    },
                    error: function() {
                        notesList.html(
                            '<div class="text-danger text-center p-3">Failed to load notes.</div>');
                    }
                });
            }

            // Status Dropdown Change Event
            $(document).on('change', '.status-dropdown', function() {
                var select = $(this);
                var id = select.data('id');
                var newStatus = select.val();

                select.prop('disabled', true);

                $.ajax({
                    url: "{{ route('general-enquiries.update-status') }}",
                    type: "POST",
                    data: {
                        enquiry_id: id,
                        status: newStatus,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        select.prop('disabled', false);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        select.prop('disabled', false);
                        Swal.fire('Error', 'An error occurred while updating status.', 'error');
                    }
                });
            });
        });

        function getFilterSubServices(service_id) {
            let subserviceDropdown = $('#filter_subservice_id');
            subserviceDropdown.html('<option value="">Loading...</option>');

            if (!service_id) {
                subserviceDropdown.html('<option value="">All</option>');
                return;
            }

            $.ajax({
                url: "{{ route('general-enquiries.get-subservices') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    service_id: service_id
                },
                success: function(response) {
                    let options = '<option value="">All</option>';
                    if (response && response.length > 0) {
                        response.forEach(function(subservice) {
                            options +=
                                `<option value="${subservice.id}">${subservice.subservicename}</option>`;
                        });
                    }
                    subserviceDropdown.html(options);
                },
                error: function() {
                    subserviceDropdown.html('<option value="">All</option>');
                }
            });
        }
    </script>
@endsection

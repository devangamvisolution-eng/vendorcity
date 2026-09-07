@extends('admin.includes.Template')
@section('content')

@php
    $userId = Auth::id();
    $get_user_data = Helper::get_user_data($userId);
    $roleIds = explode(',', $get_user_data->role_id ?? '');
    $edit_perm = [];
    foreach ($roleIds as $roleId) {
        $roleId = trim($roleId);
        $get_permission_data = Helper::get_permission_data($roleId);
        if (is_object($get_permission_data) && property_exists($get_permission_data, 'editperm') && $get_permission_data->editperm !== '') {
            $edit_perm = array_merge($edit_perm, explode(',', $get_permission_data->editperm));
        }
    }
    $edit_perm = array_unique($edit_perm);
@endphp


    <style>
        .premium-card { border: none; border-radius: 12px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06); background: #fff; margin-bottom: 24px; padding: 20px; }
        .premium-table { border-collapse: separate; border-spacing: 0; width: 100%; border: 1px solid #e9ecef; }
        .premium-table thead th { background-color: #428df5; color: #ffffff; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; border-bottom: 2px solid #eef2f5; padding: 16px; white-space: nowrap; border-right: 1px solid rgba(255, 255, 255, 0.3); }
        .premium-table thead th:last-child { border-right: none; }
        .premium-table tbody td { padding: 16px; vertical-align: middle; color: #555; border-bottom: 1px solid #e9ecef; border-right: 1px solid #e9ecef; font-size: 14px; transition: background-color 0.2s ease; }
        .premium-table tbody td:last-child { border-right: none; }
        .premium-table tbody tr:hover td { background-color: #eaeaea; }
        .premium-table tbody tr:hover td:first-child { box-shadow: inset 3px 0 0 #ffc107; }
        .premium-table tbody tr:hover td:last-child { box-shadow: inset -3px 0 0 #ffc107; }
        .btn-premium { border-radius: 8px; font-weight: 500; padding: 10px 20px; transition: all 0.3s; border: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3); }
    </style>

<div class='content container-fluid'><div class='page-header'><div class='row align-items-center'><div class='col'><h3 class='page-title'>Cleaning Subscription Packages</h3><ul class='breadcrumb'><li class='breadcrumb-item'><a href="{{ url('/admin') }}">Dashboard</a></li><li class='breadcrumb-item active'>Cleaning Subscription Packages</li></ul></div>@if(in_array('79', $edit_perm))<div class='col-auto'><a class='btn btn-primary btn-premium' href="{{ route('cleaning-subscription-packages.create') }}"><i class='fas fa-plus'></i> Add New</a></div>@endif</div></div><div class='row'><div class='col-sm-12'><div class='card premium-card'><div class='card-body p-0'><div class='table-responsive'><table class='table premium-table'><thead><tr><th>ID</th><th>Name</th><th>Validity months</th><th>Discount percentage</th><th>Order</th><th>Web</th><th>App</th><th>Action</th></tr></thead><tbody>@foreach($data as $row)<tr><td>{{ $row->id }}</td><td>{{ $row->name }}</td><td>{{ $row->validity_months }}</td><td>{{ $row->discount_percentage }}</td><td>{{ $row->set_order }}</td>
            <td>
                <span class="badge {{ $row->is_active_web ? 'bg-success' : 'bg-danger' }}">{{ $row->is_active_web ? 'Active' : 'Deactive' }}</span>
            </td>
            <td>
                <span class="badge {{ $row->is_active_app ? 'bg-success' : 'bg-danger' }}">{{ $row->is_active_app ? 'Active' : 'Deactive' }}</span>
            </td>
            <td>
    <div class="dropdown">
        <button class="btn btn-sm btn-outline-warning text-warning fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid #ffc107; background: transparent; padding: 4px 10px; border-radius: 6px;">
            ...
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
            @if(in_array('79', $edit_perm))
            <li>
                <a class="dropdown-item py-2" href="{{ route('cleaning-subscription-packages.edit', $row->id) }}">
                    <i class="fas fa-edit text-primary me-2"></i> Edit
                </a>
            </li>
            <li>
                <form id="delete-form-{{ $row->id }}" action="{{ route('cleaning-subscription-packages.destroy', $row->id) }}" method="POST" style="display:inline;" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="dropdown-item py-2 delete-btn text-danger" onclick="confirmDelete({{ $row->id }})">
                        <i class="fas fa-trash me-2"></i> Delete
                    </button>
                </form>
            </li>
            @endif
        </ul>
    </div>
</td></tr>@endforeach</tbody></table></div></div></div></div></div></div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable(".premium-table")) {
            $(".premium-table").DataTable({
                "pageLength": 25,
                "ordering": false // Keep the desc order from backend
            });
        }
    });
</script>

@endsection
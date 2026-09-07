@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
        $get_user_data = Helper::get_user_data($userId);
        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);
        // $edit_perm = [];
        // if ($get_permission_data->editperm != '') {
        //     $edit_perm = $get_permission_data->editperm;
        //     $edit_perm = explode(',', $edit_perm);
        // }
        $roleIds = explode(',', $get_user_data->role_id);

        $edit_perm = [];

        foreach ($roleIds as $roleId) {
            $roleId = trim($roleId); // Clean any spaces

            $get_permission_data = Helper::get_permission_data($roleId);

            if (
                is_object($get_permission_data) &&
                property_exists($get_permission_data, 'editperm') &&
                $get_permission_data->editperm != ''
            ) {
                $perms = explode(',', $get_permission_data->editperm);
                $edit_perm = array_merge($edit_perm, $perms); // Combine permissions
            }
        }

        // Optional: remove duplicates and reset array keys
        $edit_perm = array_values(array_unique($edit_perm));

    @endphp
    <style type="text/css">
        /* Premium UI Styles */
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

        /* Toggle Slider Styles */
        .toggle {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .toggle input[type="checkbox"] {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #dc3545;
            /* Modern red for inactive */
            transition: 0.4s;
            border-radius: 26px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        input[type="checkbox"]:checked+.slider {
            background-color: #198754;
            /* Modern green for active */
        }

        input[type="checkbox"]:checked+.slider:before {
            transform: translateX(24px);
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Vendors</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Vendors</li>
                    </ul>
                </div>
                @if (in_array('8', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary shadow-sm me-1" href="javascript:void(0);" id="filter_search">
                            <i class="fas fa-filter"></i>
                        </a>
                        <a class="btn btn-primary shadow-sm me-1" href="{{ route('vendors.create') }}">
                            <i class="fas fa-plus"></i>
                        </a>
                        <a class="btn btn-danger shadow-sm me-1" href="javascript:void('0');" onclick="delete_category();">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
        </div>

        <!-- Filter Form -->
        <div id="filter_inputs" class="card filter-card mb-4"
            style="display: {{ request()->has('service_id') || request()->has('subservice_id') || request()->has('city_id') || request()->has('status') ? 'block' : 'none' }};">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card premium-card">
                        <div class="card-header pb-0 border-0 bg-white pt-3">
                            <h5 class="card-title mb-0" style="font-size: 16px; font-weight: 600; color: #333;"><i
                                    class="fas fa-filter text-muted me-2"></i> Filter Vendors</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vendors.index') }}" method="GET" id="filterForm">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Service</label>
                                        <select name="service_id" id="filter_service_id"
                                            class="form-control form-control-sm select2">
                                            <option value="">All</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                                    {!! Helper::servicename($service->id) !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Subservice</label>
                                        <select name="subservice_id" id="filter_subservice_id"
                                            class="form-control form-control-sm select2">
                                            <option value="">All</option>
                                            @foreach ($subservices as $subservice)
                                                <option value="{{ $subservice->id }}"
                                                    {{ request('subservice_id') == $subservice->id ? 'selected' : '' }}>
                                                    {{ $subservice->subservicename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">City</label>
                                        <select name="city_id" class="form-control form-control-sm select2">
                                            <option value="">All</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label style="font-size: 12px; font-weight: 500; color: #555;">Status</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                                                Deactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3 text-end">
                                        <button type="submit" class="btn btn-sm btn-primary px-3 rounded"><i
                                                class="fas fa-search"></i> Search</button>
                                        <a href="{{ route('vendors.index') }}"
                                            class="btn btn-sm btn-light border px-3 rounded"><i class="fas fa-sync"></i>
                                            Reset</a>
                                        <button type="submit" name="export" value="excel"
                                            formaction="{{ url('excel_download_vendors') }}" formmethod="POST"
                                            class="btn btn-sm btn-success px-3 rounded ms-2" id="downloadExcelBtn"><i
                                                class="fas fa-file-excel"></i> Download Excel</button>
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
                <div class="card premium-card">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_vendors') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive dropdown-container"
                                style="min-height: 300px; padding-bottom: 15px;">
                                <table class="table premium-table" id="example">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
                                            <th>Vendor Id</th>
                                            {{-- <th>Role</th> --}}
                                            <th>Vendor Data</th>
                                            <th>Wallet Amount</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < count($vendors_data); $i++)
                                            <tr>
                                                <td><input name="selected[]" id="selected[]"
                                                        value="{{ $vendors_data[$i]->id }}" type="checkbox"
                                                        class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">
                                                </td>
                                                {{-- <td>
                                                    {!! Helper::user_role_name($vendors_data[$i]->role_id) !!}
                                                </td> --}}
                                                <td>
                                                    {{ $vendors_data[$i]->vendor_id }}
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column gap-1">
                                                        <span class="fw-bold text-dark"
                                                            style="font-size: 15px;">{{ $vendors_data[$i]->name }}</span>
                                                        <span class="text-muted" style="font-size: 13px;"><i
                                                                class="fas fa-envelope text-secondary me-1"></i>
                                                            {{ $vendors_data[$i]->email }}</span>
                                                        <span class="text-muted" style="font-size: 13px;"><i
                                                                class="fas fa-phone-alt text-secondary me-1"></i>
                                                            {{ $vendors_data[$i]->mobile == 0 ? '-' : $vendors_data[$i]->mobile }}</span>
                                                    </div>
                                                </td>
                                                @php
                                                    $services = array_filter(
                                                        explode(',', $vendors_data[$i]->serviceList),
                                                    );
                                                    $vendors_city = array_filter(explode(',', $vendors_data[$i]->city));
                                                    $city_names = [];
                                                    foreach ($vendors_city as $city_id) {
                                                        $name = Helper::cityname(trim($city_id));
                                                        if (!empty($name)) {
                                                            $city_names[] = $name;
                                                        }
                                                    }
                                                @endphp

                                                <td>{{ $vendors_data[$i]->wallet_amount }}</td>
                                                <td>
                                                    <div class="form-group">
                                                        <label class="toggle">
                                                            <input type="checkbox" id="is_active_toggle"
                                                                {{ $vendors_data[$i]->is_active == 0 ? 'checked' : '' }}
                                                                onchange="fun_status('{{ $vendors_data[$i]->id }}', this.checked ? 0 : 1); return false;">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-warning text-warning fw-bold"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                            style="border: 1px solid #ffc107; background: transparent; padding: 4px 10px; border-radius: 6px;">
                                                            ...
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                                                            style="border-radius: 8px;">
                                                            @if (in_array('8', $edit_perm))
                                                                <li>
                                                                    <a class="dropdown-item py-2"
                                                                        href="{{ route('vendors.edit', $vendors_data[$i]->id) }}">
                                                                        <i class="far fa-edit text-primary me-2"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item py-2"
                                                                        href="{{ route('vendors.subscription', $vendors_data[$i]->id) }}">
                                                                        <i class="fas fa-crown text-info me-2"></i>
                                                                        Subscription
                                                                    </a>
                                                                </li>
                                                                @if (in_array('1', $roleIds))
                                                                    <li>
                                                                        <a class="dropdown-item py-2"
                                                                            href="{{ route('admin.vendors.verify-documents.form', $vendors_data[$i]->id) }}">
                                                                            <i
                                                                                class="fas fa-check-circle text-success me-2"></i>
                                                                            Verify Document
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item py-2"
                                                                            href="{{ route('admin.vendors.contracts', $vendors_data[$i]->id) }}">
                                                                            <i
                                                                                class="fas fa-file-signature text-secondary me-2"></i>
                                                                            Manage Contracts
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                            <li>
                                                                <a class="dropdown-item py-2"
                                                                    href="{{ route('vendor_login', $vendors_data[$i]->id) }}">
                                                                    <i class="fas fa-sign-in-alt text-warning me-2"></i>
                                                                    Vendor Login
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2" href="javascript:void(0)"
                                                                    onclick="showServicesModal('{{ $vendors_data[$i]->id }}')">
                                                                    <i class="fas fa-list text-secondary me-2"></i> View
                                                                    Services ({{ count($services) }})
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2" href="javascript:void(0)"
                                                                    onclick="showCitiesModal('{{ $vendors_data[$i]->id }}')">
                                                                    <i
                                                                        class="fas fa-map-marker-alt text-secondary me-2"></i>
                                                                    View Cities ({{ count($city_names) }})
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <!-- Hidden Content for Modals -->
                                                    <div id="services-content-{{ $vendors_data[$i]->id }}"
                                                        style="display: none;">
                                                        <div class="p-3 bg-light">
                                                            @foreach ($services as $service)
                                                                <div
                                                                    class="d-flex align-items-center p-3 mb-2 bg-white rounded shadow-sm border-start border-4 border-info premium-hover">
                                                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                                                                        style="width: 35px; height: 35px;">
                                                                        <i class="fas fa-check text-info"></i>
                                                                    </div>
                                                                    <span class="fw-bold text-dark fs-6"
                                                                        style="letter-spacing: 0.3px;">{!! Helper::servicename($service) !!}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div id="cities-content-{{ $vendors_data[$i]->id }}"
                                                        style="display: none;">
                                                        <div class="p-3 bg-light">
                                                            @foreach ($city_names as $cname)
                                                                <div
                                                                    class="d-flex align-items-center p-3 mb-2 bg-white rounded shadow-sm border-start border-4 border-secondary premium-hover">
                                                                    <div class="bg-secondary bg-opacity-10 rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                                                                        style="width: 35px; height: 35px;">
                                                                        <i
                                                                            class="fas fa-map-marker-alt text-secondary"></i>
                                                                    </div>
                                                                    <span class="fw-bold text-dark fs-6"
                                                                        style="letter-spacing: 0.3px;">{{ $cname }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                                <!-- Laravel pagination removed in favor of DataTables -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_js')
    <!-- Delete Category Modal -->
    <div class="modal custom-modal fade" id="delete_category" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div class="modal-text text-center">
                        <!-- <h3>Delete Expense Category</h3> -->
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
    <!-- /Delete Category Modal -->
    <!-- Select one record Category Modal -->
    <div class="modal custom-modal fade" id="select_one_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Please select at least one record to delete</h3>
                        <!-- <p>Are you sure want to delete?</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- set order Modal -->
    <div class="modal custom-modal fade" id="status_modell" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Are you sure you want to change the status </h3>
                        <input type="hidden" name="is_active_id" id="is_active_id" value="">
                        <input type="hidden" name="is_active_val" id="is_active_val" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" onclick="fun_review_status();">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /set orderModal -->
    <script>
        function delete_category() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_category').modal('show');
            }
        }

        function form_sub() {
            $('#form').submit();
        }
    </script>
    <script>
        function fun_status(id, value) {
            // alert(value);
            $('#is_active_id').val(id);
            $('#is_active_val').val(value);
            $('#status_modell').modal('show');
        }

        function fun_review_status() {
            var id = $('#is_active_id').val();
            var value = $('#is_active_val').val();
            $.ajax({
                type: "post",
                url: "{{ url('change_status_vendors') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "value": value,
                },
                success: function(returndata) {
                    if (returndata == 1)
                        $('#success_message').text('Status has been Updated successfully');
                    $('.success_show').show().delay(0).fadeIn('show');
                    $('.success_show').show().delay(5000).fadeOut('show');
                    $('#status_modell').modal('hide');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for searchable dropdowns
            if ($('.select2').length > 0) {
                $('.select2').select2({
                    width: '100%',
                    placeholder: 'Search & Select...'
                });
            }
            // Check if the DataTable instance already exists
            if ($.fn.DataTable.isDataTable('#example')) {
                // Destroy the existing DataTable before reinitializing
                $('#example').DataTable().destroy();
            }
            // Initialize DataTable with the new options
            $('#example').dataTable({
                "searching": true,
                "paging": true,
                "lengthChange": true,
                "info": true,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Quick Search...",
                    "paginate": {
                        "next": '<i class="fas fa-chevron-right"></i>',
                        "previous": '<i class="fas fa-chevron-left"></i>'
                    }
                },
                "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip><"clear">'
            });

            // Fix dropdown clipping in responsive tables
            $('.table-responsive').on('show.bs.dropdown', function() {
                $(this).css("overflow", "visible");
            }).on('hide.bs.dropdown', function() {
                $(this).css("overflow", "auto");
            });
        });

        function showServicesModal(vendorId) {
            var content = $('#services-content-' + vendorId).html();
            $('#modal_services_body').html(content);
            $('#servicesModal').modal('show');
        }

        function showCitiesModal(vendorId) {
            var content = $('#cities-content-' + vendorId).html();
            $('#modal_cities_body').html(content);
            $('#citiesModal').modal('show');
        }

        $(document).ready(function() {
            $('#filter_service_id').on('change', function() {
                var service_id = $(this).val();
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
            });

            $('#downloadExcelBtn').on('click', function() {
                var btn = $(this);
                var originalHtml = btn.html();
                btn.html('<i class="fas fa-spinner fa-spin"></i> Downloading...');

                // Revert button after 3.5 seconds since page doesn't reload on file download
                setTimeout(function() {
                    btn.html(originalHtml);
                }, 3500);
            });
        });
    </script>

    <!-- Services Modal -->
    <div class="modal fade" id="servicesModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-0 bg-info bg-opacity-10 px-4 py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-list text-white"></i>
                        </div>
                        <h5 class="modal-title mb-0 fw-bold text-dark fs-5">Vendor Services</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-light">
                    <div id="modal_services_body"></div>
                </div>
                <div class="modal-footer border-0 bg-light px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-outline-secondary w-100 fw-bold shadow-sm"
                        data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px;">Close window</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cities Modal -->
    <div class="modal fade" id="citiesModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-0 bg-secondary bg-opacity-10 px-4 py-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <h5 class="modal-title mb-0 fw-bold text-dark fs-5">Vendor Cities</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-light">
                    <div id="modal_cities_body"></div>
                </div>
                <div class="modal-footer border-0 bg-light px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-outline-secondary w-100 fw-bold shadow-sm"
                        data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px;">Close window</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .premium-hover {
            transition: all 0.2s ease;
        }

        .premium-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@stop

@extends('admin.includes.Template')
@section('content')
    <style>
        /* General Enhancements */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
            border-radius: 8px;
        }

        .card-header {
            background-color: #03659e !important;
            padding: 15px 20px !important;
            border-radius: 8px 8px 0 0 !important;
            border: none !important;
        }

        .card-title {
            color: #ffffff !important;
            margin-bottom: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        /* Profile Header Styling */
        .profile-banner {
            background: linear-gradient(135deg, #03659e 0%, #024b75 100%);
            height: 100px;
            border-radius: 8px 8px 0 0;
        }

        .profile-avatar-wrapper {
            margin-top: -50px;
            margin-bottom: 15px;
        }

        .profile-avatar-circle {
            width: 110px;
            height: 110px;
            background: #fff;
            border-radius: 50%;
            padding: 5px;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            overflow: hidden;
        }

        /* Table & Component Styling */
        .table thead th {
            background-color: #f8f9fa;
            color: #03659e !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-top: none;
        }

        .expiry-badge {
            background-color: #fff3cd;
            color: #856404;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .btn-download-custom {
            background: #f59f49 !important;
            color: white !important;
            border: none !important;
            box-shadow: 0 2px 4px rgba(245, 159, 73, 0.3);
        }

        .btn-download-custom:hover {
            background: #e08e3d !important;
            transform: translateY(-1px);
        }

        /* Address styling */
        .address-text {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
        }
    </style>
    <style>
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .profile-banner {
            height: 120px;
            background: linear-gradient(to right, #004e92, #000428);
            /* Adjust to match your blue */
        }

        .profile-avatar-wrapper {
            margin-top: -60px;
            /* Pulls the avatar up over the banner */
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
        }

        .profile-avatar-circle {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: #fff;
            padding: 5px;
            /* Creates the white border effect */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }

        .profile-avatar-circle:hover {
            transform: scale(1.03);
        }

        .profile-avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .text-muted {
            color: #6c757d !important;
            font-size: 0.95rem;
        }

        .separator {
            color: #dee2e6;
        }
    </style>

    <div class="content container-fluid">
        @if ($message = Session::get('login_success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fa fa-check-circle me-2"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-lg-center">
            <div class="col-lg-11">

                <div class="page-header mb-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Profile Dashboard</h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="profile-banner"></div>
                    <div class="card-body text-center pt-0">
                        <div class="profile-avatar-wrapper">
                            <label class="profile-avatar-circle" for="avatar_upload">
                                <img src="{{ asset('public/admin/assets/img/VC-Logo.jpeg') }}"
                                    style="width: 100%; height: 100%; object-fit: contain;" alt="Logo">
                                {{-- <input type="file" id="avatar_upload" hidden> --}}
                            </label>
                        </div>
                        @php $user = Auth::user(); @endphp
                        <h2 class="fw-bold">{{ $user->name }}</h2>
                        <div class="d-flex justify-content-center gap-3 text-muted">
                            @if (!empty($user->mobile))
                                <span><i class="fa fa-phone me-1"></i> {{ $user->mobile }}</span>
                                <span class="text-light">|</span>
                            @endif
                            @if (!empty($user->email))
                                <span><i class="fas fa-envelope me-1"></i> {{ $user->email }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-5">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fa fa-building me-2"></i> Company Information</h5>
                            </div>
                            <div class="card-body ">
                                <ul class="list-unstyled mt-1">
                                    @if (isset($comapny_profile->name))
                                        <li>{{ $comapny_profile->name }}
                                        </li><br>
                                    @endif
                                    @if (isset($comapny_profile->website))
                                        <li>
                                            Website: <a href="{{ $comapny_profile->website }}"
                                                target="_blank">{{ $comapny_profile->website }}</a>
                                        </li></br>
                                    @endif
                                    @if (isset($comapny_profile->mobile))
                                        <li>
                                            Tel: {{ $comapny_profile->mobile }}
                                        </li></br>
                                    @endif
                                    @if (isset($comapny_profile->address))
                                        <li>
                                            Address: {!! html_entity_decode($comapny_profile->address) !!}
                                        </li></br>
                                    @endif
                                    @if (isset($comapny_profile->gmap))
                                        <li>
                                            G-Map: <a href="{{ $comapny_profile->gmap }}"
                                                target="_blank">{{ $comapny_profile->gmap }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fa fa-file-pdf me-2"></i> Company Documents</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th class="ps-4">Document Title</th>
                                                <th class="text-end pe-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($company_document) && !empty($company_document) && $company_document->count() > 0)
                                                @foreach ($company_document as $doc)
                                                    <tr>
                                                        <td class="ps-4 fw-medium">{{ $doc->title }}</td>
                                                        <td class="text-end pe-4">
                                                            @if (!empty($doc->document))
                                                                <a href="{{ route('profile.document_download', $doc->id) }}"
                                                                    class="btn btn-sm btn-light text-success border">
                                                                    <i class="fa fa-download me-1"></i> Download
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted">
                                                        {{ 'No Company Document Found !' }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Company Drivers with Document:</h5>
                                <a href="javascript:void(0);"
                                    class="btn btn-download-custom btn-sm {{ $companydrivers->count() > 0 ? '' : 'disabled' }}"
                                    @if ($companydrivers->count() > 0) onclick="driver_document_download();" @endif>
                                    <i class="fa fa-download me-1"></i> Download
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <form id="driver_form" action="{{ route('profile.driver_document_download') }}"
                                    enctype="multipart/form-data" method="post">
                                    @csrf
                                    <div class="table-responsive" style="max-height: 400px;">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="ps-4" width="60">Select</th>
                                                    <th>Driver Name</th>
                                                    <th>Expiry Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($companydrivers) && !empty($companydrivers) && $companydrivers->count() > 0)
                                                    @foreach ($companydrivers as $driver)
                                                        <tr class="clickable-row" style="cursor: pointer;">
                                                            <td class="ps-4">
                                                                <input name="selected[]" value="{{ $driver->id }}"
                                                                    type="checkbox" class="form-check-input row-checkbox">
                                                            </td>
                                                            <td class="fw-medium">{{ $driver->name }}</td>
                                                            <td><span
                                                                    class="expiry-badge">{{ $driver->expiry_date_eid }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">
                                                            {{ 'No Company Drivers Document Found !' }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Company Crews with Document:</h5>
                                <a href="javascript:void(0);"
                                    class="btn btn-download-custom btn-sm {{ $companypackers->count() > 0 ? '' : 'disabled' }}"
                                    @if ($companypackers->count() > 0) onclick="packers_document_download();" @endif>
                                    <i class="fa fa-download me-1"></i> Download
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <form id="packers_form" action="{{ route('profile.packer_document_download') }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive" style="max-height: 400px;">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="ps-4" width="60">Select</th>
                                                    <th>Packer Name</th>
                                                    <th>Expiry Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($companypackers) && !empty($companypackers) && $companypackers->count() > 0)
                                                    @foreach ($companypackers as $packer)
                                                        <tr class="clickable-row" style="cursor: pointer;">
                                                            <td class="ps-4">
                                                                <input name="selected[]" value="{{ $packer->id }}"
                                                                    type="checkbox" class="form-check-input row-checkbox">
                                                            </td>
                                                            <td class="fw-medium">{{ $packer->name }}</td>
                                                            <td><span
                                                                    class="expiry-badge">{{ $packer->expiry_date_eid }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">
                                                            {{ 'No Company Packers Document Found !' }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Office Staff with Document:</h5>
                                <a href="javascript:void(0);"
                                    class="btn btn-download-custom btn-sm {{ $companyofficestaffs->count() > 0 ? '' : 'disabled' }}"
                                    @if ($companyofficestaffs->count() > 0) onclick="office_staff_document_download();" @endif>
                                    <i class="fa fa-download me-1"></i> Download
                                </a>
                            </div>
                            <div class="card-body p-0">
                                <form id="office_staff_form"
                                    action="{{ route('profile.office_staff_document_download') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="ps-4" width="100">Select</th>
                                                    <th>Office Staff Name</th>
                                                    <th>Expiry Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($companyofficestaffs) && !empty($companyofficestaffs) && $companyofficestaffs->count() > 0)
                                                    @foreach ($companyofficestaffs as $companyofficestaff)
                                                        <tr class="clickable-row" style="cursor: pointer;">
                                                            <td class="ps-4">
                                                                <input name="selected[]"
                                                                    value="{{ $companyofficestaff->id }}" type="checkbox"
                                                                    class="form-check-input row-checkbox">
                                                            </td>
                                                            <td class="fw-bold">{{ $companyofficestaff->name }}</td>
                                                            <td><span
                                                                    class="expiry-badge">{{ $companyofficestaff->expiry_date_eid }}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">
                                                            {{ 'No Office Staff Document Found !' }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section('footer_js')
    <div class="modal custom-modal fade" id="select_one_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3 text-warning">
                        <i class="fa fa-exclamation-triangle fa-3x"></i>
                    </div>
                    <h3 class="fw-bold">Selection Required</h3>
                    <p class="text-muted">Please select at least one record to proceed with the download.</p>
                    <button type="button" class="btn btn-primary px-4 mt-2" data-bs-dismiss="modal">Got it</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function driver_document_download() {
            if ($("#driver_form input:checked").length === 0) {
                $('#select_one_record').modal('show');
            } else {
                $('#driver_form').submit();
            }
        }

        function packers_document_download() {
            if ($("#packers_form input:checked").length === 0) {
                $('#select_one_record').modal('show');
            } else {
                $('#packers_form').submit();
            }
        }

        function office_staff_document_download() {
            if ($("#office_staff_form input:checked").length === 0) {
                $('#select_one_record').modal('show');
            } else {
                $('#office_staff_form').submit();
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Row click functionality
            $('.clickable-row').on('click', function(e) {
                // Find the checkbox in the clicked row
                var checkbox = $(this).find('.row-checkbox');

                // If the user clicked directly on the checkbox, let the browser handle it
                // Otherwise, toggle the checkbox manually
                if (!$(e.target).is(':checkbox')) {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }

                // Optional: Add a background color to the selected row
                if (checkbox.is(':checked')) {
                    $(this).addClass('table-active');
                } else {
                    $(this).removeClass('table-active');
                }
            });
        });
    </script>
@stop

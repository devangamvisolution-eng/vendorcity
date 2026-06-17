@extends('admin.includes.Template')
@section('content')
    <style>
        :root {
            --primary-blue: #3b82f6;
            --primary-hover: #2563eb;
            --accent-yellow: #facc15;
            --border-color: #e5e7eb;
            --text-main: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
        }

        .content-wrapper {
            padding: 2rem;
            background: var(--bg-light);
            min-height: 100vh;
            font-family: 'CircularStd', sans-serif;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .custom-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-blue) !important;
            color: #ffffff !important;
            padding: 18px 24px !important;
            border: none !important;
        }

        .card-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .card-body {
            padding: 30px !important;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-light);
            margin-bottom: 8px;
            display: block;
            letter-spacing: 0.025em;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.2s;
            width: 100%;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eff6ff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-box {
            background: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 25px;
            border: 1px dashed #cbd5e1;
        }

        .btn-submit {
            background: var(--primary-blue);
            border: none;
            padding: 12px 30px;
            font-weight: 700;
            border-radius: 8px;
            color: #fff;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }

        .btn-cancel {
            background: #f3f4f6;
            color: var(--text-main);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            margin-right: 10px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .required-star {
            color: #ef4444;
            margin-left: 2px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 12px 0 0 0;
            display: flex;
            align-items: center;
            gap: 0;
        }

        .breadcrumb-item {
            font-size: 13px;
            font-weight: 500;
            color: #94a3b8;
            display: flex;
            align-items: center;
        }

        .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
            padding: 2px 4px;
            border-radius: 4px;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-blue);
            background: #f1f5f9;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--primary-blue);
            font-weight: 700;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            color: #cbd5e1;
            padding: 0 12px;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 1rem;
            }

            .card-body {
                padding: 20px !important;
            }
        }
    </style>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h3 class="page-title">Assign Warehouse</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('erp_acceptedquote.lists') }}">Accepted
                                    Quotations</a></li>
                            <li class="breadcrumb-item active">Assign Warehouse</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="custom-card">
                    <div class="card-header">
                        <h4><i class="fas fa-warehouse me-2"></i> Warehouse Assignment Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="info-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="form-label">Quotation ID</span>
                                    <div class="fw-bold text-primary">#{{ $enquiry->quote_id }}</div>
                                </div>
                                <div class="col-md-6">
                                    <span class="form-label">Client Name</span>
                                    <div class="fw-bold">{{ $enquiry->client_name }}</div>
                                </div>

                            </div>
                        </div>

                        <form id="assignment_form" action="{{ route('erp_acceptedquote.assignwarehousestore') }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="enquiry_id" value="{{ $id }}">
                            @if (isset($enquiry->surveyor))
                                <div class="section-title">
                                    <i class="fas fa-users"></i> Vendor Information
                                </div>
                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Vendor Name </label>
                                        <input type="text" name="vd_name" id="vd_name" class="form-control"
                                            value="{!! Helper::vendorsname($enquiry->surveyor) !!}" readonly />
                                    </div>
                                </div>
                            @endif

                            <div class="section-title">
                                <i class="fas fa-file-contract"></i> Agreement & Warehouse Information
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Agreement Date <span class="required-star">*</span></label>
                                    <input type="date" name="agreement_date" id="agreement_date" class="form-control"
                                        value="{{ $assignment->agreement_date ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Warehouse Address <span class="required-star">*</span></label>
                                    <input type="text" name="warehouse_name" id="warehouse_name" class="form-control"
                                        placeholder="Enter Warehouse Name"
                                        value="{{ $assignment->warehouse_name ?? '' }}" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Unit No <span class="required-star">*</span></label>
                                    <input type="text" name="unit_no" id="unit_no" class="form-control"
                                        placeholder="Enter Unit Number" value="{{ $assignment->unit_no ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Emirate ID</label>
                                    <input type="text" name="emirate_id" id="emirate_id" class="form-control"
                                        placeholder="Enter Emirate ID Reference"
                                        value="{{ $assignment->emirate_id ?? '' }}" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label">Company Trade Licence</label>
                                    <input type="text" name="trade_license" id="trade_license" class="form-control"
                                        placeholder="Enter Trade Licence Number"
                                        value="{{ $assignment->trade_license ?? '' }}" />
                                </div>
                            </div>

                            <div class="section-title mt-2">
                                <i class="fas fa-calendar-alt"></i> Duration Details
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">From Date <span class="required-star">*</span></label>
                                    <input type="date" name="from_date" id="from_date" class="form-control"
                                        value="{{ $assignment->from_date ?? '' }}" />
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">To Date <span class="required-star">*</span></label>
                                    <input type="date" name="to_date" id="to_date" class="form-control"
                                        value="{{ $assignment->to_date ?? '' }}" />
                                </div>
                            </div>

                            <div class="text-end mt-4 border-top pt-4">
                                <a href="{{ route('erp_acceptedquote.lists') }}" class="btn-cancel">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                <button type="button" class="btn-submit" id="submit_button"
                                    onclick="validate_assignment()">
                                    <i class="fas fa-check-circle me-1"></i> Save Assignment
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
    <script>
        function validate_assignment() {
            var agreement_date = $('#agreement_date').val();
            var warehouse_name = $('#warehouse_name').val();
            var unit_no = $('#unit_no').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();

            if (agreement_date == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Date',
                    text: 'Please select Agreement Date',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (warehouse_name == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Name',
                    text: 'Please enter Warehouse Name',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (unit_no == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Unit',
                    text: 'Please enter Unit Number',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (from_date == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Date',
                    text: 'Please select From Date',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            if (to_date == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Date',
                    text: 'Please select To Date',
                    confirmButtonColor: '#3b82f6'
                });
                return false;
            }

            // Update button state
            var btn = $('#submit_button');
            btn.prop('disabled', true);
            btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

            // Submit form
            $('#assignment_form').submit();
        }

        @if ($message = Session::get('success'))
            Swal.fire({
                title: 'Success!',
                text: "{{ $message }}",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                background: '#ffffff',
                iconColor: '#10b981',
                customClass: {
                    title: 'text-success font-weight-bold'
                }
            });
        @endif

        @if ($message = Session::get('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ $message }}",
                confirmButtonColor: '#ef4444'
            });
        @endif
    </script>
@stop

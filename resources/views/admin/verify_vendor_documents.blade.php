@extends('admin.includes.Template')

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Verify Documents: {{ $vendor->name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
                        <li class="breadcrumb-item active">Verify Documents</li>
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

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Error!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-white mb-0">Vendor Documents Review</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><strong>Vendor ID:</strong> {{ $vendor->vendor_id }}</h5>
                                <h5><strong>Company Name:</strong> {{ $vendor->name }}</h5>
                                <h5><strong>Email:</strong> {{ $vendor->email }}</h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <h5><strong>Current Status:</strong> 
                                    @if($vendor->is_active == 0 && $vendor->document_status == 'verified')
                                        <span class="badge bg-success">Verified</span>
                                    @elseif($vendor->is_active == 1 && $vendor->suspension_reason == 'document_expired')
                                        <span class="badge bg-danger">Suspended (Docs Expired)</span>
                                    @else
                                        <span class="badge bg-warning">{{ ucfirst($vendor->document_status) }}</span>
                                    @endif
                                </h5>
                                <h5><strong>Last Expiration Date:</strong> {{ $vendor->document_expiration_date ? date('Y-m-d', strtotime($vendor->document_expiration_date)) : 'N/A' }}</h5>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Document Type</th>
                                        <th>Document File</th>
                                        <th>Expiry Date</th>
                                        <th>Document Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Company Logo</strong></td>
                                        <td>
                                            @if($vendor->company_logo)
                                                <a href="{{ asset('public/upload/vendors/' . $vendor->company_logo) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> View Logo</a>
                                            @else
                                                <span class="text-muted">Not Uploaded</span>
                                            @endif
                                        </td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Trade License</strong></td>
                                        <td>
                                            @if($vendor->tradelicense)
                                                <a href="{{ asset('public/upload/vendors/' . $vendor->tradelicense) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-file-pdf"></i> View Document</a>
                                            @else
                                                <span class="text-muted">Not Uploaded</span>
                                            @endif
                                        </td>
                                        <td>{{ $vendor->tlexpiry ? date('Y-m-d', strtotime($vendor->tlexpiry)) : 'N/A' }}</td>
                                        <td>{{ $vendor->trade_license_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>VAT Certificate</strong></td>
                                        <td>
                                            @if($vendor->vatcertificate)
                                                <a href="{{ asset('public/upload/vendors/' . $vendor->vatcertificate) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-file-pdf"></i> View Document</a>
                                            @else
                                                <span class="text-muted">Not Uploaded</span>
                                            @endif
                                        </td>
                                        <td>{{ $vendor->vat_certificate_expiry ? date('Y-m-d', strtotime($vendor->vat_certificate_expiry)) : 'N/A' }}</td>
                                        <td>N/A</td>
                                    </tr>
                                    <tr>
                                        <td><strong>TRN Certificate</strong></td>
                                        <td>
                                            @if($vendor->trncertificate)
                                                <a href="{{ asset('public/upload/vendors/' . $vendor->trncertificate) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-file-pdf"></i> View Document</a>
                                            @else
                                                <span class="text-muted">Not Uploaded</span>
                                            @endif
                                        </td>
                                        <td>{{ $vendor->trn_certificate_expiry ? date('Y-m-d', strtotime($vendor->trn_certificate_expiry)) : 'N/A' }}</td>
                                        <td>{{ $vendor->trn_certificate_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Passport</strong></td>
                                        <td>
                                            @if($vendor->passport)
                                                <a href="{{ asset('public/upload/vendors/' . $vendor->passport) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-file-pdf"></i> View Document</a>
                                            @else
                                                <span class="text-muted">Not Uploaded</span>
                                            @endif
                                        </td>
                                        <td>{{ $vendor->passport_expiry ? date('Y-m-d', strtotime($vendor->passport_expiry)) : 'N/A' }}</td>
                                        <td>{{ $vendor->passport_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Emirates ID</strong></td>
                                        <td>
                                            @if($vendor->emirates_id)
                                                <a href="{{ asset('public/upload/vendors/' . $vendor->emirates_id) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-file-pdf"></i> View Document</a>
                                            @else
                                                <span class="text-muted">Not Uploaded</span>
                                            @endif
                                        </td>
                                        <td>{{ $vendor->emirates_id_expiry ? date('Y-m-d', strtotime($vendor->emirates_id_expiry)) : 'N/A' }}</td>
                                        <td>{{ $vendor->emirates_id_number ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 border-top pt-4 text-center">
                            <form id="verifyDocumentsForm" action="{{ route('admin.vendors.verify-documents', $vendor->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="button" id="btnVerifyConfirm" class="btn btn-success btn-lg px-5 shadow-sm">
                                    <i class="fas fa-check-circle me-2" id="verifyBtnIcon"></i> <span id="verifyBtnText">Confirm & Verify Documents</span>
                                </button>
                            </form>
                            
                            <a href="{{ route('vendors.index') }}" class="btn btn-secondary btn-lg ms-3 px-4 shadow-sm" id="btnCancel">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btnVerifyConfirm').addEventListener('click', function(e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will verify the documents and approve the vendor account.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, verify them!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loader state
                let btn = document.getElementById('btnVerifyConfirm');
                let icon = document.getElementById('verifyBtnIcon');
                let text = document.getElementById('verifyBtnText');
                
                btn.disabled = true;
                icon.className = 'fas fa-spinner fa-spin me-2';
                text.innerText = 'Verifying...';
                
                document.getElementById('btnCancel').classList.add('disabled');

                // Submit the form
                document.getElementById('verifyDocumentsForm').submit();
            }
        });
    });
</script>
@endsection

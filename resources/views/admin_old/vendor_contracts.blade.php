@extends('admin.includes.Template')

@section('content')
    <div class="content container-fluid">
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Manage Contracts: {{ $vendor->name }}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
                        <li class="breadcrumb-item active">Contracts</li>
                    </ul>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Contract History Table -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">Contract History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Unsigned PDF</th>
                                        <th>Signed PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contracts as $contract)
                                        <tr>
                                            <td>{{ $contract->start_date ? date('d M Y', strtotime($contract->start_date)) : '-' }}
                                            </td>
                                            <td>{{ $contract->end_date ? date('d M Y', strtotime($contract->end_date)) : '-' }}
                                            </td>
                                            <td>
                                                @if ($contract->status == 'sent')
                                                    <span class="badge bg-warning">Sent (Pending Signature)</span>
                                                @elseif($contract->status == 'uploaded')
                                                    <span class="badge bg-info">Uploaded (Pending Approval)</span>
                                                @elseif($contract->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($contract->status == 'expired')
                                                    <span class="badge bg-danger">Expired</span>
                                                @elseif($contract->status == 'rejected')
                                                    <span class="badge bg-dark">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contract->unsigned_pdf_path)
                                                    <a href="{{ route('contract.download', $contract->unsigned_pdf_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-secondary"><i
                                                            class="fas fa-file-pdf"></i> View</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($contract->signed_pdf_path)
                                                    <a href="{{ route('contract.download', $contract->signed_pdf_path) }}"
                                                        target="_blank" class="btn btn-sm btn-outline-primary"><i
                                                            class="fas fa-file-pdf"></i> View</a>
                                                    @if ($contract->status == 'uploaded' || $contract->status == 'rejected')
                                                        <a href="{{ route('admin.contracts.approve', $contract->id) }}"
                                                            class="btn btn-sm btn-success ms-2 swal-confirm"
                                                            data-title="Approve Contract?"><i class="fas fa-thumbs-up"></i>
                                                            Approve</a>
                                                    @endif
                                                    @if ($contract->status == 'uploaded' || $contract->status == 'approved')
                                                        <a href="{{ route('admin.contracts.reject', $contract->id) }}"
                                                            class="btn btn-sm btn-danger ms-1 swal-confirm"
                                                            data-title="Reject Contract?"><i
                                                                class="fas fa-times-circle"></i> Reject</a>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No contracts found for this
                                                vendor.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contract Actions -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">Upload Custom Contract</h5>
                    </div>
                    <div class="card-body">
                        @if (empty($vendor->document_verified_by))
                            <div class="alert alert-info small">
                                <i class="fas fa-info-circle"></i> Please verify the vendor's documents above before you can
                                upload a custom contract.
                            </div>
                        @else
                            <p class="text-muted small">Upload an unsigned custom PDF contract. The system will
                                automatically email it to the vendor for them to sign and re-upload.</p>
                            <form id="upload-contract-form"
                                action="{{ route('admin.vendors.contracts.upload', $vendor->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Unsigned Contract (PDF)</label>
                                    <input type="file" name="unsigned_contract" class="form-control" accept=".pdf"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Contract End Date</label>
                                    <input type="date" name="end_date" class="form-control" required
                                        value="{{ date('Y-m-d', strtotime('+1 year')) }}">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Upload & Send to Vendor</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">Document Verification</h5>
                    </div>
                    <div class="card-body">
                        @if (empty($vendor->document_verified_by))
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-exclamation-triangle"></i> Documents Pending Verification
                            </div>
                            <p class="text-muted small">Please verify the vendor's uploaded documents before sending the
                                contract.</p>
                            <a href="{{ route('admin.vendors.verify-documents', $vendor->id) }}"
                                class="btn btn-success w-100 swal-confirm" data-title="Verify Documents?">Verify Documents
                                Now</a>
                        @else
                            @php
                                $verifier = \App\Models\User::find($vendor->document_verified_by);
                            @endphp
                            <div class="alert alert-success mb-0">
                                <i class="fas fa-check-circle"></i> Documents Verified By
                                <b>{{ $verifier ? $verifier->name : 'Admin' }}</b>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">Automated Contract</h5>
                    </div>
                    <div class="card-body">
                        @if (empty($vendor->document_verified_by))
                            <div class="alert alert-info small">
                                <i class="fas fa-info-circle"></i> Please verify the vendor's documents above before you can
                                generate a contract.
                            </div>
                        @else
                            <p class="text-muted small">Or, click below to have the system automatically generate a generic
                                contract and send it to the vendor.</p>
                            <a href="{{ route('admin.vendors.verify-contract', $vendor->id) }}"
                                class="btn btn-outline-info w-100 swal-confirm" data-title="Generate Contract?">Generate &
                                Send Automated Contract</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SWAL for links
            const confirmLinks = document.querySelectorAll('.swal-confirm');
            confirmLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    const title = this.getAttribute('data-title') || 'Are you sure?';

                    Swal.fire({
                        title: title,
                        text: "You are about to change the status of this contract.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, proceed!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Processing...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                            window.location.href = url;
                        }
                    })
                });
            });

            // SWAL for form uploads
            const uploadForm = document.getElementById('upload-contract-form');
            if (uploadForm) {
                uploadForm.addEventListener('submit', function(e) {
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while the contract is being uploaded and sent.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                });
            }
        });
    </script>
@endsection

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
            --success-color: #10b981;
        }

        .content-wrapper { padding: 2rem; background: var(--bg-light); min-height: 100vh; font-family: 'CircularStd', sans-serif; }
        
        .page-header { margin-bottom: 2rem; }
        .page-title { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: var(--text-main); 
            margin-bottom: 0.5rem; 
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
            overflow: visible !important;
        }

        .existing-doc-row {
            background: #f8fafc;
            border-left: 4px solid var(--primary-blue);
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .doc-info { display: flex; align-items: center; }
        .doc-icon { 
            width: 36px; 
            height: 36px; 
            background: #dbeafe; 
            color: var(--primary-blue); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 8px;
            margin-right: 15px;
        }

        .doc-name { font-weight: 600; color: var(--text-main); font-size: 14px; }

        .existing-doc-actions {
            display: flex;
            gap: 10px;
        }

        .btn-delete-old {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #ffe4e6;
            color: #e11d48;
            border: none;
            transition: all 0.2s;
        }

        .btn-delete-old:hover {
            background: #fecdd3;
            color: #be123c;
            transform: scale(1.05);
        }

        .document-row {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.2s;
            position: relative;
        }

        .document-row:hover {
            border-color: var(--primary-blue);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-light);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            transition: all 0.2s;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-action-circle {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: none;
            transition: all 0.2s;
            font-size: 14px;
        }

        .btn-add-row {
            background: #dcfce7;
            color: #16a34a;
        }

        .btn-add-row:hover {
            background: #bbf7d0;
            color: #15803d;
            transform: scale(1.1);
        }

        .btn-remove-row {
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-remove-row:hover {
            background: #fecaca;
            color: #dc2626;
            transform: scale(1.1);
        }

        .btn-submit {
            background: var(--primary-blue);
            border: none;
            padding: 12px 30px;
            font-weight: 700;
            border-radius: 8px;
            color: #fff;
            transition: all 0.2s;
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
        }
    </style>
    <div class="content container-fluid">

        
        @if ($message = Session::get('success'))
            {{-- Handled by Swal below --}}
        @endif

        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <div class="page-header">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h3 class="page-title">Add Documents</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('erp_acceptedquote.lists') }}">Accepted Quotations</a></li>
                            <li class="breadcrumb-item active">Add Documents</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="custom-card">
                    <div class="card-header">
                        <h4><i class="fas fa-file-upload me-2"></i> Document Upload Center</h4>
                    </div>
                    <div class="card-body">
                        <form id="erp_enquiry_form" action="{{ route('erp_acceptedquote.addDocumentsstore') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="enquiry_id" value="{{ $id }}">

                            @if(isset($existing_docs) && count($existing_docs) > 0)
                                <div class="mb-5">
                                    <h5 class="form-label mb-3"><i class="fas fa-folder-open me-2"></i> Currently Uploaded Documents</h5>
                                    @foreach($existing_docs as $doc)
                                        <div class="existing-doc-row">
                                            <div class="doc-info">
                                                <div class="doc-icon"><i class="fas fa-file-alt"></i></div>
                                                <div>
                                                    <div class="doc-name">{{ $doc->title }}</div>
                                                    <small class="text-muted">Uploaded on {{ date('d M, Y', strtotime($doc->created_at)) }}</small>
                                                </div>
                                            </div>
                                            <div class="existing-doc-actions">
                                                <a href="{{ asset('public/upload/erpacceptdocument/'.$doc->document) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                    <i class="fas fa-eye me-1"></i> View
                                                </a>
                                                <button type="button" class="btn-delete-old" onclick="delete_document({{ $doc->id }}, this)" title="Delete Document">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="my-5">
                            @endif

                            <h5 class="form-label mb-3"><i class="fas fa-plus-circle me-2"></i> Upload New Documents</h5>
                            <div id="document_wrapper">
                                <div class="document_row">
                                    <div class="row align-items-end">
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <label class="form-label">Document Title</label>
                                            <input name="title[]" type="text" class="form-control" placeholder="e.g. ID Proof, Invoice..." required />
                                        </div>
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <label class="form-label">Select File</label>
                                            <input name="documents[]" type="file" class="form-control" required />
                                        </div>
                                        <div class="col-md-2 text-center text-md-start">
                                            <button type="button" class="btn-action-circle btn-add-row add_row" title="Add More">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-5 border-top pt-4">
                                <a class="btn-cancel" href="{{ route('erp_acceptedquote.lists') }}">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </a>
                                
                                <button class="btn-submit" type="button" disabled id="spinner_button" style="display: none;">
                                    <span class="spinner-border spinner-border-sm me-1"></span> Processing...
                                </button>
                                
                                <button type="button" class="btn-submit" onclick="category_validation()" id="submit_button">
                                    <i class="fas fa-check-circle me-1"></i> Save Documents
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
$(document).ready(function(){

    // ADD ROW
    $(document).on('click', '.add_row', function(){
        // Transform current PLUS to MINUS
        $(this).removeClass('btn-add-row add_row').addClass('btn-remove-row remove_row');
        $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
        $(this).attr('title', 'Remove');

        let html = `
        <div class="document_row">
            <div class="row align-items-end">
                <div class="col-md-5 mb-3 mb-md-0">
                    <label class="form-label d-md-none">Document Title</label>
                    <input name="title[]" type="text" class="form-control" placeholder="Document Title..." />
                </div>
                <div class="col-md-5 mb-3 mb-md-0">
                    <label class="form-label d-md-none">Select File</label>
                    <input name="documents[]" type="file" class="form-control" />
                </div>
                <div class="col-md-2 text-center text-md-start">
                    <button type="button" class="btn-action-circle btn-add-row add_row" title="Add More">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>`;

        $('#document_wrapper').append(html);
    });

    // REMOVE ROW
    $(document).on('click', '.remove_row', function(){
        $(this).closest('.document_row').remove();
    });

});

function delete_document(id, element) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This document will be permanently deleted from the server.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show Loading State
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we remove the document.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: "{{ route('erp_acceptedquote.deleteDocument') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        $(element).closest('.existing-doc-row').fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        Swal.fire('Error', response.message || 'Something went wrong', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Connection error. Please try again.', 'error');
                }
            });
        }
    });
}
</script>
<script>
function category_validation(){
    $('#submit_button').hide();
    $('#spinner_button').show();
    $('#erp_enquiry_form').submit();
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
        title: 'Error!',
        text: "{{ $message }}",
        icon: 'error',
        confirmButtonColor: '#ef4444'
    });
@endif
</script>
@stop

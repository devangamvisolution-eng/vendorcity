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

    .attachment-badge {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        font-size: 13px;
        color: #475569;
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
                <h3 class="page-title">Agreement & Mailing</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('erp_acceptedquote.lists') }}">Accepted
                                Quotations</a></li>
                        <li class="breadcrumb-item active">Agreement</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="custom-card">
                <div class="card-header">
                    <h4><i class="fas fa-file-signature me-2"></i> Agreement Details</h4>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="form-label">Quotation ID</span>
                                <div class="fw-bold text-primary">#{{ $erpEnquiryData->quote_id }}</div>
                            </div>
                            <div class="col-md-6">
                                <span class="form-label">Client Name</span>
                                <div class="fw-bold">{{ $erpEnquiryData->client_name }}</div>
                            </div>
                        </div>
                    </div>

                    <form id="agreement_form" action="{{ route('erp_acceptedquote.send_agreement_mail') }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="enquiry_id" value="{{ $id }}">

                        <div class="section-title">
                            <i class="fas fa-envelope"></i> Recipients & Subject
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">To Mail <span class="text-lowercase fw-normal">(Comma
                                        separated for multiple)</span></label>
                                <input type="text" name="to_mail" id="to_mail" class="form-control"
                                    placeholder="e.g. client@example.com, assistant@example.com" value="">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Mail Subject</label>
                                <input type="text" name="mail_subject" id="mail_subject" class="form-control"
                                    placeholder="Enter subject line" value="{{ $mail_subject }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label mb-2">Additional CC Recipients</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($cc_email_data as $key => $email)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="cc_email[]"
                                                id="cc_email_{{ $key }}" value="{{ $email->email }}" checked>
                                            <label class="form-check-label" for="cc_email_{{ $key }}">
                                                {{ $email->email }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="section-title mt-2">
                            <i class="fas fa-eye"></i> Mail Body Preview
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-control"
                                    style="background-color: #f8fafc; height: auto; min-height: 200px; padding: 20px; border: 1px dashed #cbd5e1; border-radius: 12px; color: #475569; line-height: 1.6;">
                                    {!! $mail_html !!}
                                </div>
                                <input type="hidden" name="mail_content" value="{{ $mail_html }}">
                            </div>
                        </div>

                        @if(count($documents) > 0)
                            <div class="section-title mt-2">
                                <i class="fas fa-paperclip"></i> Auto-Attached Documents
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($documents as $doc)
                                            <div class="attachment-badge">
                                                <i class="fas fa-file-pdf text-danger me-2"></i> {{ $doc->title }}
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted"><i class="fas fa-info-circle me-1"></i> These documents will
                                        be automatically attached to the email.</small>
                                </div>
                            </div>
                        @endif

                        <div class="text-end mt-4 border-top pt-4">
                            <a href="{{ route('erp_acceptedquote.lists') }}" class="btn-cancel">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="button" class="btn-submit" id="submit_button" onclick="send_mail()">
                                <i class="fas fa-paper-plane me-1"></i> Send Agreement
                            </button>
                            <button type="button" class="btn-submit ms-2" id="download_button"
                                onclick="download_agreement()">
                                <i class="fas fa-download me-1"></i> Download Agreement
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
    function send_mail() {
        var to_mail = $('#to_mail').val();
        var subject = $('#mail_subject').val();

        // if (to_mail == '') {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Recipient Missing',
        //         text: 'Please enter at least one recipient email.',
        //         confirmButtonColor: '#3b82f6'
        //     });
        //     return false;
        // }

        if (subject == '') {
            Swal.fire({
                icon: 'error',
                title: 'Subject Missing',
                text: 'Please enter a mail subject.',
                confirmButtonColor: '#3b82f6'
            });
            return false;
        }

        // Show loading state on button
        var btn = $('#submit_button');
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Sending...');

        // Submit form
        $('#agreement_form').submit();
    }

    function download_agreement() {
        var btn = $('#download_button');
        var originalHtml = btn.html();

        // Show loading state
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Preparing PDF...');

        var mail_format = 1;
        var url = "{{ route('erp_acceptedquote.agreement_download') }}";
        var queryParams = new URLSearchParams({
            "_token": "{{ csrf_token() }}",
            "formatType": mail_format,
            "enquiry_id": @json($id)
        }).toString();

        // Redirect to the download route
        window.location.href = url + "?" + queryParams;

        // Reset button and show success after a short delay
        setTimeout(function () {
            btn.prop('disabled', false);
            btn.html(originalHtml);

            Swal.fire({
                title: 'Download Ready!',
                text: "Your agreement has been generated and the download started.",
                icon: 'success',
                timer: 3000,
                showConfirmButton: false,
                background: '#ffffff',
                iconColor: '#10b981',
                customClass: {
                    title: 'text-success font-weight-bold'
                }
            });
        }, 2000);
    }

    @if($message = Session::get('success'))
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
</script>
@stop
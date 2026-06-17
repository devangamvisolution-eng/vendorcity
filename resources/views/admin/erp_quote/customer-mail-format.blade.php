@extends('admin.includes.Template')
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('public/admin/assets/css/formnew.css') }}"> --}}
    <style>
        :root {
            --primary-blue: #0040E6;
            --hover-blue: #0030AD;
            --bg-gray: #F8F9FA;
            --border-color: #E2E8F0;
            --text-main: #1A202C;
            --text-muted: #718096;
            --success-green: #38A169;
        }

        .content {
            background-color: var(--bg-gray);
            min-height: 100vh;
        }

        .page-header {
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .page-title {
            font-weight: 700;
            color: var(--text-main);
            font-size: 24px;
            margin-bottom: 8px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-blue);
            font-weight: 500;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .card-body {
            padding: 32px;
        }

        .mail-controls-container {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
        }

        .form-label-custom {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
            display: block;
        }

        .form-control-custom {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 12px 16px;
            transition: all 0.2s;
            font-size: 15px;
        }

        .form-control-custom:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 64, 230, 0.1);
            outline: none;
        }

        .cc-emails-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            padding: 15px;
            background: var(--bg-gray);
            border-radius: 8px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-wrapper input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-blue);
        }

        .preview-document-container {
            background: #D1D5DB;
            /* Neutral dark background for contrast */
            padding: 60px 20px;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            min-height: 600px;
            position: relative;
        }

        #replace_mail_html_content {
            background: #fff;
            width: 100%;
            max-width: 850px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 2px;
            min-height: 400px;
            transform-origin: top center;
        }

        .action-bar {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-premium {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-premium-primary {
            background-color: var(--primary-blue);
            color: #fff;
        }

        .btn-premium-primary:hover:not(:disabled) {
            background-color: var(--hover-blue);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 64, 230, 0.2);
        }

        .btn-premium-outline {
            background-color: #fff;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .btn-premium-outline:hover:not(:disabled) {
            background-color: var(--bg-gray);
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .spinner-custom {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left-color: var(--primary-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .hidden {
            display: none;
        }

        .subject-hidden,
        .cc-email-hidden,
        .to-mail-hidden {
            display: none;
        }

        /* Animation for alerts */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Quotation Preview</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('erp_quote.lists') }}">Quotation</a>
                            </li>
                            <li class="breadcrumb-item active">Quotation Preview</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <!-- /Page Header -->


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="survey_form" action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="action" value="add-qoutation">
                            <input id="enquiry_hidden_id" name="enquiry_hidden_id" type="hidden" value="" />

                            <!-- Mail Controls -->
                            <div class="mail-controls-container">
                                <div class="row g-4">
                                    <div class="col-md-12 d-none">
                                        <div class="form-group">
                                            <label class="form-label-custom">Mail Formats:</label>
                                            <select name="mail_format" id="mail_format"
                                                class="form-select form-control-custom select"
                                                onchange="mailFormatChange(this.value,'{{ $enquiry_id }}');">
                                                <option value="">Select</option>
                                                <option value="1">Format 1</option>
                                            </select>
                                            <p id="mail-format-errror" style="color:red;"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mail-sub-input subject-hidden">
                                        <div class="form-group" id="replace_mail_subject">
                                            <label class="form-label-custom">Email Subject</label>
                                            <input type="text" name="mail_subject" id="mail_subject"
                                                class="form-control form-control-custom"
                                                placeholder="Professional Subject Line" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6 to-mail-input to-mail-hidden">
                                        <div class="form-group" id="to_mail_subject">
                                            <label class="form-label-custom">Recipient Email (To)</label>
                                            <input type="email" name="to_mail" id="to_mail"
                                                class="form-control form-control-custom" placeholder="customer@example.com"
                                                value="">
                                        </div>
                                    </div>

                                    <div class="col-md-12 cc-email-checkbox cc-email-hidden">
                                        <div class="form-group" id="replace_cc_mail">
                                            <label class="form-label-custom">BCC Emails (Internal tracking)</label>
                                            <div class="cc-emails-grid">
                                                @if ($cc_email_data)
                                                    @foreach ($cc_email_data as $key => $email)
                                                        <label class="checkbox-wrapper">
                                                            <input type="checkbox" name="cc_email[]"
                                                                id="cc_email_{{ $key }}"
                                                                value="{{ $email->email }}" />
                                                            <span>{{ $email->email }}</span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Preview -->
                            <div class="preview-document-container">
                                <div class="loader">
                                    <div class="spinner-custom"></div>
                                </div>
                                <div id="replace_mail_html_content">
                                    <!-- Injected Content -->
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="action-bar">
                                <a class="btn-premium btn-premium-outline" href="{{ route('erp_quote.lists') }}">
                                    <i class="fa fa-times"></i> Back to List
                                </a>

                                <button type="button" class="btn-premium btn-premium-outline"
                                    onclick="javascript:download_quotation()" id="download_button">
                                    <i class="fa fa-download"></i> Download PDF
                                </button>

                                <button class="btn-premium btn-premium-outline" type="button" disabled
                                    id="spinner_download_button" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span>Preparing PDF...</span>
                                </button>

                                <button type="button" class="btn-premium btn-premium-primary"
                                    onclick="javascript:quote_validation()" id="submit_button">
                                    <i class="fa fa-paper-plane"></i> Send to Customer
                                </button>

                                <button class="btn-premium btn-premium-primary" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    <span>Sending Mail...</span>
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
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script> --}}

    {{-- CKEditor CDN --}}

    <script>
        $(document).ready(function() {
            var formatType = 1;
            var enquiry_id = @json($enquiry_id);
            mailFormatChange(formatType, enquiry_id);
        });

        function mailFormatChange(formatType, enquiry_id) {
            if (formatType != "") {
                $('.loader').show();
                var url = '{{ route('erp_quote.mail-format-type') }}';
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "formatType": formatType,
                        "enquiry_id": enquiry_id
                    },
                    success: function(response) {
                        setTimeout(function() {
                            if (response.status == 'success') {
                                $('.loader').hide();
                                $(".mail-sub-input").removeClass("subject-hidden");
                                $(".cc-email-checkbox").removeClass("cc-email-hidden");
                                $(".to-mail-input").removeClass("to-mail-hidden");
                                $("#replace_mail_html_content").html(response.data);
                                $("#mail_subject").val(response.subject);
                            } else {
                                $('.loader').hide();
                            }
                        }, 500);
                    }
                });
            }
        }

        function quote_validation() {
            var mail_format = 1;
            let mailSubject = $("#mail_subject").val();
            let selectedEmails = [];
            $("input[name='cc_email[]']:checked").each(function() {
                selectedEmails.push($(this).val());
            });

            let toMail = $("#to_mail").val();

            if (mailSubject == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter Email Subject'
                });
                return false;
            }
            // if (toMail == "") {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Error',
            //         text: 'Please enter Recipient Email'
            //     });
            //     return false;
            // }

            Swal.fire({
                title: 'Send Quotation?',
                text: "Are you sure you want to send this quotation to the customer?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0040E6',
                cancelButtonColor: '#718096',
                confirmButtonText: 'Yes, Send Now!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                        url: "{{ route('erp_quote.send_quotation_mail') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "formatType": mail_format,
                            "enquiry_id": @json($enquiry_id),
                            "mailSubject": mailSubject,
                            "cc_emails": selectedEmails,
                            "to_mail": toMail
                        }
                    }).catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error.responseJSON.message || error.statusText}`);
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.value.status == 'SUCCESS') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sent!',
                            text: result.value.message,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.value.message
                        });
                    }
                }
            });
        }

        // function download_quotation() {
        //     var mail_format = 1;

        //     Swal.fire({
        //         title: 'Processing PDF...',
        //         text: 'Please wait while we prepare your download.',
        //         timer: 2000,
        //         timerProgressBar: true,
        //         didOpen: () => {
        //             Swal.showLoading();
        //             var url = "{{ route('erp_quote.download') }}";
        //             var queryParams = new URLSearchParams({
        //                 "_token": "{{ csrf_token() }}",
        //                 "formatType": mail_format,
        //                 "enquiry_id": @json($enquiry_id)
        //             }).toString();
        //             window.location.href = url + "?" + queryParams;
        //         }
        //     });
        // }
        function download_quotation() {

            var mail_format = 1;

            Swal.fire({
                title: 'Processing PDF...',
                text: 'Please wait while we prepare your download.',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {

                    Swal.showLoading();

                    var url = "{{ route('erp_quote.download') }}";

                    var queryParams = new URLSearchParams({
                        formatType: mail_format,
                        enquiry_id: @json($enquiry_id)
                    }).toString();

                    window.location.href = url + "?" + queryParams;
                }
            });
        }
    </script>
@stop

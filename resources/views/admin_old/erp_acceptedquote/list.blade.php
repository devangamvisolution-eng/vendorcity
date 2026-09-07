@extends('admin.includes.Template')

@section('content')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/table.css') }}">


    @php
        $userId = Auth::id();
        $get_user_data = Helper::get_user_data($userId);
        $roleIds = explode(',', $get_user_data->role_id);
        $edit_perm = [];

        foreach ($roleIds as $roleId) {
            $roleId = trim($roleId);
            $get_permission_data = Helper::get_permission_data($roleId);
            if (
                is_object($get_permission_data) &&
                property_exists($get_permission_data, 'editperm') &&
                $get_permission_data->editperm != ''
            ) {
                $perms = explode(',', $get_permission_data->editperm);
                $edit_perm = array_merge($edit_perm, $perms);
            }
        }
        $edit_perm = array_values(array_unique($edit_perm));
    @endphp

    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Accepted Quotations</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Accepted Quotation</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fa fa-check-circle me-2"></i> <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="custom-card">
            <div class="card-body">
                <form id="form" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-hover datatable" id="example">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">
                                        <input type="checkbox" class="custom-checkbox" id="checkAll">
                                    </th>
                                    <th>Quote ID</th>
                                    <th>Enquiry Date</th>
                                    <th>Client Details</th>
                                    <th>Payment Status</th>
                                    <th class="text-end" style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($erp_enquiry_data as $data)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="custom-checkbox" value="{{ $data->id }}">
                                        </td>
                                        <td>
                                            <span class="fw-bold text-primary">#{{ $data->quote_id }}<br>
                                                <strong
                                                    class="fw-bold strong">{{ Helper::servicename($data->service) }}</strong></span>
                                        </td>
                                        <td>
                                            <div class="text-muted"><i class="far fa-calendar-alt me-1"></i>
                                                {{ date('d M Y', strtotime($data->enquiry_date)) }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $data->client_name }}</div>
                                            <div class="text-muted small"><i class="fa fa-phone me-1"></i>
                                                {{ $data->client_mobile }}</div>
                                        </td>
                                        <td>
                                            @if ($data->payment_status === 'paid')
                                                <span class="badge-status badge-paid">
                                                    <i class="fa fa-check me-1"></i> Paid
                                                </span>
                                                <span class="payment-id">{{ $data->stripe_payment_intent }}</span>
                                            @else
                                                <span class="badge-status badge-unpaid">
                                                    <i class="fa fa-clock me-1"></i> Pending
                                                </span>
                                                <div class="mt-2">
                                                    <a class="btn-send-mail btn-sm"
                                                        href="{{ route('erp_acceptedquote.sendmail', $data->id) }}"
                                                        id="sendmailbutton_{{ $data->id }}"
                                                        onclick="button_spin({{ $data->id }})">
                                                        <i class="fa fa-paper-plane me-1"></i> Send Mail
                                                    </a>
                                                    <button id="spinnerButton_{{ $data->id }}"
                                                        class="btn-send-mail btn-sm" style="display: none;" disabled>
                                                        <span class="spinner-border spinner-border-sm me-1"></span>
                                                        Sending...
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-end" style="padding-right: 24px !important;">
                                            <div class="dropdown action-dropdown">
                                                <button class="btn-dots dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" data-bs-boundary="viewport"
                                                    aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item" type="button"
                                                            onclick="download_quotation('{{ $data->id }}')">
                                                            <i class="fa fa-download"></i> Download PDF
                                                        </button>
                                                    </li>
                                                    @if ($data->payment_status !== 'paid')
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('erp_acceptedquote.revisequote') }}?enquiry_id={{ $data->id }}">
                                                                <i class="fa fa-edit"></i> Revise Quote
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('erp_acceptedquote.addDocuments', ['id' => $data->id]) }}">
                                                            <i class="fa fa-file-alt"></i> Add Documents
                                                        </a>
                                                    </li>
                                                    @if ($data->service == 44)
                                                        <li>
                                                            <button class="dropdown-item" type="button"
                                                                onclick="SendMailcustomer('{{ $data->id }}')">
                                                                <i class="fa fa-envelope"></i> Email Customer
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('erp_acceptedquote.assignwarehouse', ['id' => $data->id]) }}">
                                                                <i class="fas fa-warehouse"></i> Assign
                                                                Warehouse
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('erp_acceptedquote.agreement', ['id' => $data->id]) }}">
                                                                <i class="fa fa-file-alt"></i> Agreement
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item fw-bold text-primary"
                                                                href="{{ route('storage-admin-order') }}?enquiry_id={{ $data->id }}">
                                                                <i class="fa fa-plus-circle"></i> Generate Order
                                                            </a>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('footer_js')
    <!-- Delete Category Modal -->
    <div class="modal custom-modal fade" id="delete_city" role="dialog">
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

    <div class="modal custom-modal fade" id="send_mail_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="modal-icon text-center mb-3">
                        <i class="fas fa-envelope text-primary"></i>
                    </div>

                    <div class="modal-text text-center">
                        <h4 class="mb-3">Send Mail</h4>

                        <div class="text-start px-3">
                            <label class="form-label fw-semibold">Select Mail Type</label>

                            <select id="mail_type" class="form-control">
                                <option value="">-- Select Mail Type --</option>
                                <option value="1">Normal</option>
                                <option value="2">With Pickup</option>
                                <option value="3">Without Pickup</option>
                            </select>

                            <small id="mail_error" class="text-danger d-none">
                                Please select mail type
                            </small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" class="btn btn-primary" onclick="submitMail()">
                        Send
                    </button>
                </div>

            </div>
        </div>
    </div>


    <script>
        // function delete_city()
        // {
        // 	 //alert('test');
        // 	var checked = $("#form input:checked").length > 0;
        // 	// alert(checked);
        //     if (!checked)
        // 		{
        //         alert("Please select at least one record to delete");
        //         return false;
        //     }
        // 	else
        // 	{
        // 		var conf = confirm("Do you really want to Delete?");
        // 		if(conf == true){
        // 			$('#form').submit();
        // 			return true;
        // 		}else{
        // 			return false;
        // 		}
        // 	}
        // }
    </script>
    <script>
        function delete_city() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_city').modal('show');
            }
        }

        function form_sub() {
            $('#form').submit();
        }
    </script>
    <script>
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        $(document).ready(function() {
            $('#example').dataTable({
                "searching": true
            });

            // Check All functionality
            $('#checkAll').on('click', function() {
                $('.custom-checkbox').prop('checked', this.checked);
            });
        })

        function button_spin(id) {
            // Hide the send mail button
            document.getElementById('sendmailbutton_' + id).style.display = 'none';

            // Show the spinner button
            document.getElementById('spinnerButton_' + id).style.display = 'block';
        }

        function download_quotation(id) {
            // var mail_format = document.getElementById('mail_format').value;

            // if (mail_format == '') {
            //     jQuery('#mail-format-errror').html("Please Select Mail Format");
            //     jQuery('#mail-format-errror').show().delay(0).fadeIn('show');
            //     jQuery('#mail-format-errror').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#mail_format').offset().top - 150
            //     }, 1000);
            //     return false;
            // }
            var mail_format = 1;
            $('#spinner_download_button').show();
            $('#download_button').hide();

            var url = "{{ route('erp_quote.download') }}"; // Laravel route

            // Construct query parameters
            var queryParams = new URLSearchParams({
                "_token": "{{ csrf_token() }}",
                "formatType": mail_format,
                "enquiry_id": id
            }).toString();

            // Redirect to the download route
            window.location.href = url + "?" + queryParams;

            setTimeout(function() {
                $('#spinner_download_button').hide();
                $('#download_button').show();
            }, 2000);
        }

        let selectedEnquiryId = null;

        function SendMailcustomer(id) {
            selectedEnquiryId = id;

            // reset form
            $('#mail_type').val('');
            $('#mail_error').addClass('d-none');

            $('#send_mail_modal').modal('show');
        }

        function submitMail() {

            let mail_type = $('#mail_type').val();

            if (mail_type === '') {
                $('#mail_error').removeClass('d-none');
                return;
            }

            $('#mail_error').addClass('d-none');

            // disable button + show loading
            let btn = event.target;
            $(btn).html('<span class="spinner-border spinner-border-sm"></span> Sending...');
            $(btn).prop('disabled', true);

            $.ajax({
                url: "{{ route('erp_acceptedquote.sendmailcustomer_ajax') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    enquiry_id: selectedEnquiryId,
                    mail_type: mail_type
                },
                success: function(response) {

                    if (response.status == 'success') {
                        $('#send_mail_modal').modal('hide');

                        // SUCCESS (use swal or bootstrap alert)
                        Swal.fire({
                            icon: 'success',
                            title: 'Mail Sent!',
                            text: response.message || 'Success'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Something went wrong'
                        });
                    }

                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong'
                    });
                },
                complete: function() {
                    $(btn).html('Send');
                    $(btn).prop('disabled', false);
                }
            });
        }
    </script>

@stop

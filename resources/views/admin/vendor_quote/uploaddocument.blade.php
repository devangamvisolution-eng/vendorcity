@extends('admin.includes.Template')
@section('content')
    <style>
       .hidden {
        display: none;
    }
    .checkbox-color{
        color: #0f548e !important;
    }
    input[type="checkbox"] {
        accent-color: #0f548e; /* Set the desired color */
    }
    .bg-color{
            background-color: #ccc;
            pointer-events: none; /* Disable any interaction */
            cursor: not-allowed; /* Change cursor to indicate no interaction */
        }

        .table-responsive .form-control {
    padding: 2px;
}
.table > tbody > tr > td {
    padding: 2px;
}
    </style>
    <div class="content container-fluid">

        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Upload Document</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Upload Document</li>
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
        
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                       
                        <form id="erp_enquiry_form" action="{{ route('vendorquote.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <input id="inquiry_id_hidden" name="inquiry_id_hidden" type="hidden" class="form-control" value="{{ $id }}" />
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Document</label>
                                        <input id="document" name="document[]" type="file" class="form-control"
                                            value="" multiple />
                                        
                                        <p class="form-error-text" id="document_error" style="color: red;"></p>
                                    </div>
                                </div>
                                
                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Volume In Cbm</label>
                                        <input id="volume_in_cbm" name="volume_in_cbm" type="text" class="form-control"
                                            value="{{$volume_in_cbm}}"  />
                                        
                                        <p class="form-error-text" id="volume_in_cbm_error" style="color: red;"></p>
                                    </div>
                                </div>
                                
                                
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Uploaded Documents</label>
                                    @if($erp_vendor_surveydocuments->isEmpty())
                                        <p>No documents uploaded yet.</p>
                                    @else
                                        <ul class="list-group">
                                            @foreach($erp_vendor_surveydocuments as $doc)
                                                <li class="list-group-item d-flex justify-content-between align-items-center" id="doc-{{ $doc->id }}">
                                                    <a href="{{ asset('public/upload/erp_vendor_surveydocuments/'.$doc->document) }}" target="_blank">
                                                        {{ $doc->document }}
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger delete-doc" data-id="{{ $doc->id }}">
                            Delete
                        </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>


                            
                                
                             
                            <div class="text-end mt-4 ">
                                <a class="btn btn-primary" href="{{ route('vendorquote.lists') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" onclick="javascript:category_validation()"
                                    id="submit_button">Submit</button>
                                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
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
        function category_validation() {

            // var survey_type = jQuery("#survey_type").val();
            // if (survey_type == '') {
            //     jQuery('#survey_type_error').html("Please Select Survey Type");
            //     jQuery('#survey_type_error').show().delay(0).fadeIn('show');
            //     jQuery('#survey_type_error').show().delay(2000).fadeOut('show');
            //     $('html, body').animate({
            //         scrollTop: $('#survey_type').offset().top - 150
            //     }, 1000);
            //     return false;
            // }

              
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#erp_enquiry_form').submit();
        }


        $(document).on('click', '.delete-doc', function () {
            let docId = $(this).data('id');
            let url = "{{ route('vendorquote.deletedoc', ':id') }}";
            url = url.replace(':id', docId);

            if (confirm('Are you sure you want to delete this document?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $("#doc-" + docId).remove();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('Something went wrong! Try again.');
                    }
                });
            }
        });

        
    </script>
   
    
 
@stop

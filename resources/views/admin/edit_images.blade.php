@extends('admin.includes.Template')



@section('content')
    <style>
        .custom_css_model h3 {
            font-size: 18px;
        }

        .custom_css_model .btn {
            padding: 0 8px !important;
        }
    </style>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Packages Image</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">Packages Image</a></li>
                        <li class="breadcrumb-item active">Edit Packages Image</li>
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
        <div class="alert alert-success alert-dismissible fade show success_show" style="display: none;">
            <strong>Success! </strong><span id="success_message"></span>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
        </div>
        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">
            <i class="fa fa-warning"></i>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
            <b>Error &nbsp;: </b><span id="error_msg1"></span>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="form" action="{{ route('editimage_store') }}" method="POST"
                            enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="action" VALUE="edit">
                            <INPUT TYPE="hidden" NAME="id" VALUE="{{ request()->segment(2) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Image (Size : 839px X 548px )</label>
                                        <input type="file" class="form-control" id="attachment1" name="attachment1[]"
                                            multiple>
                                        <p id="image_error" style="display: none;color: red"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('packages.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:validation()">Submit</button>
                                <!-- <input type="submit" name="submit" value="Submit" class="btn btn-primary"> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <style>
                .border_parts tr td {
                    border: 1px solid #ccc;
                    padding: 6px 6px 0px 6px;
                    width: 413px;
                    float: left;
                    border-collapse: collapse;
                    border-spacing: 0px;
                }
            </style>
            @if ($packagesimages != '' && count($packagesimages) > 0)
                <table class="border_parts">
                    <tr>
                        @php $i=1; @endphp
                        @foreach ($packagesimages as $images)
                            <td colspan="2"
                                style="width:340px; height:300px; margin-right:12px; margin-bottom:12px; background:#fff;">
                                <img style="height: 202px; width: 100%;"
                                    src="{{ asset('public/upload/packages_slider_img/large/' . $images->image) }}" />
                                &nbsp;<br>
                                <a style="float: right; font-size: 12px; margin-bottom: 3px; padding: 3px 0 2px; width: 64px;margin-top: 10px;"
                                    class="btn btn-primary btn-remove"
                                    data-delete-url="{{ route('packages_removeimage', ['pid' => $images->pid, 'id' => $images->id]) }}"
                                    href="#">Remove</a><br>
                            </td>
                            @php $i++; @endphp
                        @endforeach
                    </tr>
                </table>
            @endif
        </div>
    </div>



@stop



@section('footer_js')


    <!-- Delete  Modal -->
    <div class="modal custom-modal fade" id="delete_model" role="dialog">
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
                    <button type="button" class="btn btn-primary" id="deleteImageBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->



    <script>
        function validation() {
            var attachment1 = $("#attachment1").val();
            if (attachment1 == '') {
                //alert('Please Enter Fabric ');			
                jQuery('#image_error').html("Please Select Image");
                jQuery('#image_error').show().delay(0).fadeIn('show');
                jQuery('#image_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#attachment1').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#form').submit();
        }






        $(document).on('click', '.btn-remove', function(event) {
            event.preventDefault(); // Prevent the default link behavior
            var deleteUrl = $(this).data('delete-url'); // Get the delete URL from data attribute
            // Set the click event for the "Yes" button in the modal
            $('#deleteImageBtn').off('click').on('click', function() {
                window.location.href = deleteUrl; // Redirect to the delete URL
            });
            // Show the modal
            $('#delete_model').modal('show');
        });

        function singledelete(url) {
            var t = confirm('Are You Sure To Delete Image ?');
            if (t) {
                window.location.href = url;
            } else {
                return false;
            }
        }
    </script>
@stop

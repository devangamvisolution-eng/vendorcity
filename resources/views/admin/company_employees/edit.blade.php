@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Company Employees</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('company-employees.index') }}">Company Employees</a></li>
                        <li class="breadcrumb-item active">Edit Company Employees</li>
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
                        <form id="category_form"
                            action="{{ route('company-employees.update', $companyEmployee->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Employee</label>
                                         <select name="employee" id="employee" class="form-control">
                                            <option value="">Select an Employee</option>
                                            @foreach($employeeTypes as $value => $label)
                                                <option value="{{ $value }}" @selected($value === ($companyEmployee->employee ?? ''))>{{ $label }}</option>
                                            @endforeach
                                        </select>

                                        <p class="form-error-text" id="employee_error"
                                            style="color: red; margin-top: 10px;"></p>

                                        @error('vehicle_number')
                                            <p class="form-error-text" id="vehicale_vali_number_error"
                                                style="color: red; margin-top: 10px;">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input id="name" name="name" type="text" class="form-control"
                                            placeholder="Enter Driver/Packer Name"
                                            value="{{ $companyEmployee->name }}" />

                                        <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                        </p>
                                        @error('name')
                                            <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date EID</label>
                                        <input type="date" id="expiry_date" name="expiry_date" class="form-control"
                                            placeholder="Enter Expiry Date"
                                            value ="{{ $companyEmployee->expiry_date_eid }}" style="width: 102%;">
                                    </div>

                                </div>
                            </div>
                            @if (isset($companyEmpDocuments) && !empty($companyEmpDocuments))
                                @for ($i = 0; $i < count($companyEmpDocuments); $i++)
                                    <div class="row">
                                        <input type="hidden" id="updateid1xxx" name="updateid1xxx[]" class="form-control"
                                            value="{{ $companyEmpDocuments[$i]->id }}">
                                        <div class="col-md-3">
                                            <div class="form-group"> <label for="driver_name">Document Name</label>
                                                <input type="text" id="document_nameu" name="document_nameu[]"
                                                    class="form-control" placeholder="Enter Document Name"
                                                    value="{{ $companyEmpDocuments[$i]->title }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="upload_file-file">Upload Document</label>
                                                <input type="file" id="upload_fileu" name="upload_fileu[]"
                                                    class="form-control" placeholder="Enter Upload File"
                                                    style="width: 102%;">
                                            </div>
                                            @if (!empty($companyEmpDocuments[$i]->document))
                                                <a href="{{ asset('public/upload/companydriverpackers/' . $companyEmpDocuments[$i]->document) }}"
                                                    target="_blank" class="text-danger" style="margin:10px;">
                                                    <i class="fa fa-file-pdf fa-2x"></i>
                                                </a>
                                            @endif

                                        </div>
                                        <a href="#"
                                            onclick="singledelete('{{ route('company-emp-doc.delete', ['eid' => $companyEmpDocuments[$i]->eid, 'id' => $companyEmpDocuments[$i]->id]) }}')"
                                            class="btn btn-danger pull-right remove_field1"
                                            style="margin-right: 0;margin-top: 22px;width: 10%;float: right;height: 38px;margin-left: 128px;">Remove</a>
                                    </div>
                                @endfor
                            @endif


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group"> <label for="driver_name">Document Name</label>
                                        <input type="text" id="document_name" name="document_name[]"
                                            class="form-control" placeholder="Enter Document Name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="upload_file-file">Upload Document</label>
                                        <input type="file" id="upload_file" name="upload_file[]" class="form-control"
                                            placeholder="Enter Upload File" style="width: 102%;">
                                    </div>
                                </div>
                            </div>
                            <div class="input_fields_wrap12"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button
                                        style="border: medium none;margin-right: 125px;line-height: 25px;margin-top: -62px;color:#fff;"
                                        class="submit btn bg-purple pull-right" type="button"
                                        id="add_field_button12">Add</button>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('company-employees.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="button" class="btn btn-primary" id="submit_button"
                                    onclick="javascript:category_validation()">Submit</button>
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
            var employee = jQuery("#employee").val();
            if (employee == '') {
                jQuery('#employee_error').html("Please Select an Employee");
                jQuery('#employee_error').show().delay(0).fadeIn('show');
                jQuery('#employee_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#employee').offset().top - 150
                }, 1000);
                return false;
            }
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter a Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }
    </script>
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap12");
            var add_button = $("#add_field_button12");
            var b = 0;
            $(add_button).click(function(e) { //alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="row">  <div class="col-md-3"><div class="form-group"> <label for="driver_name">Document Name</label><input type="text" id="document_name" name="document_name[]" class="form-control"placeholder="Enter Document Name"></div></div><div class="col-md-3" ><div class="form-group"><label for="upload_file-file">Upload Document</label><input type="file" id="upload_file" name="upload_file[]"class="form-control"placeholder="Enter Upload File" style="width: 102%;"></div></div><a href = "#" class = "btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height:38px;margin-left: 127px;">Remove</a ></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });

        function validateNumber(event) {
            var key = window.event ? event.keyCode : event.which;
            if (event.keyCode === 8 || event.keyCode === 46) {
                return true;
            } else if (key < 48 || key > 57) {
                return false;
            } else {
                return true;
            }
        }

        function singledelete(url) {

            var t = confirm('Are You Sure To Delete The Document ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }

        }
    </script>
@stop

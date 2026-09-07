@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">



        <!-- Page Header -->

        <div class="page-header">

            <div class="row">

                <div class="col-sm-12">

                    <h3 class="page-title">Edit Company Profile</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>

                        <li class="breadcrumb-item"><a href="#">Company Profile</a></li>

                        <li class="breadcrumb-item active">Edit Company Profile</li>

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

                        <!-- <h4 class="card-title">Basic Info</h4> -->

                        <form id="category_form" action="{{ route('company-profile.update', $companyProfile->id) }}" method="POST"
                            enctype="multipart/form-data">

                            @csrf

                            @method('PUT')

                            <div class="row">

                                 <h3 style="font-size:18px;">Company Details :</h3>
                                 <div class="col-md-6">
                                <div class="form-group">

                                    <label for="name">Comapny Name</label>

                                    <input id="comapnyname" name="comapnyname" type="text" class="form-control"
                                        placeholder="Enter Name" value="{{$companyProfile->name}}" />

                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>

                                </div>
                                </div>
                                 <div class="col-md-6">
                                <div class="form-group">

                                    <label for="name">Website</label>

                                    <input id="website" name="website" type="text" class="form-control"
                                        placeholder="Enter Website" value="{{$companyProfile->website}}" />

                                    <p class="form-error-text" id="website_error" style="color: red; margin-top: 10px;"></p>

                                </div>
                                </div>
                                 <div class="col-md-6">
                                <div class="form-group">

                                    <label for="name">Mobile No</label>

                                    <input id="mobile" name="mobile" type="text" class="form-control"
                                        placeholder="Enter Mobile No" value="{{$companyProfile->mobile}}" />

                                    <p class="form-error-text" id="mobile_error" style="color: red; margin-top: 10px;"></p>

                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">

                                    <label for="name">G-Map</label>

                                    <input id="g_map" name="g_map" type="text" class="form-control"
                                        placeholder="Enter G-Map" value="{{$companyProfile->gmap}}" />

                                    <p class="form-error-text" id="g_map_error" style="color: red; margin-top: 10px;"></p>

                                </div>
                                </div>
                                 <div class="col-md-12">
                                <div class="form-group">

                                    <label for="name">Address</label>

                                    <textarea id="address" name="address" type="text" class="form-control"
                                        placeholder="Enter Address" value="">{{$companyProfile->address}}</textarea>

                                    <p class="form-error-text" id="g_map_error" style="color: red; margin-top: 10px;"></p>

                                </div>
                                </div>
                                <h3 style="font-size:18px;">Company Documents :</h3>
                                @if(isset($companyProfileDocuments) && !empty($companyProfileDocuments))
                                @for($i = 0; $i < count($companyProfileDocuments); $i++)
                                <div class="row">
                                    <input type="hidden" id="updateid1xxx" name="updateid1xxx[]" class="form-control"
                                            value="{{$companyProfileDocuments[$i]->id}}">
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="doc_title">Title</label>
                                            <input type="text" id="doc_title" name="titleu[]" class="form-control"
                                                placeholder="Enter Title" value="{{$companyProfileDocuments[$i]->title}}">
                                        </div>
                                    </div>
                                     
                                     <div class="col-md-4" >
                                        <div class="form-group">
                                            <label for="upload_file-file">Upload File</label>
                                            <input type="file" id="upload_file" name="upload_fileu[]" class="form-control"
                                                placeholder="Enter Upload File" style="width: 102%;">
                                        </div>
                                           @if(!empty($companyProfileDocuments[$i]->document))
                                            <a href="{{ asset('public/upload/profile-docs/'.$companyProfileDocuments[$i]->document) }}"
                                            target="_blank"
                                            class="text-danger" style="margin:10px;">
                                                <i class="fa fa-file-pdf fa-2x"></i>
                                            </a>
                                            @endif
                                    </div>
                                    <a href="#"
                                        onclick="singledelete('{{ route('company-documents.delete', ['cid' => $companyProfileDocuments[$i]->company_profile_id, 'id' => $companyProfileDocuments[$i]->id]) }}')"
                                        class="btn btn-danger pull-right remove_field1"
                                        style="margin-right: 0;margin-top: 22px;width: 10%;float: right;height: 38px;margin-left: 128px;">Remove</a>
                                     
                                    </div>
                                     @endfor
                                @endif
                                  <div class="row">
                                <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="doc_title">Title</label>
                                            <input type="text" id="doc_title" name="title1[]" class="form-control"
                                                placeholder="Enter Title" value="">
                                        </div>
                                    </div>
                                     
                                     <div class="col-md-4" >
                                        <div class="form-group">
                                            <label for="upload_file-file">Upload File</label>
                                            <input type="file" id="upload_file" name="upload_file1[]" class="form-control"
                                                placeholder="Enter Upload File" style="width: 102%;">
                                        </div>
                                    </div>

                                    <div class="input_fields_wrap12"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button
                                        style="border: medium none;margin-right: 115px;line-height: 25px;margin-top: -62px;color:#fff;"
                                        class="submit btn bg-purple pull-right text-light" type="button"
                                        id="add_field_button12">Add</button>
                                    </div>
                                </div>
                                </div>
                               








                            </div>

                            <div class="text-end mt-4">

                                <a class="btn btn-primary" href="#"> Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

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

<script src="{{ asset('public/admin/assets/ckeditor/build/ckeditor.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>  
<script>

ClassicEditor
            .create(document.querySelector('#address'))
            .catch(error => {
                console.error(error);
            });
</script>

    <script>
        function category_validation() {


            var country = jQuery("#comapnyname").val();
            if (country == '') {
                jQuery('#name_error').html("Please Enter Name");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name_error').offset().top - 150
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
                        '<div class="row"><div class="col-md-4"><div class="form-group"><label for="doc_title">Title</label><input type="text" id="doc_title" name="title1[]" class="form-control"placeholder="Enter Title"></div></div><div class="col-md-4"><div class="form-group"><label for="upload_file-file">Upload File</label> <input type="file" id="upload_file" name="upload_file1[]" class="form-control"placeholder="Enter Upload File" style="width: 102%;"></div></div><a href = "#" class = "btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 23px;width: 10%;float: right;height:38px;margin-left: 59px;">Remove</a ></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });

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

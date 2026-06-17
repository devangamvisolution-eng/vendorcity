@extends('admin.includes.Template')



@section('content')

<style type="text/css">
    ul li{list-style: inherit;}
</style>



    <div class="content container-fluid">







        <!-- Page Header -->



        <div class="page-header">



            <div class="row">



                <div class="col-sm-12">



                    <h3 class="page-title">Blog</h3>



                    <ul class="breadcrumb">



                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>



                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>



                        <li class="breadcrumb-item active">Add Blog</li>



                    </ul>



                </div>



            </div>



        </div>



        <!-- /Page Header -->







        <div id="validator" class="alert alert-danger alert-dismissable" style="display:none;">



            <i class="fa fa-warning"></i>



            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->



            <b>Error &nbsp;: </b><span id="error_msg1"></span>



        </div>







        <!-- <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">



                                   <span id="login_error"></span>



                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>



                                  </div> -->







        <div class="row">



            <div class="col-md-12">



                <div class="card">



                    <div class="card-body">



                        <!-- <h4 class="card-title">Basic Info</h4> -->



                        <form action="{{ route('blog.store') }}" method="POST" id="form"

                            enctype="multipart/form-data">



                            @csrf



                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Blog Category</label>
                                        <select type="text" class="form-control" id="blog_category" name="blog_category">
                                            <option value="">Select Blog Category</option>
                                            @foreach($blog_category_data as $data)
                                            <option  value="{{$data->id}}">{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="blog_category_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                                        <p class="form-error-text" id="title_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Blog Url</label>
                                        <input type="text" class="form-control" id="blog_url" name="blog_url" placeholder="Enter Blog url">
                                        <p class="form-error-text" id="blog_url_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" class="form-control" id="date" name="date" placeholder="Select Date">
                                            <p class="form-error-text" id="date_error" style="color: red; margin-top: 10px;"></p>
                                        </div>
                                    </div>
                            

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="short_description" style="margin:15px 0 5px 0px; width:100%;">Short Description</label>
                                        <textarea id="short_description" name="short_description" class="form-control" placeholder="Enter Short Description"></textarea>
                                        <p class="form-error-text" id="short_description_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" style="margin:15px 0 5px 0px; width:100%;">Description</label>
                                        <textarea id="description" name="description" class="form-control" placeholder="Enter Description"></textarea>
                                        <p class="form-error-text" id="description_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Service</label>
                                        <select type="text" class="form-control" id="service" name="service" onchange="subservice_change(this.value);">
                                            <option value="">Select Service</option>
                                            @foreach($service_data as $data)
                                            <option  value="{{$data->id}}">{{$data->servicename}}</option>
                                            @endforeach
                                        </select>
                                        <p class="form-error-text" id="service_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sub Service</label>
                                        <span id="subservice_chang">
                                        <select type="text" class="form-control" id="subservice" name="subservice">
                                            <option value="">Select Sub Service</option>
                                           
                                    
                                        </select></span>
                                        <p class="form-error-text" id="subservice_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Meta title</label>
                                        <input type="text" class="form-control" id="metatitle" name="metatitle" placeholder="Enter Metatitle">
                                        <p class="form-error-text" id="metatitle_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Meta description</label>
                                        <input type="text" class="form-control" id="metadescription" name="metadescription" placeholder="Enter Metadescription">
                                        <p class="form-error-text" id="metadescription_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image (Size : 925px X 500px )</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        <p class="form-error-text" id="image_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt tag</label>
                                        <input type="text" class="form-control" id="image_alt_tag" name="image_alt_tag" placeholder="Enter Image Alt tag">
                                        <p class="form-error-text" id="image_alt_tag_error" style="color: red; margin-top: 10px;"></p>
                                    </div>
                                </div>





                               
                            </div>



                            <div class="text-end mt-4">



                                <a href="{{ route('blog.index') }}" class="btn btn-primary text-light">Cancel</a>



                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"

                                    style="display: none;">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" onclick="validation();" id="submit_button"

                                    class="btn btn-primary">Submit</button>



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

        function validation() {

            var blog_category = jQuery("#blog_category").val();
               if (blog_category == '') {
                   jQuery('#blog_category_error').html("Please Select Blog Category");
                   jQuery('#blog_category_error').show().delay(0).fadeIn('show');
                   jQuery('#blog_category_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#blog_category').offset().top - 150
                   }, 1000);
                   return false;
               }
            var title = jQuery("#title").val();
               if (title == '') {
                   jQuery('#title_error').html("Please Enter Title");
                   jQuery('#title_error').show().delay(0).fadeIn('show');
                   jQuery('#title_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#title').offset().top - 150
                   }, 1000);
                   return false;
               }
               var blog_url = jQuery("#blog_url").val();
               if (blog_url == '') {
                   jQuery('#blog_url_error').html("Please Enter Blog Url");
                   jQuery('#blog_url_error').show().delay(0).fadeIn('show');
                   jQuery('#blog_url_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#blog_url').offset().top - 150
                   }, 1000);
                   return false;
               }
               var date = jQuery("#date").val();
               if (date == '') {
                   jQuery('#date_error').html("Please Select Date");
                   jQuery('#date_error').show().delay(0).fadeIn('show');
                   jQuery('#date_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#date').offset().top - 150
                   }, 1000);
                   return false;
               }
            //    var short_description = jQuery("#short_description").val();
            //    if (short_description == '') {
            //        jQuery('#short_description_error').html("Please Enter Short Description");
            //        jQuery('#short_description_error').show().delay(0).fadeIn('show');
            //        jQuery('#short_description_error').show().delay(2000).fadeOut('show');
            //        $('html, body').animate({
            //            scrollTop: $('#short_description').offset().top - 150
            //        }, 1000);
            //        return false;
            //    }
            //    var description = jQuery("#description").val();
            //    if (description == '') {
            //        jQuery('#description_error').html("Please Enter Description");
            //        jQuery('#description_error').show().delay(0).fadeIn('show');
            //        jQuery('#description_error').show().delay(2000).fadeOut('show');
            //        $('html, body').animate({
            //            scrollTop: $('#description').offset().top - 150
            //        }, 1000);
            //        return false;
            //    }
               var service = jQuery("#service").val();
               if (service == '') {
                   jQuery('#service_error').html("Please Select Service");
                   jQuery('#service_error').show().delay(0).fadeIn('show');
                   jQuery('#service_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#service').offset().top - 150
                   }, 1000);
                   return false;
               }
               var subservice = jQuery("#subservice").val();
               if (subservice == '') {
                   jQuery('#subservice_error').html("Please Select SubService");
                   jQuery('#subservice_error').show().delay(0).fadeIn('show');
                   jQuery('#subservice_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#subservice').offset().top - 150
                   }, 1000);
                   return false;
               }
               var metatitle = jQuery("#metatitle").val();
               if (metatitle == '') {
                   jQuery('#metatitle_error').html("Please Enter Metatitle");
                   jQuery('#metatitle_error').show().delay(0).fadeIn('show');
                   jQuery('#metatitle_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#metatitle').offset().top - 150
                   }, 1000);
                   return false;
               }
               var metadescription = jQuery("#metadescription").val();
               if (metadescription == '') {
                   jQuery('#metadescription_error').html("Please Enter Metadescription");
                   jQuery('#metadescription_error').show().delay(0).fadeIn('show');
                   jQuery('#metadescription_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#metadescription').offset().top - 150
                   }, 1000);
                   return false;
               }

               var image = jQuery("#image").val();
               if (image == '') {
                   jQuery('#image_error').html("Please Select Image");
                   jQuery('#image_error').show().delay(0).fadeIn('show');
                   jQuery('#image_error').show().delay(2000).fadeOut('show');
                   $('html, body').animate({
                       scrollTop: $('#image').offset().top - 150
                   }, 1000);
                   return false;
               }











            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#form').submit();

        }

    </script>







    <script>

        $(document).ready(function() {

            $("#title").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#blog_url").val(Text);
            });
        });

    </script>


<script src="{{ asset('public/admin/assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

    
    
    <script>

       ClassicEditor
        .create(document.querySelector('#description'), {
               ckfinder: {
                uploadUrl: "{{route('ckeditor.upload').'?_token='.csrf_token()}}",
            },
            heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
            }
        })
        .catch(error => {
            console.error(error);
        });

       ClassicEditor
        .create(document.querySelector('#short_description'), {
            heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
            }
        })
        .catch(error => {
            console.error(error);
        });
    </script>
    
               

<script type="text/javascript">
    function subservice_change(service) {

        var url = '{{ url('blog_subservice_show') }}';

        $.ajax({
            url: url,
            type: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                "service": service
            },
            success: function(msg) {
                document.getElementById('subservice_chang').innerHTML = msg;
            }
        });
    }
</script>




@stop


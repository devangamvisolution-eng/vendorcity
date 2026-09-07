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



                    <h3 class="page-title">Edit Blog Category</h3>



                    <ul class="breadcrumb">



                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>



                        <li class="breadcrumb-item"><a href="{{ route('blog_category.index') }}">Blog Category</a></li>



                        <li class="breadcrumb-item active">Edit Blog Category</li>



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







        <div class="row">



            <div class="col-md-12">



                <div class="card">



                    <div class="card-body">



                        <!-- <h4 class="card-title">Basic Info</h4> -->



                        <form id="form" action="{{ route('blog_category.update', $blog_category_data->id) }}" method="POST"

                            enctype="multipart/form-data">



                            @csrf



                            @method('PUT')
                            <div class="row">
                               
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name"> Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                    placeholder="Enter Name" value="{{ $blog_category_data->name }}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>



                                <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Page Url</label>
                                    <input id="page_url" name="page_url" type="text" class="form-control" placeholder="Enter Page Url" value="{{ $blog_category_data->page_url }}" />
                                    <p class="form-error-text" id="page_url_error" style="color: red; margin-top: 10px;"></p>
                                 </div>
                                 </div>

                            </div>



                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('blog_category.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                style="display: none;">

                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Loading...

                                </button>



                                <button type="button" class="btn btn-primary" id="submit_button"

                                    onclick="javascript:validation()">Submit</button>
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

    var name = jQuery("#name").val();
       if (name == '') {
           jQuery('#name_error').html("Please Enter Name");
           jQuery('#name_error').show().delay(0).fadeIn('show');
           jQuery('#name_error').show().delay(2000).fadeOut('show');
           $('html, body').animate({
               scrollTop: $('#name').offset().top - 150
           }, 1000);
           return false;
       }
    $('#spinner_button').show();
    $('#submit_button').hide();
    $('#form').submit();

}

</script>

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



<script>

    $(document).ready(function() {

        $("#name").keyup(function() {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
            $("#page_url").val(Text);
        });
    });

</script>
@stop


@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Inspection Package</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('verifybuy-packages.index') }}">Inspection Package</a></li>
                        <li class="breadcrumb-item active">Edit Inspection Package</li>
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
                        <form id="category_form" action="{{ route('verifybuy-packages.update',$verifybuypackages->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"
                                        placeholder="Enter Name" value="{{$verifybuypackages->name}}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input id="price" name="price" type="text" class="form-control"
                                        placeholder="Enter Price" value="{{$verifybuypackages->price}}" />
                                    <p class="form-error-text" id="price_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                                   <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tag">Tag</label>
                                    <input id="tag" name="tag" type="text" class="form-control"
                                        placeholder="Enter Tag" value="{{$verifybuypackages->tag}}" />
                                    <p class="form-error-text" id="tag_error" style="color: red; margin-top: 10px;"></p>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input id="image" name="image" type="file" class="form-control"
                                         value="" />
                                    <p class="form-error-text" id="image_error" style="color: red; margin-top: 10px;"></p>
                                    <img src="{{ url('public/upload/verifybuypackages/medium/' . $verifybuypackages->image) }}"
                                                           style="width:20%;">
                                </div>
                                </div>
                                    @if(!empty($verifybuypackagesattr))
                                      <input type="hidden" name="details1[]" value="">

                                    @for ($i = 0; $i < count($verifybuypackagesattr); $i++)
                                     



                                       <div class="row">
                                        <input type="hidden" name="updateid1xxx[]" id="updateid1xxx{{ $i + 1 }}"
                                                value="{{ $verifybuypackagesattr[$i]->id }}">
                                         
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Details</label>
                                            <input type="text" id="details" name="detailsu[]" class="form-control"
                                                placeholder="Enter Details" value="{{ $verifybuypackagesattr[$i]->details }}">
                                        </div>
                                    </div>
                                    
                                </div>
                               
                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <a href="#" onclick="singledelete('{{route('remove_inspection_package_attr',['pid' => $verifybuypackagesattr[$i]->verify_buy_package_id, 'id' => $verifybuypackagesattr[$i]->id])}}')"
                                            style="border: medium none;margin-right: 20%;line-height: 25px;margin-top: -62px;width: 8%;"
                                            class="submit btn btn-danger pull-right" type="button"
                                            >Remove</a>

                                    </div>

                                </div>
                                @endfor
                                      


                                    

                                         <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label for="poc">Details</label>
                                            <input type="text" id="details" name="details1[]" class="form-control"
                                                placeholder="Enter Details">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="input_fields_wrap12"></div>
                                <div class="form-group">

                                    <div class="col-sm-12">

                                        <button
                                            style="border: medium none;margin-right: 20%;line-height: 25px;margin-top: -62px;width: 8%;"
                                            class="submit btn bg-purple pull-right" type="button"
                                            id="add_field_button12">Add</button>

                                    </div>

                                </div>


                                    @endif
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('verifybuy-packages.index') }}"> Cancel</a>
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
    <script>
        function category_validation() {
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
            $('#category_form').submit();
        }
    </script>
        <script type="text/javascript" language="javascript">

            function singledelete(url){
                var t = confirm('Are You Sure To Delete The Attribute ?');

            if (t) {

                window.location.href = url;

            } else {

                return false;

            }

                   

            }
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

                        '<div class="row"><div class="col-md-6"><div class="form-group"> <label for="poc">Details</label><input type="text" id="details" name="details1[]" class="form-control"placeholder="Enter Details"></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 0;margin-top: 22px;width: 8%;float: right;height: 38px;margin-left: 13%;">Remove</a></div>'
                    );

                }

            });

            $(wrapper).on("click", ".remove_field1", function(e) {

                e.preventDefault();

                $(this).parent('div').remove();

                b--;

            })

        });
    </script>
@stop

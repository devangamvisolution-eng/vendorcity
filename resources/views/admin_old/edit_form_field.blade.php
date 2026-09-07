@extends('admin.includes.Template')
@section('content')

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Form Field</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('form_field.index') }}">Form Field</a></li>
                        <li class="breadcrumb-item active">Edit Form Field</li>
                    </ul>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
        <!-- /Page Header -->

        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="cms_form" action="{{ route('form_field.update', $form_filed->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">Lable Name</label>
                                    <input id="name" name="lable_name" type="text" class="form-control"
                                        placeholder="Enter Lable Name" value="{{ $form_filed->lable_name }}" />
                                    <p class="form-error-text" id="lable_name_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label for="name"> Type </label>
                                    <select id="type" name="type" class="form-control">
                                        <option value="" selected>Select Type</option>
                                        <option value="1" @if ($form_filed->type == 1) {{ 'selected' }} @endif>
                                            Input</option>
                                        <option value="2" @if ($form_filed->type == 2) {{ 'selected' }} @endif>
                                            Dropdown</option>
                                        <option value="3" @if ($form_filed->type == 3) {{ 'selected' }} @endif>
                                            Radio</option>
                                        <option value="4" @if ($form_filed->type == 4) {{ 'selected' }} @endif>
                                            Checkbox</option>
                                        <option value="5" @if ($form_filed->type == 5) {{ 'selected' }} @endif>
                                            Text area</option>
                                        <option value="6" @if ($form_filed->type == 6) {{ 'selected' }} @endif>
                                            Date</option>
                                        <option value="7"
                                            @if ($form_filed->type == 7) {{ 'selected' }} @endif>
                                            Multiple Dropdown</option>
                                        <option value="8"
                                            @if ($form_filed->type == 8) {{ 'selected' }} @endif>
                                            Upload Image</option>
                                        <option value="9"
                                            @if ($form_filed->type == 9) {{ 'selected' }} @endif>
                                            Time</option>
                                    </select>
                                    <p class="form-error-text" id="type_error" style="color: red; margin-top: 10px;">
                                    </p>
                                </div>


                                @if ($addition_item != '')
                                    <input type="hidden" name="option1[]" value="">
                                    @for ($i = 0; $i < count($addition_item); $i++)
                                        <input type="hidden" name="updateid1[]" id="updateid1{{ $i + 1 }}"
                                            value="{{ $addition_item[$i]->id }}">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="categoryname">Option</label>
                                                <input id="form_option{{ $i + 1 }}"
                                                    value="{{ $addition_item[$i]->form_option }}" name="form_optionu[]"
                                                    type="text" class="form-control" placeholder="Enter Option" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">

                                            <a href="#"
                                                onclick="singledelete('{{ route('remove_attribute', ['form_id' => $addition_item[$i]->form_id, 'id' => $addition_item[$i]->id]) }}');"
                                                href="javascript:void(0);" style="margin-right: 115px; margin-top: 22px;"
                                                class="btn btn-danger pull-right">Remove</a>
                                        </div>

                                        <div class="input_fields_wrap{{ $addition_item[$i]->id }}"></div>

                                        <div class="form-group"
                                            style="margin-left: 731px;margin-top: -62px;/* margin-bottom:37px; */">
                                            <div class="col-sm-2">
                                                <button class="btn btn-primary" type="button"
                                                    id="add_field_button_more{{ $addition_item[$i]->id }}"
                                                    onclick="add_u({{ $addition_item[$i]->id }})">Add
                                                    More
                                                    ++
                                                </button>
                                            </div>
                                        </div>
                                        @php
                                            $more_formfields_items = DB::table('more_form_attributes')
                                                ->where('attr_id', $addition_item[$i]->id)
                                                ->where('form_id', '=', $addition_item[$i]->form_id)
                                                ->get();

                                        @endphp
                                        @for ($j = 0; $j < count($more_formfields_items); $j++)
                                            <input type="hidden" name="updateid2[]" id="updateid2{{ $j + 1 }}"
                                                value="{{ $more_formfields_items[$j]->id }}">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="categoryname">More Option</label>
                                                    <input id="form_option{{ $j + 1 }}"
                                                        value="{{ $more_formfields_items[$j]->more_form_option }}"
                                                        name="more_form_optionu{{ $more_formfields_items[$j]->id }}[]"
                                                        type="text" class="form-control" placeholder="Enter Option" />
                                                </div>


                                                {{-- <a href="#" class="btn btn-danger"
                                                    style="margin-left: 950px;margin-top: -105px;"
                                                    onclick="singledelete('{{ route('remove_add_more_attribute', ['form_id' => $addition_item[$i]->form_id, 'attr_id' => $addition_item[$i]->id], ['id' => $more_formfields_items[$j]->id]) }}');"
                                                    href="javascript:void(0);">Removedd</a> --}}
                                                <a href="#" class="btn btn-danger"
                                                    style="margin-left: 950px;margin-top: -105px;"
                                                    onclick="singledelete('{{ route('remove_add_more_attribute', ['form_id' => $addition_item[$i]->form_id, 'id' => $more_formfields_items[$j]->id, 'attr_id' => $addition_item[$i]->id]) }}');"
                                                    href="javascript:void(0);">Remove</a>




                                            </div>
                                        @endfor
                                    @endfor
                                @endif

                                @php
                                    $countArray = count($addition_item);
                                    if ($countArray > 0) {
                                        $displayDiv = 'display:none;';
                                    } else {
                                        $displayDiv = 'display:block;';
                                    }
                                @endphp

                                <div class="col-md-9" style="{{ $displayDiv }}">
                                    <div class="form-group">
                                        <label for="category">Option</label>
                                        <input id="form_option1" name="form_option1[]" type="text"
                                            class="form-control" placeholder="Enter Option" value="" />
                                    </div>
                                </div>

                                {{-- <div class="input_fields_wrap0"></div>

                                <div class="form-group" style="margin-bottom:37px;">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none; margin-left: 935px; line-height: 28px; margin-top: -68px;"
                                            class="btn btn-primary" type="button" id="add_field_button0">Add More ++--
                                        </button>
                                    </div>    
                                </div> --}}

                                <div class="input_fields_wrap12"></div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button
                                            style="border: medium none; margin-left: 900px; line-height: 28px; margin-top: -70px;"
                                            class="btn btn-primary" type="button" id="add_field_button12">Add More
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('form_field.index') }}"> Cancel</a>
                                <button type="button" class="btn btn-primary"
                                    onclick="javascript:cms_validation()">Submit</button>
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

    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        $(function() {
            $("#name").keyup(function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                $("#page_url").val(Text);
            });
        });
    </script>

    <script>
        function singledelete(url) {
            var t = confirm('Are You Sure To Delete The Attribute ?');
            if (t) {
                window.location.href = url;
            } else {
                return false;
            }
        }
    </script>

    <script>
        function cms_validation() {
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#lable_name_error').html("Please Enter Lable Name");
                jQuery('#lable_name_error').show().delay(0).fadeIn('show');
                jQuery('#lable_name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name').offset().top - 150
                }, 1000);
                return false;
            }

            var type = jQuery("#type").val();
            if (type == '') {
                jQuery('#type_error').html("Please Enter Type");
                jQuery('#type_error').show().delay(0).fadeIn('show');
                jQuery('#type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#type').offset().top - 150
                }, 1000);
                return false;
            }

            $('#cms_form').submit();
        }
    </script>

    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap12");
            var add_button = $("#add_field_button12");

            var b = 0;
            $(add_button).click(function(e) {
                //alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="col-md-12"><div class="row"><div class="col-md-9"><label for="category">Option</label><input id="form_option' +
                        b +
                        '" name="form_option1[]" type="text" class="form-control" placeholder="Enter Option" value="" /></div><div class="input_fields_wrap' +
                        b +
                        '"></div><div class="form-group" style="margin-bottom:37px;"><div class="col-sm-12"><button style="border: medium none; margin-left: 935px; line-height: 28px; margin-top: -68px;"class="btn btn-primary" type="button" id="add_field_button' +
                        b + '" onclick="add_m(' + b +
                        ')">Add More +++</button></div></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 115px; margin-top: -42px;line-height: 25px;">Remove</a></div>'
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

    <script>
        $(document).ready(function() {
            var max_fields = 50;
            var wrapper = $(".input_fields_wrap0");
            var add_button = $("#add_field_button0");

            var b = 0;
            $(add_button).click(function(e) {
                // alert('ok');
                e.preventDefault();
                if (b < max_fields) {
                    b++;
                    $(wrapper).append(
                        '<div class="col-md-12"><div class="row"><div class="col-md-4 mb-3"><label for="category">More Option</label><input id="form_option" name="more_form_option0[]" type="text" class="form-control" placeholder="Enter Option" value="" /></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 100px; margin-top: -42px;line-height: 25px;">-</a></div>'
                    );
                }
            });
            $(wrapper).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            })
        });


        function add_m(id) {


            var max_fields = 50;
            var wrapper = $(".input_fields_wrap" + id);
            var add_button = $("#add_field_button" + id);

            var b = 0;
            if (b < max_fields) {
                b++;
                $(".input_fields_wrap" + id).append(
                    '<div class="col-md-12"><div class="row"><div class="col-md-4 mb-3"><label for="category">More Option</label><input id="form_option" name="more_form_option' +
                    b +
                    '[]" type="text" class="form-control" placeholder="Enter Option" value="" /></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 100px; margin-top: -42px;line-height: 25px;">-</a></div>'
                );
            }
            //alert(b);
            $(".input_fields_wrap" + id).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });
        }

        function add_u(id) {

            var max_fields = 50;
            var wrapper = $(".input_fields_wrap" + id);
            var add_button = $("#add_field_button_more" + id);

            var b = 0;
            if (b < max_fields) {
                b++;
                $(".input_fields_wrap" + id).append(
                    '<div class="col-md-12"><div class="row"><div class="col-md-4 mb-3"><label for="category">More Option</label><input id="form_option" name="more_form_optionuin' +
                    id +
                    '[]" type="text" class="form-control" placeholder="Enter Option" value="" /></div></div><a href="#" class="btn btn-danger pull-right remove_field1" style="margin-right: 100px; margin-top: -42px;line-height: 25px;">-</a></div>'
                );
            }
            //alert(b);
            $(".input_fields_wrap" + id).on("click", ".remove_field1", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                b--;
            });
        }
    </script>


@stop

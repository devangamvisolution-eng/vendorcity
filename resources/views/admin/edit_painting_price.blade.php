@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Painting Price</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        {{-- <li class="breadcrumb-item"><a href="{{ route('state.index') }}">System</a></li> --}}
                        <li class="breadcrumb-item active">Edit Painting Price</li>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="painting-price_form" action="{{ route('painting-price.update',1) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                {{-- Start Size Of Home  --}}
                                @php $i=0;$j=0; @endphp
                                <h3><u>Apartment</u></h3>
                                @foreach ($painting_price_data as $data)
                                @php 
                                if(isset($data->price) && !empty($data->price)){
                                   $value =  $data->price;
                                }else{
                                    $value = 0;
                                }
                                @endphp
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        @if($i == 0)
                                        <label for="name"><b>Size Of Home</b></label>
                                        @endif
                                        <input type="hidden" id="size_of_home_id" value="{{ $data->id }}" name="size_of_home_id[]" > 
                                        <input type="hidden" id="types_of_tab_apartment" value="{{ $data->types_of_tab }}" name="types_of_tab_apartment[]" > 
                                        <input type="text" name="size_of_home[]" value="{{ $data->size_of_home }}" class="form-control" style="margin-top: 10px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        @if($i == 0)
                                        <label for="name"><b>Price</b></label>
                                        @endif
                                        <input type="text" name="price[]" id="{{$data->id}}" value="{{ $value }}" placeholder="Enter Price" class="form-control" style="margin-top: 10px;" >
                                    </div>
                                </div>
                                @php
                                $i++;
                                @endphp
                                @endforeach

                                {{-- END Size Of Home  --}}

                                {{-- Start Apartment Color  --}}
                                @php $k=0; @endphp
                                <div class="mt-3">
                                @foreach ($getColorWantWallsPainted as $data)
                                @php 
                                if(isset($data->price) && !empty($data->price)){
                                   $value =  $data->price;
                                }else{
                                    $value = 0;
                                }
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($k == 0)
                                        <label for="name"><b>Color</b></label>
                                        @endif
                                        <input type="hidden" id="apartment_color_id" value="{{ $data->id }}" name="apartment_color_id[]" > 
                                        <input type="hidden" id="colors_of_apartment" value="{{ $data->flags_of_tab }}" name="colors_of_apartment[]" > 
                                        <input type="hidden" id="types_of_tab_color_apartment" value="{{ $data->types_of_tab }}" name="types_of_tab_color_apartment[]" > 
                                        <input type="text" name="apartment_colors[]" value="{{ $data->size_of_home }}" class="form-control" style="margin-top: 10px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        @if($k == 0)
                                        <label for="name"><b>Price</b></label>
                                        @endif
                                        <input type="text" name="apartment_color_price[]" id="{{$data->id}}" value="{{ $value }}" placeholder="Enter Price" class="form-control" style="margin-top: 10px;" >
                                    </div>
                                </div>
                                @php
                                $k++;
                                @endphp
                                @endforeach
                                {{-- END Apartment Color  --}}

                                {{-- Start Apartment Home Furnish  --}}
                                @php $k=0; @endphp
                                <div class="mt-3">
                                @foreach ($getHomeFurnishPainted as $data)
                                @php 
                                if(isset($data->price) && !empty($data->price)){
                                    $value =  $data->price;
                                }else{
                                    $value = 0;
                                }
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($k == 0)
                                        <label for="name"><b>Home Furnish</b></label>
                                        @endif
                                        <input type="hidden" id="apartment_furnished_id" value="{{ $data->id }}" name="apartment_furnished_id[]" > 
                                        <input type="hidden" id="apartment_furnished_flg" value="{{ $data->flags_of_tab }}" name="apartment_furnished_flg[]" > 

                                        <input type="hidden" id="types_of_tab_apart_furnished" value="{{ $data->types_of_tab }}" name="types_of_tab_apart_furnished[]" > 
                                        <input type="text" name="apartment_home_furnish[]" value="{{ $data->size_of_home }}" class="form-control" style="margin-top: 10px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        @if($k == 0)
                                        <label for="name"><b>Price</b></label>
                                        @endif
                                        <input type="text" name="apartment_home_furnish_price[]" id="{{$data->id}}" value="{{ $value }}" placeholder="Enter Price" class="form-control" style="margin-top: 10px;" >
                                    </div>
                                </div>
                                @php
                                $k++;
                                @endphp
                                @endforeach
                                {{-- END Apartment Home Furnish  --}}

                            </div>  

                            {{-- Start Villa Home Size  --}}
                                <h3 class="mt-5"><u>Villa</u></h3>
                                @foreach ($villaPainting_price_data as $data)
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($j == 0)
                                        <label for="name"><b>Size Of Home</b></label>
                                        @endif
                                        <input type="hidden" id="villa_home_size" value="{{ $data->id }}" name="villa_home_size_id[]" > 
                                        <input type="hidden" id="type_of_tab_villa" value="{{ $data->types_of_tab }}" name="type_of_tab_villa[]" > 
                                        <input type="text" name="villa_home_size[]" value="{{ $data->size_of_home }}" class="form-control" style="margin-top: 10px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        @if($j == 0)
                                        <label for="name"><b>Price</b></label>
                                        @endif
                                        <input type="text" name="villa_price[]" id="{{$data->id}}" value="{{ $data->price }}" placeholder="Enter Price" class="form-control" style="margin-top: 10px;" >
                                    </div>
                                </div>
                                @php
                                $j++;
                                @endphp
                                @endforeach

                                {{-- END Villa Home Size  --}}


                                {{-- Start Villa Color  --}}

                                @php $v=0; @endphp
                                <div class="mt-3">
                                @foreach ($getVillaColorWantWallsPainted as $data)
                                @php 
                                if(isset($data->price) && !empty($data->price)){
                                   $value =  $data->price;
                                }else{
                                    $value = 0;
                                }
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($v == 0)
                                        <label for="name"><b>Color</b></label>
                                        @endif
                                        <input type="hidden" id="villa_color_id" value="{{ $data->id }}" name="villa_color_id[]" > 
                                        <input type="hidden" id="colors_of_villa" value="{{ $data->flags_of_tab }}" name="colors_of_villa[]" > 
                                        <input type="hidden" id="types_of_tab_villa_color" value="{{ $data->types_of_tab }}" name="types_of_tab_villa_color[]" > 
                                        <input type="text" name="villa_colors[]" value="{{ $data->size_of_home }}" class="form-control" style="margin-top: 10px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        @if($v == 0)
                                        <label for="name"><b>Price</b></label>
                                        @endif
                                        <input type="text" name="villa_color_price[]" id="{{ $data->id }}" value="{{ $value }}" placeholder="Enter Price" class="form-control" style="margin-top: 10px;" >
                                    </div>
                                </div>
                                @php
                                $v++;
                                @endphp
                                @endforeach

                                {{-- END Villa Color  --}} 


                                {{-- Start Villa Home Furnish  --}}
                                @php $k=0; @endphp
                                <div class="mt-3">
                                @foreach ($getVillaHomeFurnishedPainted as $data)
                                @php 
                                if(isset($data->price) && !empty($data->price)){
                                    $value =  $data->price;
                                }else{
                                    $value = 0;
                                }
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        @if($k == 0)
                                        <label for="name"><b>Home Furnish</b></label>
                                        @endif
                                        <input type="hidden" id="villa_furnished_id" value="{{ $data->id }}" name="villa_furnished_id[]" > 
                                        <input type="hidden" id="villa_furnished_flg" value="{{ $data->flags_of_tab }}" name="villa_furnished_flg[]" > 

                                        <input type="hidden" id="types_of_villa_furnished" value="{{ $data->types_of_tab }}" name="types_of_villa_furnished[]" > 
                                        <input type="text" name="villa_home_furnish[]" value="{{ $data->size_of_home }}" class="form-control" style="margin-top: 10px;" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        @if($k == 0)
                                        <label for="name"><b>Price</b></label>
                                        @endif
                                        <input type="text" name="villa_home_furnish_price[]" id="{{$data->id}}" value="{{ $value }}" placeholder="Enter Price" class="form-control" style="margin-top: 10px;" >
                                    </div>
                                </div>
                                @php
                                $k++;
                                @endphp
                                @endforeach
                                {{-- END Villa Home Furnish  --}}
                                
                                
                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ url('/admin') }}"> Cancel</a>
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
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#painting-price_form').submit();
        }
    </script>
@stop

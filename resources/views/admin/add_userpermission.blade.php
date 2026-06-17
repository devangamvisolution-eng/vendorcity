@extends('admin.includes.Template')



@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Permission</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userpermission.index') }}">Permission</a></li>
                        <li class="breadcrumb-item active">Add Permission</li>
                    </ul>
                </div>
            </div>
        </div>



        <!-- /Page Header -->
        <div id="validate" class="alert alert-danger alert-dismissible fade show" style="display: none;">
            <span id="login_error"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">Basic Info</h4> -->
                        <form id="category_form" action="{{ route('userpermission.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">User Type</label>
                                    <input id="name" name="cname" type="text" class="form-control"
                                        placeholder="Enter User Type" value="{{old('cname')}}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                    @error('cname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">Permission Type</label>
                                    <select name="permission_type" id="permission_type" class="form-control form-select" multiple="multiple" >
                                        <option value="">Select Permission Type</option>
                                        {{-- <option value="1" {{ (collect(old('permission_type'))->contains('1')) ? 'selected' : '' }}>All</option>   --}}

                                        <option value="2" {{ (collect(old('permission_type'))->contains('2')) ? 'selected' : '' }}>Master</option>

                                        <option value="3" {{ (collect(old('permission_type'))->contains('3')) ? 'selected' : '' }}>Moving</option>   

                                        <option value="4" {{ (collect(old('permission_type'))->contains('4')) ? 'selected' : '' }}>Cleaning</option>  

                                        <option value="5" {{ (collect(old('permission_type'))->contains('5')) ? 'selected' : '' }}>User Management</option>    
                                        <option value="6" {{ (collect(old('permission_type'))->contains('6')) ? 'selected' : '' }}>Other</option>    
                                    </select>
                                    @error('permission_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <p class="form-error-text" id="permission_type_error" style="color: red; margin-top: 10px;"></p>
                                </div>

                               
                                <style>
                                    table,
                                    th,
                                    td {
                                        border: 1px solid black;
                                    }
                                </style>

                                    @php
                                    $groupedPermissions = [
                                        'master' => [],
                                        'moving' => [],
                                        'cleaning' => [],
                                        'usermanagement' => [],
                                        'other' => [],
                                    ];

                                    $masterItems = [4,5,11,12,21,25,14,35,70,71];
                                    $movingItems = [1,43,2,3,8,13,16,17,19,26,27,31];
                                    $cleaningItems = [8,16,17,28,29,37,40];
                                    $usermanagementItems = [6,7];

                                    foreach ($permission as $per_data) {
                                        $types = [];

                                        if (in_array($per_data->id, $masterItems)) {
                                            $groupedPermissions['master'][] = $per_data;
                                        } elseif (in_array($per_data->id, $movingItems)) {
                                            $groupedPermissions['moving'][] = $per_data;
                                        } elseif (in_array($per_data->id, $cleaningItems)) {
                                            $groupedPermissions['cleaning'][] = $per_data;
                                        } elseif (in_array($per_data->id, $usermanagementItems)) {
                                            $groupedPermissions['usermanagement'][] = $per_data;
                                        } else {
                                            $groupedPermissions['other'][] = $per_data;
                                        }
                                    }
                                    @endphp

                                <div id="permission_table" style="display: none;">
                                    @foreach ($groupedPermissions as $category => $permissions)
                                        @if (count($permissions) > 0)
                                            <div class="perm-group {{ $category }}" style="display: none;">
                                                <h4 class="mt-4 text-capitalize">{{ $category }} Permissions</h4>
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Feature</th>
                                                            <th>View</th>
                                                            <th>Add / Edit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($permissions as $per_data)
                                                            <tr>
                                                                <td>{{ $per_data->pname }}</td>
                                                                <td>
                                                                    <input type="checkbox" name="permission[]" value="{{ $per_data->id }}">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="add_edit_perm[]" value="{{ $per_data->id }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                             

                            </div>
                            <div class="text-end mt-4">
                                <a class="btn btn-primary" href="{{ route('userpermission.index') }}"> Cancel</a>
                                <button class="btn btn-primary mb-1" type="button" disabled id="spinner_button"
                                    style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter User Type");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#name_error').offset().top - 150
                }, 1000);
                return false;
            }
            var permission_type = jQuery("#permission_type").val();
            if (permission_type == '') {
                jQuery('#permission_type_error').html("Please Select Permission Type");
                jQuery('#permission_type_error').show().delay(0).fadeIn('show');
                jQuery('#permission_type_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#permission_type_error').offset().top - 150
                }, 1000);
                return false;
            }
            if ($('input[name="permission[]"]:checked').length == 0) {
                $('#perm_error').html("Please select at least one permission.");
                $('#perm_error').fadeIn().delay(3000).fadeOut();
                $('html, body').animate({
                    scrollTop: $('#perm_error').offset().top - 150
                }, 1000);
                e.preventDefault();
                return false;
            }
            $('#spinner_button').show();
            $('#submit_button').hide();
            $('#category_form').submit();
        }

        $("#permission_type").select2({
            placeholder: "Select a Permission Type" // Replace with your desired placeholder text
        });

    </script>

<script>
 $(document).ready(function () {
    let previousSelection = [];

    $('#permission_type').change(function () {
        let currentSelection = $(this).val() || [];

        // Find which values were removed
        let removedValues = previousSelection.filter(val => !currentSelection.includes(val));

        // Hide and clear only the removed groups
        removedValues.forEach(function (val) {
            switch (val) {
                case '2':
                    $('.master').hide().find('input[type="checkbox"]').prop('checked', false);
                    break;
                case '3':
                    $('.moving').hide().find('input[type="checkbox"]').prop('checked', false);
                    break;
                case '4':
                    $('.cleaning').hide().find('input[type="checkbox"]').prop('checked', false);
                    break;
                case '5':
                    $('.usermanagement').hide().find('input[type="checkbox"]').prop('checked', false);
                    break;
                case '6':
                    $('.other').hide().find('input[type="checkbox"]').prop('checked', false);
                    break;
            }
        });

        if (currentSelection.length > 0) {
            $('#permission_table').show();

            // If "All" selected, show all groups
            if (currentSelection.includes('1')) {
                $('.perm-group').show();
            } else {
                $('.perm-group').hide(); // Hide all
                currentSelection.forEach(function (val) {
                    switch (val) {
                        case '2':
                            $('.master').show();
                            break;
                        case '3':
                            $('.moving').show();
                            break;
                        case '4':
                            $('.cleaning').show();
                            break;
                        case '5':
                            $('.usermanagement').show();
                            break;
                        case '6':
                            $('.other').show();
                            break;
                    }
                });
            }
        } else {
            $('#permission_table').hide();
        }

        // Save current selection for next change
        previousSelection = currentSelection;
    });
});


</script>


    




@stop

@extends('admin.includes.Template')
@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Edit Permission</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userpermission.index') }}">Permission</a></li>
                        <li class="breadcrumb-item active">Edit Permission</li>
                    </ul>
                </div>
            </div>
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
                        <form id="category_form" action="{{ route('userpermission.update', $user_permission->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group">
                                    <label for="name">User Type</label>
                                    <input id="name" name="cname" type="text" class="form-control"
                                        placeholder="Enter User Type" value="{{ $user_permission->cname }}" />
                                    <p class="form-error-text" id="name_error" style="color: red; margin-top: 10px;"></p>
                                    @error('cname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @php
                                    $selectedPermissions = old('permission_type') ?? explode(',', $user_permission->permission_type);
                                @endphp

                                <div class="form-group">
                                    <label for="name">Permission Type</label>
                                    <select name="permission_type[]" id="permission_type" class="form-control form-select" multiple="multiple">
                                        <option value="">Select Permission Type</option>
                                        {{-- <option value="1" {{ in_array('1', $selectedPermissions) ? 'selected' : '' }}>All</option> --}}
                                        <option value="2" {{ in_array('2', $selectedPermissions) ? 'selected' : '' }}>Master</option>
                                        <option value="3" {{ in_array('3', $selectedPermissions) ? 'selected' : '' }}>Moving</option>
                                        <option value="4" {{ in_array('4', $selectedPermissions) ? 'selected' : '' }}>Cleaning</option>
                                        <option value="5" {{ in_array('5', $selectedPermissions) ? 'selected' : '' }}>User Management</option>
                                        <option value="6" {{ in_array('6', $selectedPermissions) ? 'selected' : '' }}>Other</option>
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
                                    $movingItems = [1,43,2,3,8,13,16,17,19,26,27,36];
                                    $cleaningItems = [8,16,17,22,28,29,37,40];
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

                                    @php
                                    $selectedViewPermissions = explode(',', $user_permission->permission ?? '');
                                    $selectedEditPermissions = explode(',', $user_permission->editperm ?? '');
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
                                                                    <input type="checkbox" name="permission[]" value="{{ $per_data->id }}"
                                                                        {{ in_array($per_data->id, $selectedViewPermissions) ? 'checked' : '' }}>
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" name="add_edit_perm[]" value="{{ $per_data->id }}"
                                                                        {{ in_array($per_data->id, $selectedEditPermissions) ? 'checked' : '' }}>
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
    <!-- <script>
        $(function()
            {
                $("#name").keyup(function()
                    {
                        var Text = $(this).val();
                        Text = Text.toLowerCase();
                        Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
                        $("#page_url").val(Text);
                    });
            });
    </script> -->
    <script>
        function category_validation()
        {
            var name = jQuery("#name").val();
            if (name == '') {
                jQuery('#name_error').html("Please Enter User Type");
                jQuery('#name_error').show().delay(0).fadeIn('show');
                jQuery('#name_error').show().delay(2000).fadeOut('show');
                $('html, body').animate({
                    scrollTop: $('#conf_password').offset().top - 150
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
        document.addEventListener('DOMContentLoaded', function () {
        const permissionTypeSelect = document.getElementById('permission_type');
        const permissionTable = document.getElementById('permission_table');

        function showPermissionGroups() {
            const selected = Array.from(permissionTypeSelect.selectedOptions).map(opt => opt.value);
            
            // Show main table wrapper
            permissionTable.style.display = selected.length > 0 ? 'block' : 'none';

            // Hide all groups first
            document.querySelectorAll('.perm-group').forEach(group => {
                group.style.display = 'none';
            });
            

            // Show selected groups
            selected.forEach(val => {
                switch(val) {
                    case '2': document.querySelector('.perm-group.master').style.display = 'block'; break;
                    case '3': document.querySelector('.perm-group.moving').style.display = 'block'; break;
                    case '4': document.querySelector('.perm-group.cleaning').style.display = 'block'; break;
                    case '5': document.querySelector('.perm-group.usermanagement').style.display = 'block'; break;
                    case '6': document.querySelector('.perm-group.other').style.display = 'block'; break;
                    case '1': // All - show everything
                        document.querySelectorAll('.perm-group').forEach(group => {
                            group.style.display = 'block';
                        });
                        break;
                }
            });
        }

        // On load
        showPermissionGroups();

        // On change
        permissionTypeSelect.addEventListener('change', showPermissionGroups);
    });

    $(document).ready(function () {
    let previousSelected = $('#permission_type').val() || [];

    $('#permission_type').change(function () {
        let selectedValues = $(this).val() || [];

        // Detect removed values
        let removedValues = previousSelected.filter(val => !selectedValues.includes(val));

        // Deselect checkboxes for removed permission groups
        removedValues.forEach(function (val) {
            switch (val) {
                case '2':
                    $('.perm-group.master input[type="checkbox"]').prop('checked', false);
                    break;
                case '3':
                    $('.perm-group.moving input[type="checkbox"]').prop('checked', false);
                    break;
                case '4':
                    $('.perm-group.cleaning input[type="checkbox"]').prop('checked', false);
                    break;
                case '5':
                    $('.perm-group.usermanagement input[type="checkbox"]').prop('checked', false);
                    break;
                case '6':
                    $('.perm-group.other input[type="checkbox"]').prop('checked', false);
                    break;
                case '1':
                    // Deselect all if "All" was removed
                    $('.perm-group input[type="checkbox"]').prop('checked', false);
                    break;
            }
        });

        // Show/hide permission table and groups
        if (selectedValues.length > 0) {
            $('#permission_table').show();
            $('.perm-group').hide();

            if (selectedValues.includes('1')) {
                $('.perm-group').show();
            } else {
                selectedValues.forEach(function (val) {
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

        // Update previousSelected
        previousSelected = selectedValues;
    });
});


</script>

@stop

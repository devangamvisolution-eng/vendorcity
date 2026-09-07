@extends('admin.includes.Template')
@section('content')
    @php
        $userId = Auth::id();
        $get_user_data = Helper::get_user_data($userId);
        $get_permission_data = Helper::get_permission_data($get_user_data->role_id);
        $edit_perm = [];
        if ($get_permission_data->editperm != '') {
            $edit_perm = $get_permission_data->editperm;
            $edit_perm = explode(',', $edit_perm);
        }
    @endphp
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">CMS</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">cms</li>
                    </ul>
                </div>
                @if (in_array('10', $edit_perm))
                    <div class="col-auto">
                        <a class="btn btn-primary me-1" href="{{ route('cms.create') }}">
                            <i class="fas fa-plus"></i> Add CMS
                        </a>
                        {{-- <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                        <i class="fas fa-filter"></i> Filter
                    </a> --}}
                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_cms();">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <strong>Success!</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="{{ route('delete_cms') }}" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Select</th>
                                            <th>Name</th>
                                            @if (in_array('10', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($cms_data != '' && count($cms_data) > 0)
                                            @foreach ($cms_data as $data)
                                                <tr>
                                                    <td>
                                                        <input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                            type="checkbox" class="minimal-red"
                                                            style="height: 20px;width: 20px;border-radius: 0px;cms: red;">
                                                    </td>
                                                    <td>
                                                        {{ $data->name }}
                                                    </td>
                                                    @if (in_array('10', $edit_perm))
                                                        <td class="text-right">
                                                            <a class="btn btn-primary"
                                                                href="{{ route('cms.edit', $data->id) }}"><i
                                                                    class="far fa-edit"></i></a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                    </tbody>
                                @else
                                    <tr>
                                        <td class="text-center" colspan="8">{{ 'No Data Found !' }}</td>
                                    </tr>
                                    @endif
                                </table>
                                <div class="d-flex justify-c mt-2" style="float: right;">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                    <button type="button" class="btn btn-primary" onclick="form_sub();">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->
    <!-- Select one record Category Modal -->
    <div class="modal custom-modal fade" id="select_one_record" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-text text-center">
                        <h3>Please select at least one record to delete</h3>
                        <!-- <p>Are you sure want to delete?</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Select one record Category Modal -->
    <script>
        function delete_cms() {
            // alert('test');
            var checked = $("#form input:checked").length > 0;
            if (!checked) {
                $('#select_one_record').modal('show');
            } else {
                $('#delete_model').modal('show');
            }
        }

        function form_sub() {
            $('#form').submit();
        }
    </script>
    <script>
        $(document).ready(function() {
            // Check if the DataTable instance already exists
            if ($.fn.DataTable.isDataTable('#example')) {
                // Destroy the existing DataTable before reinitializing
                $('#example').DataTable().destroy();
            }
            // Initialize DataTable with the new options
            $('#example').dataTable({
                "searching": true
            });
        });
    </script>
@stop

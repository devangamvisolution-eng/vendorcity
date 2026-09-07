@extends('admin.includes.Template')

@section('content')

    @php

        $userId = Auth::id();

        $get_user_data = Helper::get_user_data($userId);

        // $get_permission_data = Helper::get_permission_data($get_user_data->role_id);

        // $edit_perm = [];

        // if ($get_permission_data->editperm != '') {
        //     $edit_perm = $get_permission_data->editperm;

        //     $edit_perm = explode(',', $edit_perm);
        // }
        $roleIds = explode(',', $get_user_data->role_id);

			$edit_perm = [];

			foreach ($roleIds as $roleId) {
				$roleId = trim($roleId); // Clean any spaces
				
				$get_permission_data = Helper::get_permission_data($roleId);

				if (
					is_object($get_permission_data) &&
					property_exists($get_permission_data, 'editperm') &&
					$get_permission_data->editperm != ''
				) {
					$perms = explode(',', $get_permission_data->editperm);
					$edit_perm = array_merge($edit_perm, $perms); // Combine permissions
				}
			}

			// Optional: remove duplicates and reset array keys
			$edit_perm = array_values(array_unique($edit_perm));


    @endphp



    <div class="content container-fluid">





        <!-- Page Header -->

        <div class="page-header">

            <div class="row align-items-center">

                <div class="col">

                    <h3 class="page-title">Blog</h3>

                    <ul class="breadcrumb">

                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>

                        </li>

                        <li class="breadcrumb-item active">Blog</li>

                    </ul>

                </div>



                @if (in_array('21', $edit_perm))
                    <div class="col-auto">



                        <a class="btn btn-primary me-1" href="{{ route('blog.create') }}">

                            <i class="fas fa-plus"></i> Add Blog

                        </a>

                        <a class="btn btn-danger me-1" href="javascript:void('0');" onclick="delete_blog();">

                            <i class="fas fa-trash"></i> Delete

                        </a>

                        <!--  <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">

                                                                                                 <i class="fas fa-filter"></i> Filter

                                                                                                 </a> -->

                    </div>
                @endif





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

            <div class="col-sm-12">



                <div class="card card-table">

                    <div class="card-body">

                        <form id="form" action="{{ route('delete_blog') }}" enctype="multipart/form-data">

                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">

                            @csrf

                            <div class="table-responsive">

                                <table class="table table-center table-hover datatable" id="example">

                                    <thead class="thead-light">

                                        <tr>

                                            <th>Select</th>
                                            <th>Blog Category</th>
                                            <th>Title</th>
                                            <th>Blog url</th>
                                            <th>Date</th>
                                            <th>Service</th>
                                            <th>Sub Service</th>
                                            <th>Image</th>

                                            @if (in_array('21', $edit_perm))
                                                <th class="text-right">Actions</th>
                                            @endif



                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($blog_data as $data)
                                            <tr>

                                                <td><input name="selected[]" id="selected[]" value="{{ $data->id }}"
                                                        type="checkbox" class="minimal-red"
                                                        style="height: 20px;width: 20px;border-radius: 0px;color: red;">

                                                </td>
                                                    
                                                <td>@if($data->blog_category !="")
                                                    {!! Helper::blog_categoryname($data->blog_category) !!}
                                                @else
                                                    {{"-"}}
                                                    @endif
                                                    </td>

                                                <td>{{ $data->title }}</td>
                                                <td>{{ $data->blog_url }}</td>

                                                <td>{{ $data->date }}</td>

                                                <td>{!! Helper::servicename($data->service) !!}</td>

                                                <td>{!! Helper::subservicename($data->subservice) !!}</td>


                                                <td><img src="{{ url('public/upload/blog/small/' . $data->image) }}"width="50px"
                                                        height="50px"></td>





                                                @if (in_array('21', $edit_perm))
                                                    <td class="text-right">

                                                        <a class="btn btn-primary"
                                                            href="{{ route('blog.edit', $data->id) }}"><i
                                                                class="far fa-edit"></i></a>

                                                    </td>
                                                @endif



                                            </tr>
                                        @endforeach





                                    </tbody>

                                </table>

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



    <!-- set order Modal -->

    <div class="modal custom-modal fade" id="set_order_model" role="dialog">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-body">

                    <div class="modal-text text-center">

                        <h3>Are you sure you want to Set order of blog</h3>

                        <input type="hidden" name="set_order_val" id="set_order_val" value="">

                        <input type="hidden" name="set_order_id" id="set_order_id" value="">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                        <button type="button" class="btn btn-primary" onclick="updateorder();">Yes</button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- /set orderModal -->

    <script>
        function delete_blog() {

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
        if ($.fn.DataTable.isDataTable('#example')) {
            $('#example').DataTable().destroy();
        }

        $(document).ready(function() {
            $('#example').dataTable({
                "searching": true
            });
        })
    </script>

@stop

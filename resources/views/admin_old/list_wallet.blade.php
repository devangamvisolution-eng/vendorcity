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
                    <h3 class="page-title">Wallet</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Wallet</li>
                    </ul>
                </div>
                {{-- @if (in_array('5', $edit_perm)) --}}
                <div class="col-auto">
                    <a class="btn btn-primary me-1" href="{{ route('wallet.create') }}">
                        <i class="fas fa-plus"></i> Add Wallet
                    </a>


                </div>
                {{-- @endif --}}
            </div>
        </div>

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
            @php

               $vendor_data = Auth::user();
                // $approve_amount = DB::table('wallets')
                //     ->where('vendors_id', $vendor_data->id)
                //     ->where('add_deduct', 0)
                //     ->where('status', 1)
                //     ->sum('price');

                // $deduct_amount = DB::table('wallets')
                //     ->where('vendors_id', $vendor_data->id)
                //     ->where('status', 0)
                //     ->where('add_deduct', 1)
                //     ->sum('price');

                    $vendor_data = DB::table('users')->where('id',$vendor_data->id)->first();

                // $total_amount = $approve_amount - $deduct_amount;

            @endphp


            <div class="col-xl-4 col-sm-6 col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header text-center" style="display:block">
                            <div class="dash-count">
                                <div class="dash-title"><a href=""
                                        style=" margin-bottom: 25px;display: inline-block;">Total Amount</a>
                                </div>
                                <div class="dash-counts">
                                    <p>{{ $vendor_data->wallet_amount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <form id="form" action="" enctype="multipart/form-data">
                            <INPUT TYPE="hidden" NAME="hidPgRefRan" VALUE="<?php echo rand(); ?>">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th>Transaction Id</th>
                                            <th>Price</th>
                                            <th>Payment Type</th>
                                            <th>Reason for Deduction</th>
                                            <th>Payment Status</th>
                                            <th>Payment ID</th>
                                            <th>Add/Deduct</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wallet_data as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $data->transaction_id }}</td>
                                                <td>{{ $data->price }}</td>
                                                <td>
                                                    @if ($data->payment === 0)
                                                        {{ 'Cash' }}
                                                    @elseif ($data->payment === 1)
                                                        {{ 'Online' }}
                                                    @elseif ($data->payment === 3)
                                                        {{ 'Refund' }}
                                                    @elseif ($data->payment === 4)
                                                        {{ 'Deduct' }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                <td>{{$data->deduct_reason}}</td>
                                                <td>{{ $data->payment_status }}</td>
                                                <td>{{ $data->payment_id }}</td>

                                                <td>
                                                    @if ($data->add_deduct === 0)
                                                        {{ 'Add' }}
                                                    @elseif (($data->add_deduct === 1) || ($data->add_deduct === 0 && $data->payment === 4))
                                                        {{ 'Deduct' }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->add_deduct == 0)
                                                        @if ($data->status === 0)
                                                            <span
                                                                class="badge badge-pill bg-danger-light">{{ 'Not Approved' }}</span>
                                                        @elseif ($data->status === 1)
                                                            <span class="badge badge-pill bg-success-light">
                                                                {{ 'Approved' }}</span>
                                                        @else
                                                            {{ '-' }}
                                                        @endif
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $data->created_at->format('d-m-Y') }}
                                                </td>

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

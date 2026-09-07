@extends('admin.includes.Template')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Multiple Days Discounts</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Multiple Days Discounts</li>
                    </ul>
                </div>
                <div class="col-auto">
                    <a href="{{ route('cleaning_multiple_days_discounts.create') }}" class="btn btn-primary me-1">
                        <i class="fas fa-plus"></i> Add Discount
                    </a>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-center table-hover datatable" id="example">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Number of Days</th>
                                        <th>Discount %</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discounts as $key => $discount)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $discount->number_of_days }} Days</td>
                                            <td>{{ $discount->discount_value }}%</td>
                                            <td class="text-right">
                                                <a href="{{ route('cleaning_multiple_days_discounts.edit', $discount->id) }}" class="btn btn-sm bg-success-light me-2">
                                                    <i class="far fa-edit me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('cleaning_multiple_days_discounts.destroy', $discount->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this discount?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-danger-light">
                                                        <i class="far fa-trash-alt me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.includes.Template')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Add Multiple Days Discount</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cleaning_multiple_days_discounts.index') }}">Discounts</a></li>
                        <li class="breadcrumb-item active">Add Discount</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cleaning_multiple_days_discounts.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Number of Days</label>
                                        <input type="number" class="form-control" name="number_of_days" required min="2" max="7" placeholder="e.g. 2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Discount Value (%)</label>
                                        <input type="number" class="form-control" name="discount_value" required min="0" step="0.01" placeholder="e.g. 10">
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('cleaning_multiple_days_discounts.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
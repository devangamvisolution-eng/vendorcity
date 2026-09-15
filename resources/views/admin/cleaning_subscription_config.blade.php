@extends('admin.includes.Template')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Cleaning Subscription Configuration</h3>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <!-- Durations -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h4>Manage Durations (Hours)</h4></div>
                    <div class="card-body">
                        <form action="{{ route('admin.cleaning_subscription_durations.store') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="number" name="hours" class="form-control" placeholder="Hours (e.g. 2)" required>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Hours</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                @foreach($durations as $d)
                                <tr>
                                    <td>{{ $d->hours }}</td>
                                    <td>
                                        <form action="{{ route('admin.cleaning_subscription_durations.delete', $d->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Frequencies -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h4>Manage Frequencies</h4></div>
                    <div class="card-body">
                        <form action="{{ route('admin.cleaning_subscription_frequencies.store') }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="number" name="visits_per_week" class="form-control" placeholder="Visits/Week (e.g. 1)" required>
                                <input type="text" name="label" class="form-control" placeholder="Label (e.g. 1 visit per week)" required>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Visits/Week</th><th>Label</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                @foreach($frequencies as $f)
                                <tr>
                                    <td>{{ $f->visits_per_week }}</td>
                                    <td>{{ $f->label }}</td>
                                    <td>
                                        <form action="{{ route('admin.cleaning_subscription_frequencies.delete', $f->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Packages -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header"><h4>Manage Packages</h4></div>
                    <div class="card-body">
                        <form action="{{ route('admin.cleaning_subscription_packages.store') }}" method="POST" class="mb-3 row">
                            @csrf
                            <div class="col-md-3">
                                <input type="text" name="name" class="form-control" placeholder="Name (e.g. 1 Month Package)" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="validity_months" class="form-control" placeholder="Validity (Months)" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="discount_percentage" class="form-control" placeholder="Discount %" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Add Package</button>
                            </div>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Name</th><th>Validity (Months)</th><th>Discount %</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                @foreach($packages as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->validity_months }}</td>
                                    <td>{{ $p->discount_percentage }}%</td>
                                    <td>
                                        <form action="{{ route('admin.cleaning_subscription_packages.delete', $p->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header"><h4>Manage Pricing Rule (Price/Hour)</h4></div>
                    <div class="card-body">
                        <form action="{{ route('admin.cleaning_subscription_pricing.store') }}" method="POST" class="mb-3 row">
                            @csrf
                            <div class="col-md-3">
                                <select name="duration_id" class="form-control" required>
                                    <option value="">Select Duration</option>
                                    @foreach($durations as $d)
                                        <option value="{{ $d->id }}">{{ $d->hours }} Hours</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="frequency_id" class="form-control" required>
                                    <option value="">Select Frequency</option>
                                    @foreach($frequencies as $f)
                                        <option value="{{ $f->id }}">{{ $f->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="package_id" class="form-control" required>
                                    <option value="">Select Package</option>
                                    @foreach($packages as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" step="0.01" name="price_per_hour" class="form-control" placeholder="Price/Hour" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Add Rule</button>
                            </div>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Duration</th>
                                    <th>Frequency</th>
                                    <th>Package</th>
                                    <th>Price/Hour</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pricings as $pr)
                                <tr>
                                    <td>{{ $pr->duration ? $pr->duration->hours . ' Hours' : 'N/A' }}</td>
                                    <td>{{ $pr->frequency ? $pr->frequency->label : 'N/A' }}</td>
                                    <td>{{ $pr->package ? $pr->package->name : 'N/A' }}</td>
                                    <td>{{ $pr->price_per_hour }}</td>
                                    <td>
                                        <form action="{{ route('admin.cleaning_subscription_pricing.delete', $pr->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
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

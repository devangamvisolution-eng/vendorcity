@extends('admin.includes.Template')
@section('content')

    <style>
        .premium-card { border: none; border-radius: 12px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06); background: #fff; margin-bottom: 24px; padding: 20px; }
        .premium-table { border-collapse: separate; border-spacing: 0; width: 100%; border: 1px solid #e9ecef; }
        .premium-table thead th { background-color: #428df5; color: #ffffff; font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; border-bottom: 2px solid #eef2f5; padding: 16px; white-space: nowrap; border-right: 1px solid rgba(255, 255, 255, 0.3); }
        .premium-table thead th:last-child { border-right: none; }
        .premium-table tbody td { padding: 16px; vertical-align: middle; color: #555; border-bottom: 1px solid #e9ecef; border-right: 1px solid #e9ecef; font-size: 14px; transition: background-color 0.2s ease; }
        .premium-table tbody td:last-child { border-right: none; }
        .premium-table tbody tr:hover td { background-color: #eaeaea; }
        .premium-table tbody tr:hover td:first-child { box-shadow: inset 3px 0 0 #ffc107; }
        .premium-table tbody tr:hover td:last-child { box-shadow: inset -3px 0 0 #ffc107; }
        .btn-premium { border-radius: 8px; font-weight: 500; padding: 10px 20px; transition: all 0.3s; border: none; display: inline-flex; align-items: center; gap: 6px; }
        .btn-premium:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3); }
    </style>

<div class='content container-fluid'><div class='page-header'><div class='row align-items-center'><div class='col'><h3 class='page-title'>Edit CleaningSubscriptionPricing</h3></div><div class='col-auto'><a class='btn btn-primary btn-premium' href="{{ route('cleaning-subscription-pricing.index') }}">Back</a></div></div></div><div class='row'><div class='col-md-12'><div class='card premium-card'><div class='card-body'><form action="{{ route('cleaning-subscription-pricing.update', $data->id) }}" method='POST'>@csrf @method('PUT') <div class='row'><div class='col-md-6 mb-3'>
    <label>Duration</label>
    <select name='duration_id' class='form-control' required>
        <option value="">Select Duration</option>
        @foreach($durations as $duration)
            <option value="{{ $duration->id }}" {{ $data->duration_id == $duration->id ? 'selected' : '' }}>{{ $duration->hours }} Hours</option>
        @endforeach
    </select>
</div>
<div class='col-md-6 mb-3'>
    <label>Frequency</label>
    <select name='frequency_id' class='form-control' required>
        <option value="">Select Frequency</option>
        @foreach($frequencies as $frequency)
            <option value="{{ $frequency->id }}" {{ $data->frequency_id == $frequency->id ? 'selected' : '' }}>{{ $frequency->label }}</option>
        @endforeach
    </select>
</div>
<div class='col-md-6 mb-3'>
    <label>Package</label>
    <select name='package_id' class='form-control' required>
        <option value="">Select Package</option>
        @foreach($packages as $package)
            <option value="{{ $package->id }}" {{ $data->package_id == $package->id ? 'selected' : '' }}>{{ $package->name }}</option>
        @endforeach
    </select>
</div>
<div class='col-md-6 mb-3'>
    <label>Price per hour</label>
    <input type='number' name='price_per_hour' value="{{ $data->price_per_hour }}" class='form-control' required>
</div>
<div class='col-md-4 mb-3'>
    <label>Set Order</label>
    <input type='number' name='set_order' value='{{ $data->set_order }}' class='form-control' required>
</div>
<div class='col-md-4 mb-3'>
    <label>Active for Web</label>
    <select name='is_active_web' class='form-control' required>
        <option value='1' {{ $data->is_active_web == 1 ? 'selected' : '' }}>Active</option>
        <option value='0' {{ $data->is_active_web == 0 ? 'selected' : '' }}>Deactive</option>
    </select>
</div>
<div class='col-md-4 mb-3'>
    <label>Active for App</label>
    <select name='is_active_app' class='form-control' required>
        <option value='1' {{ $data->is_active_app == 1 ? 'selected' : '' }}>Active</option>
        <option value='0' {{ $data->is_active_app == 0 ? 'selected' : '' }}>Deactive</option>
    </select>
</div>
</div><button class='btn btn-primary btn-premium mt-3'>Update</button></form></div></div></div></div></div>
@endsection
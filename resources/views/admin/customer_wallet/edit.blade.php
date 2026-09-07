@extends('admin.includes.Template')

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Deduct Wallet Money</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer-wallet.index') }}">Customer Wallets</a></li>
                    <li class="breadcrumb-item active">Deduct Wallet Money</li>
                </ul>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Error!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('customer-wallet.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Select Customer <span class="text-danger">*</span></label>
                                    <select name="customer_id" class="form-control select2" required>
                                        <option value="">Select a customer...</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Amount to Deduct (AED) <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control" required min="1" step="0.01" placeholder="Enter amount">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Note / Reason (Optional)</label>
                                    <textarea name="note" class="form-control" rows="3" placeholder="e.g. Correcting a mistake, penalty..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('customer-wallet.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-danger">Deduct Money</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('.select2').length > 0) {
            $('.select2').select2({
                placeholder: "Select a customer...",
                allowClear: true
            });
        }
    });
</script>
@stop

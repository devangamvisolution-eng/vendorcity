@extends('admin.includes.Template')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .detail-header-bg { background: linear-gradient(135deg, #605bff 0%, #3f39cc 100%); padding: 40px 20px 100px; margin: -25px -25px 0 -25px; border-radius: 0 0 30px 30px; }
    .main-content-wrapper { margin-top: -70px; }
    .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); }
    .label-caps { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 1px; }
    .price-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed #eee; }
    .price-row.total { border-bottom: none; background: #605bff; color: white; border-radius: 12px; padding: 15px; margin-top: 15px; }
</style>

@section('content')
<div class="content container-fluid">
    <div class="detail-header-bg">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="text-white mb-1"><i class="bi bi-file-earmark-text me-2"></i>Manpower Order #{{ $order->format_order_id }}</h3>
                <p class="text-white-50 mb-0">Placed on {{ date('d M Y, h:i A', strtotime($order->created_at ?? ($orderItem->cdate ?? date('Y-m-d H:i:s')))) }}</p>
            </div>
            <a href="{{ route('manpower-orders.index') }}" class="btn btn-light rounded-pill px-4"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
        </div>
    </div>

    <div class="main-content-wrapper row">
        <!-- Main Details -->
        <div class="col-xl-8">
            <div class="card glass-card border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-4"><i class="bi bi-person-badge text-primary me-2"></i>Customer Information</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Customer Name</p>
                            <span class="fw-bold text-dark">{{ $customer->name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Email</p>
                            <span class="fw-bold text-dark">{{ $customer->email ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Phone</p>
                            <span class="fw-bold text-dark">{{ $customer->mobile ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card glass-card border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-4"><i class="bi bi-box-seam text-primary me-2"></i>Service Details</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Service</p>
                            <span class="fw-bold text-dark">{{ $service->servicename ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Subservice</p>
                            <span class="fw-bold text-dark">{{ $subservice->subservicename ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Service Date</p>
                            <span class="fw-bold text-dark">
                                @if($orderItem && $orderItem->bookingyear)
                                    {{ date('d M Y', strtotime($orderItem->bookingyear.'-'.$orderItem->month.'-'.$orderItem->bookingdate)) }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Time Slot</p>
                            <span class="fw-bold text-dark">{{ $orderItem->time_slot ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    <h5 class="card-title fw-bold text-dark mb-3"><i class="bi bi-geo-alt text-primary me-2"></i>Location Details</h5>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <p class="label-caps mb-1">City</p>
                            <span class="fw-bold text-dark">{{ $orderItem->city ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="label-caps mb-1">Area</p>
                            <span class="fw-bold text-dark">{{ $orderItem->area ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4">
                            <p class="label-caps mb-1">Address Type</p>
                            <span class="fw-bold text-dark">{{ ucfirst($orderItem->address_type ?? 'N/A') }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Building/Street</p>
                            <span class="fw-bold text-dark">{{ $orderItem->building_street_no ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <p class="label-caps mb-1">Apartment/Villa No</p>
                            <span class="fw-bold text-dark">{{ $orderItem->apartment_villa_no ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    <h5 class="card-title fw-bold text-dark mb-3"><i class="bi bi-people text-primary me-2"></i>Manpower Requirements</h5>
                    <div class="row g-4">
                        @if(!empty($orderItem->manpower_service_required))
                            <div class="col-md-6">
                                <p class="label-caps mb-1">Service Required</p>
                                <span class="fw-bold text-dark">{{ $orderItem->manpower_service_required }}</span>
                            </div>
                        @endif
                        @if(!empty($orderItem->manpower_workers_required))
                            <div class="col-md-6">
                                <p class="label-caps mb-1">Number of Workers</p>
                                <span class="fw-bold text-dark">{{ $orderItem->manpower_workers_required }}</span>
                            </div>
                        @endif
                        @if(!empty($orderItem->manpower_duration))
                            <div class="col-md-6">
                                <p class="label-caps mb-1">Duration / Per Day</p>
                                <span class="fw-bold text-dark">{{ $orderItem->manpower_duration }}</span>
                            </div>
                        @endif
                        @if(!empty($orderItem->manpower_start_date))
                            <div class="col-md-6">
                                <p class="label-caps mb-1">Start Date</p>
                                <span class="fw-bold text-dark">{{ $orderItem->manpower_start_date }}</span>
                            </div>
                        @endif
                        @if(!empty($orderItem->manpower_end_date))
                            <div class="col-md-6">
                                <p class="label-caps mb-1">End Date</p>
                                <span class="fw-bold text-dark">{{ $orderItem->manpower_end_date }}</span>
                            </div>
                        @endif
                        @if(!empty($orderItem->manpower_job_description))
                            <div class="col-12">
                                <p class="label-caps mb-1">Job Description / Requirements</p>
                                <span class="fw-bold text-dark">{{ $orderItem->manpower_job_description }}</span>
                            </div>
                        @endif
                        @if(!empty($orderItem->manpower_additional_notes))
                            <div class="col-12">
                                <p class="label-caps mb-1">Additional Notes</p>
                                <span class="fw-bold text-dark">{{ $orderItem->manpower_additional_notes }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="col-xl-4">
            <div class="card glass-card border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-4">Assignments & Status</h5>
                    
                    <div class="mb-4">
                        <p class="label-caps mb-1">Status</p>
                        @if($order->order_status == 'P')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                        @elseif($order->order_status == 'C')
                            <span class="badge bg-danger px-3 py-2 rounded-pill">Cancelled</span>
                        @elseif($order->order_status == 'CO')
                            <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $order->order_status }}</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <p class="label-caps mb-1">Salesperson</p>
                        <div class="d-flex align-items-center mt-2">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $salesperson->name ?? 'Unassigned' }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="label-caps mb-1">Vendor</p>
                        <div class="d-flex align-items-center mt-2">
                            <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $vendor->name ?? 'Unassigned' }}</h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card glass-card border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold text-dark mb-4">Payment Summary</h5>
                    <div class="price-row">
                        <span class="text-muted">Payment Mode</span>
                        <span class="fw-bold text-dark">
                            @if(isset($order->paymentmode) && ($order->paymentmode == 'ONLINE' || $order->paymentmode == '1'))
                                <span class="badge bg-primary">Online</span>
                            @else
                                <span class="badge bg-secondary">Cash on Delivery</span>
                            @endif
                        </span>
                    </div>
                    <div class="price-row mt-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold text-dark">AED {{ number_format($order->sub_total, 2) }}</span>
                    </div>
                    @if(isset($order->date_charge) && $order->date_charge > 0)
                    <div class="price-row">
                        <span class="text-muted">Date Charge</span>
                        <span class="fw-bold text-dark">AED {{ number_format($order->date_charge, 2) }}</span>
                    </div>
                    @endif
                    @if(isset($order->timing_charge) && $order->timing_charge > 0)
                    <div class="price-row">
                        <span class="text-muted">Timing Charge</span>
                        <span class="fw-bold text-dark">AED {{ number_format($order->timing_charge, 2) }}</span>
                    </div>
                    @endif
                    @if(isset($order->service_fee) && $order->service_fee > 0)
                    <div class="price-row">
                        <span class="text-muted">Service Fee</span>
                        <span class="fw-bold text-dark">AED {{ number_format($order->service_fee, 2) }}</span>
                    </div>
                    @endif
                    @if(isset($order->cod_charge) && $order->cod_charge > 0)
                    <div class="price-row">
                        <span class="text-muted">COD Charge</span>
                        <span class="fw-bold text-dark">AED {{ number_format($order->cod_charge, 2) }}</span>
                    </div>
                    @endif
                    @if(isset($order->vat_charge) && $order->vat_charge > 0)
                    <div class="price-row">
                        <span class="text-muted">VAT Charge</span>
                        <span class="fw-bold text-dark">AED {{ number_format($order->vat_charge, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="price-row total mt-3">
                        <span class="fw-bold mb-0">Total Amount</span>
                        <span class="fw-bold mb-0 fs-5">AED {{ number_format($order->order_total ?? $order->sub_total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

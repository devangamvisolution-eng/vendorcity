<select class="form-select form-select-sm mb-1 fw-bold" style="font-size: 12px;" onchange="order_status_change({{ $orders->order_id }}, this)">
    <option value="BK" {{ $orders->order_status === 'BK' ? 'selected' : '' }}>Booking Requested</option>
    <option value="BC" {{ in_array($orders->order_status, ['BC', 'P', 'PA']) ? 'selected' : '' }}>Booking Confirmed</option>
    <option value="OTW" {{ $orders->order_status === 'OTW' ? 'selected' : '' }}>On the way</option>
    <option value="IP" {{ $orders->order_status === 'IP' ? 'selected' : '' }}>In progress</option>
    <option value="CO" {{ $orders->order_status === 'CO' ? 'selected' : '' }}>Booking Completed</option>
    <option value="CL" {{ $orders->order_status === 'CL' ? 'selected' : '' }}>Booking Cancelled</option>
    <option value="UP" {{ $orders->order_status === 'UP' ? 'selected' : '' }}>Unpaid</option>
</select>

<div class="d-flex align-items-center">
    @if (isset($orders->items[0]))
        <input type="text" value="{{ $orders->items[0]->subservice_booking_percentage }}" onchange="updateorder_booking_percentage(this.value, '{{ $orders->items[0]->id }}');" class="form-control form-control-sm text-center" style="width: 45px; height: 22px; font-size: 11px;">
        <span class="ms-1 small text-muted">Comm %</span>
    @endif
</div>

<div class="d-flex flex-column align-items-center justify-content-center gap-1 text-center">
    @php
        $vendorName = !empty($orders->vendor_id) ? Helper::vendorsname($orders->vendor_id) : '';
    @endphp

    @if ($orders->payment_status == 'Success' || $orders->payment_status == 'paid')
        @if (isset($orders->items[0]) && $orders->items[0]->service_id == 50)
            <button type="button" class="btn-utility"
                onclick="assign_vendor_car('{{ $orders->order_id }}', '{{ $orders->vendor_id }}'); event.preventDefault();"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Vendor car">
                <i class="fas fa-user {{ !empty($orders->vendor_id) ? 'text-success' : '' }}"></i>
            </button>
        @else
            <button type="button" class="btn-utility"
                onclick="assign_vendor('{{ $orders->order_id }}', '{{ $orders->vendor_id }}'); event.preventDefault();"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Vendor">
                <i class="fas fa-user {{ !empty($orders->vendor_id) ? 'text-success' : '' }}"></i>
            </button>
        @endif
    @endif

    @if (!empty($vendorName) && $vendorName != '-')
        <span class="small text-muted fw-semibold d-inline-block text-truncate"
            style="max-width: 100px; cursor: pointer;" title="{{ $vendorName }}" data-bs-toggle="tooltip"
            data-bs-placement="top">
            {{ $vendorName }}
        </span>
    @else
        <span class="small text-secondary">-</span>
    @endif
</div>

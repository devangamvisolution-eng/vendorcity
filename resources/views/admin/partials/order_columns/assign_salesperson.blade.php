<div class="d-flex flex-column align-items-center justify-content-center gap-1 text-center">
    @php
        $spName =
            isset($orders->items[0]) && !empty($orders->items[0]->salesperson_id)
                ? Helper::salesperson($orders->items[0]->salesperson_id)
                : '';
    @endphp

    @if (isset($orders->items[0]))
        <button type="button" class="btn-utility"
            onclick="assign_salesperson('{{ $orders->order_id }}', '{{ $orders->items[0]->salesperson_id }}'); event.preventDefault();"
            data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Salesperson">
            <i class="fas fa-user-tie {{ !empty($orders->items[0]->salesperson_id) ? 'text-success' : '' }}"></i>
        </button>
    @endif

    @if (!empty($spName) && $spName != '-')
        <span class="small text-muted fw-semibold d-inline-block text-truncate" style="max-width: 90px; cursor: pointer;"
            title="{{ $spName }}" data-bs-toggle="tooltip" data-bs-placement="top">
            {{ $spName }}
        </span>
    @else
        <span class="small text-secondary">-</span>
    @endif
</div>

<div class="d-flex flex-column align-items-center justify-content-center gap-1 text-center">
    @php
        $crewName =
            isset($orders->items[0]) && !empty($orders->items[0]->cleaner_id)
                ? Helper::cleanername_new(explode(',', $orders->items[0]->cleaner_id))
                : '';
    @endphp

    @if (Route::currentRouteName() == 'cleaning_package_order' ||
            Route::currentRouteName() == 'handyman-service-order' ||
            Route::currentRouteName() == 'salon-spa-order' ||
            Route::currentRouteName() == 'pest-control-order')
        @if (isset($orders->items[0]))
            @if ($orders->items[0]->cleaner_id == 2)
                <button type="button" class="btn-utility"
                    onclick="assign_cleaner('{{ $orders->order_id }}', '{{ $orders->items[0]->service_id }}', '{{ $orders->items[0]->subservice_id }}', '{{ $orders->items[0]->cleaner_id }}'); event.preventDefault();">
                    <i class="fas fa-user {{ !empty($orders->items[0]->cleaner_id) ? 'text-success' : '' }}"></i>
                </button>
            @else
                <button type="button" class="btn-utility"
                    onclick="assign_multi_cleaner('{{ $orders->order_id }}', '{{ $orders->items[0]->service_id }}', '{{ $orders->items[0]->subservice_id }}', '{{ $orders->items[0]->how_many_cleaners_do_you_need }}', '{{ $orders->items[0]->cleaner_id }}'); event.preventDefault();"
                    title="Assign Multiple Crew">
                    <i class="fas fa-users {{ !empty($orders->items[0]->cleaner_id) ? 'text-success' : '' }}"></i>
                </button>
            @endif
        @endif
    @endif

    @if (!empty($crewName) && $crewName != '-')
        <span class="small text-muted fw-semibold d-inline-block text-truncate"
            style="max-width: 90px; cursor: pointer;" title="{{ $crewName }}" data-bs-toggle="tooltip"
            data-bs-placement="top">
            {{ $crewName }}
        </span>
    @else
        <span class="small text-secondary">-</span>
    @endif
</div>

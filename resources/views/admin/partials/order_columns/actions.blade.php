<div class="dropdown text-center">
    <button class="btn btn-sm btn-outline-secondary btn-dot-action" style="border-radius: 20px; padding: 4px 14px; background: #fff;" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
        <i class="fas fa-ellipsis-h text-muted"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end shadow border-0">
        @php
            $routeMap = [
                'order.index' => [
                    'route' => 'moving_package_order_edit',
                    'param' => 'id',
                ],
                'handyman-service-order' => [
                    'route' => 'handyman_order_edit',
                    'param' => 'ci_order',
                ],
                'painting-service-order' => [
                    'route' => 'painting_order_edit',
                    'param' => 'ci_order',
                ],
                'salon-spa-order' => [
                    'route' => 'salon_spa_order_edit',
                    'param' => 'ci_order',
                ],
                'pest-control-order' => [
                    'route' => 'pest_control_order_edit',
                    'param' => 'ci_order',
                ],
                'automobile-order' => [
                    'route' => 'automobile_order_edit',
                    'param' => 'ci_order',
                ],
                'cleaning_package_order' => [
                    'route' => 'cleaning_package_order_edit',
                    'param' => 'id',
                ],
                'storage_package_order' => [
                    'route' => 'storage-package-order-edit',
                    'param' => 'id',
                ],
                'car-services-at-home-service-order' => [
                    'route' => 'car_services_at_home_order_edit',
                    'param' => 'ci_order',
                ],
            ];
            $currentRoute = Route::currentRouteName();
        @endphp

        @if (isset($routeMap[$currentRoute]))
            <a class="dropdown-item" href="{{ route($routeMap[$currentRoute]['route'], [$routeMap[$currentRoute]['param'] => $orders->order_id]) }}"><i class="far fa-edit me-2"></i>Edit Order</a>
        @endif

        @if ($orders->items[0]->service_id == 34)
            <a class="dropdown-item" href="{{ route('painting-detail', [$orders->order_id]) }}">
        @elseif($orders->items[0]->service_id == 45)
            <a class="dropdown-item" href="{{ route('cleaning-detail', [$orders->order_id]) }}">
        @elseif($orders->items[0]->service_id == 71)
            <a class="dropdown-item" href="{{ route('handyman-detail', [$orders->order_id]) }}">
        @elseif($orders->items[0]->service_id == 38)
            <a class="dropdown-item" href="{{ route('car-services-at-home-detail', [$orders->order_id]) }}">
        @elseif($orders->items[0]->service_id == 54)
            <a class="dropdown-item" href="{{ route('healthcare_at_home_detail', [$orders->order_id]) }}">
        @elseif($currentRoute == 'storage_package_order')
            <a class="dropdown-item" href="{{ route('storage-detail', [$orders->order_id]) }}">
        @else
            <a class="dropdown-item" href="{{ route('moving-detail', [$orders->order_id]) }}">
        @endif
            <i class="far fa-eye me-2"></i>Details
        </a>

        <button type="button" class="dropdown-item" onclick="openLocationLink('{{ $orders->order_id }}', '{{ $orders->items[0]->location_link ?? '' }}'); event.preventDefault();">
            <i class="fas fa-map-marker-alt me-2 {{ !empty($orders->items[0]->location_link) ? 'text-success' : '' }}"></i>Location Link
        </button>

        <button type="button" class="dropdown-item" onclick="add_comm_model('{{ $orders->order_id }}', '{{ $orders->order_total }}', '{{ $orders->sub_total }}', '{{ $orders->items[0]->subservice_booking_percentage ?? 0 }}', '{{ $orders->items[0]->subservice_booking_amount ?? 0 }}')">
            <i class="fas fa-coins me-2"></i>Add Commission
        </button>

        @if ($orders->vendor_id != 0 && $orders->vendor_id != '')
            <button type="button" class="dropdown-item" onclick="add_amount_model('{{ $orders->order_id }}', '{{ $orders->order_total }}')">
                <i class="fas fa-money-bill-wave me-2"></i>Add Amount
            </button>
        @endif
        @if (Route::currentRouteName() == 'cleaning_package_order')
            @if (isset($orders->items[0]->how_often_do_you_need_cleaning) && ($orders->items[0]->how_often_do_you_need_cleaning == 'Weekly' || $orders->items[0]->how_often_do_you_need_cleaning == 'Multiple times a week'))
                <a class="dropdown-item" href="javascript:void(0)" onclick="set_end_date({{ $orders->order_id }}, '{{ $orders->items[0]->end_date }}')">
                    <i class="far fa-calendar me-2"></i>End Date
                </a>
            @endif
        @endif

        @if ($currentRoute == 'storage_package_order')
            <a class="dropdown-item" href="javascript:void(0);" onclick="confirmRenewMail({{ $orders->order_id }})">
                <i class="fas fa-envelope me-2"></i>Renew Mail
            </a>
            <a class="dropdown-item" href="{{ route('storage-admin-order', ['renew_id' => $orders->order_id]) }}">
                <i class="fas fa-sync me-2"></i>Renew Order
            </a>
        @endif
        @if ($orders->google_event_id)
            <a href="javascript:void(0);" class="dropdown-item" onclick="handlecalanderAction({{ $orders->order_id }}, 'update')">
                <i class="fas fa-calendar-check me-2"></i>Update Calendar
            </a>
        @else
            <a href="javascript:void(0);" class="dropdown-item" onclick="handlecalanderAction({{ $orders->order_id }}, 'add')">
                <i class="fas fa-calendar-plus me-2"></i>Add to Calendar
            </a>
        @endif
    </div>
</div>

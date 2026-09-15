

                                                <select class="form-select form-select-sm mb-1 fw-bold"
                                                    style="font-size: 12px;"
                                                    onchange="order_status_change({{ $orders->order_id }}, this)">
                                                    <option value="BK"
                                                        {{ $orders->order_status === 'BK' ? 'selected' : '' }}>Booking
                                                        Requested</option>
                                                    <option value="BC"
                                                        {{ in_array($orders->order_status, ['BC', 'P', 'PA']) ? 'selected' : '' }}>
                                                        Booking Confirmed</option>
                                                    <option value="OTW"
                                                        {{ $orders->order_status === 'OTW' ? 'selected' : '' }}>On the way
                                                    </option>
                                                    <option value="IP"
                                                        {{ $orders->order_status === 'IP' ? 'selected' : '' }}>In progress
                                                    </option>
                                                    <option value="CO"
                                                        {{ $orders->order_status === 'CO' ? 'selected' : '' }}>Booking
                                                        Completed</option>
                                                    <option value="CL"
                                                        {{ $orders->order_status === 'CL' ? 'selected' : '' }}>Booking
                                                        Cancelled</option>
                                                    <option value="UP"
                                                        {{ $orders->order_status === 'UP' ? 'selected' : '' }}>Unpaid
                                                    </option>
                                                </select>

                                                <div class="d-flex align-items-center">
                                                    @if (isset($orders->items[0]))
                                                        <input type="text"
                                                            value="{{ $orders->items[0]->subservice_booking_percentage }}"
                                                            onchange="updateorder_booking_percentage(this.value, '{{ $orders->items[0]->id }}');"
                                                            class="form-control form-control-sm text-center"
                                                            style="width: 45px; height: 22px; font-size: 11px;">
                                                        <span class="ms-1 small text-muted">Comm %</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    @if (isset($orders->items[0]))
                                                        <button type="button" class="btn-utility"
                                                            onclick="assign_salesperson('{{ $orders->order_id }}', '{{ $orders->items[0]->salesperson_id }}'); event.preventDefault();"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Assign Salesperson">

                                                            <i
                                                                class="fas fa-user-tie {{ !empty($orders->items[0]->salesperson_id) ? 'text-success' : '' }}"></i>
                                                        </button>
                                                    @endif


                                                    @if (Route::currentRouteName() == 'cleaning_package_order' ||
                                                            Route::currentRouteName() == 'handyman-service-order' ||
                                                            Route::currentRouteName() == 'salon-spa-order' ||
                                                            Route::currentRouteName() == 'pest-control-order')
                                                        {{-- ================= SALES PERSON ================= --}}



                                                        @if (isset($orders->items[0]))
                                                            {{-- If Cleaner ID = 2 → Assign Single Crew --}}
                                                            @if ($orders->items[0]->cleaner_id == 2)
                                                                <button type="button" class="btn-utility"
                                                                    onclick="assign_cleaner('{{ $orders->order_id }}', '{{ $orders->items[0]->service_id }}', '{{ $orders->items[0]->subservice_id }}', '{{ $orders->items[0]->cleaner_id }}'); event.preventDefault();">
                                                                    <i
                                                                        class="fas fa-user {{ !empty($orders->items[0]->cleaner_id) ? 'text-success' : '' }}"></i>
                                                                </button>

                                                                {{-- If Cleaner Already Assigned or Not Assigned --}}
                                                            @else
                                                                <button type="button" class="btn-utility"
                                                                    onclick="assign_multi_cleaner(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                '{{ $orders->order_id }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                '{{ $orders->items[0]->service_id }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                '{{ $orders->items[0]->subservice_id }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                '{{ $orders->items[0]->how_many_cleaners_do_you_need }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                '{{ $orders->items[0]->cleaner_id }}'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ); event.preventDefault();"
                                                                    title="Assign Multiple Crew">

                                                                    <i
                                                                        class="fas fa-users {{ !empty($orders->items[0]->cleaner_id) ? 'text-success' : '' }}"></i>
                                                                </button>
                                                            @endif
                                                        @else
                                                            {{ '-' }}
                                                        @endif

                                                        {{-- @if (isset($orders->items[0]))
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @if (!empty($orders->items[0]->cleaner_id))
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="{{ url('mark-attendance/' . $orders->order_id) }}" class="btn-utility"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-toggle="tooltip" title="Attendance">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="fas fa-calendar-check"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @endif --}}

                                                        {{-- ================= ADD PER CREW PRICE ================= --}}
                                                        {{-- @if ($orders->items[0]->subservice_id != 28) --}}
                                                        {{-- @if (!empty($orders->items[0]->cleaner_id))
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @if (empty($orders->items[0]->cleaner_price) && $orders->items[0]->cleaner_price == null)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button" class="btn-utility"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                onclick="add_cleaner_price('{{ $orders->order_id }}');" data-bs-toggle="tooltip"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-bs-placement="top" title="Add Per Crew Price">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="fas fa-dollar-sign"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            @endif --}}
                                                        {{-- @endif --}}
                                                    @endif

                                                    @if ($orders->payment_status == 'Success' || $orders->payment_status == 'paid')
                                                        @if ($orders->items[0]->service_id == 50)
                                                            <button type="button" class="btn-utility"
                                                                onclick="assign_vendor_car('{{ $orders->order_id }}', '{{ $orders->vendor_id }}'); event.preventDefault();"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Assign Vendor car">

                                                                <i
                                                                    class="fas fa-user {{ !empty($orders->vendor_id) ? 'text-success' : '' }}"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn-utility"
                                                                onclick="assign_vendor('{{ $orders->order_id }}', '{{ $orders->vendor_id }}'); event.preventDefault();"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Assign Vendor">

                                                                <i
                                                                    class="fas fa-user {{ !empty($orders->vendor_id) ? 'text-success' : '' }}"></i>
                                                            </button>
                                                        @endif
                                                    @endif

                                                    <button type="button" class="btn-utility"
                                                        onclick="openLocationLink('{{ $orders->order_id }}', '{{ $orders->items[0]->location_link }}'); event.preventDefault();"
                                                        title="Location Link">

                                                        <i
                                                            class="fas fa-map-marker-alt {{ !empty($orders->items[0]->location_link) ? 'text-success' : '' }}"></i>
                                                    </button>

                                                </div>
                                            </td>

                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle fw-bold"
                                                        type="button" data-bs-toggle="dropdown">
                                                        Manage
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
                                                                'storage_package_order' => [
                                                                    'route' => 'storage-package-order-edit',
                                                                    'param' => 'id',
                                                                ],
                                                                // 'healthcare_at_home_package_order' => [
                                                                //     'route' => 'healthcare_at_home_order_edit',
                                                                //     'param' => 'id',
                                                                // ],

                                                                'car-services-at-home-service-order' => [
                                                                    'route' => 'car_services_at_home_order_edit',
                                                                    'param' => 'ci_order',
                                                                ],
                                                            ];
                                                            $currentRoute = Route::currentRouteName();
                                                        @endphp

                                                        @if (isset($routeMap[$currentRoute]))
                                                            <a class="dropdown-item"
                                                                href="{{ route($routeMap[$currentRoute]['route'], [$routeMap[$currentRoute]['param'] => $orders->order_id]) }}"><i
                                                                    class="far fa-edit me-2"></i>Edit Order</a>
                                                        @endif

                                                        @if ($orders->items[0]->service_id == 34)
                                                            <a class="dropdown-item"
                                                                href="{{ route('painting-detail', [$orders->order_id]) }}">
                                                            @elseif($orders->items[0]->service_id == 45)
                                                                <a class="dropdown-item"
                                                                    href="{{ route('cleaning-detail', [$orders->order_id]) }}">
                                                                @elseif($orders->items[0]->service_id == 71)
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('handyman-detail', [$orders->order_id]) }}">
                                                                    @elseif($orders->items[0]->service_id == 38)
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('car-services-at-home-detail', [$orders->order_id]) }}">
                                                                        @elseif($orders->items[0]->service_id == 54)
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('healthcare_at_home_detail', [$orders->order_id]) }}">
                                                                            @elseif($currentRoute == 'storage_package_order')
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('storage-detail', [$orders->order_id]) }}">
                                                                                @elseif($currentRoute == 'storage_package_order')
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('storage-detail', [$orders->order_id]) }}"></a>
                                                                                @else
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('moving-detail', [$orders->order_id]) }}">
                                                        @endif
                                                        <i class="far fa-eye me-2"></i>Details
                                                        </a>

                                                        <button type="button" class="dropdown-item"
                                                            onclick="add_comm_model(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    '{{ $orders->order_id }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    '{{ $orders->order_total }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    '{{ $orders->sub_total }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    '{{ $orders->items[0]->subservice_booking_percentage ?? 0 }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    '{{ $orders->items[0]->subservice_booking_amount ?? 0 }}'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                )">
                                                            <i class="fas fa-coins me-2"></i>Add Commission
                                                        </button>

                                                        @if ($orders->vendor_id != 0 && $orders->vendor_id != '')
                                                            <button type="button" class="dropdown-item"
                                                                onclick="add_amount_model(
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    '{{ $orders->order_id }}',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    '{{ $orders->order_total }}'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                )">
                                                                <i class="fas fa-money-bill-wave me-2"></i>Add Amount
                                                            </button>
                                                        @endif
                                                        @if (Route::currentRouteName() == 'cleaning_package_order')
                                                            @if (
                                                                $orders->items[0]->how_often_do_you_need_cleaning == 'Weekly' ||
                                                                    $orders->items[0]->how_often_do_you_need_cleaning == 'Multiple times a week')
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="set_end_date({{ $orders->order_id }}, '{{ $orders->items[0]->end_date }}')">
                                                                    <i class="far fa-calendar me-2"></i>End Date
                                                                </a>
                                                            @endif
                                                        @endif

                                                        @if ($currentRoute == 'storage_package_order')
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                onclick="confirmRenewMail({{ $orders->order_id }})">
                                                                <i class="fas fa-envelope me-2"></i>Renew Mail
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('storage-admin-order', ['renew_id' => $orders->order_id]) }}">
                                                                <i class="fas fa-sync me-2"></i>Renew Order
                                                            </a>
                                                        @endif
                                                        @if ($orders->google_event_id)
                                                            <a href="javascript:void(0);" class="dropdown-item"
                                                                onclick="handlecalanderAction({{ $orders->order_id }}, 'update')">
                                                                <i class="fas fa-calendar-check"></i> Update Calendar
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0);" class="dropdown-item"
                                                                onclick="handlecalanderAction({{ $orders->order_id }}, 'add')">
                                                                <i class="fas fa-calendar-plus"></i> Add to Calendar
                                                            </a>
                                                        @endif

                                                    </div>
                                                </div>
                                            

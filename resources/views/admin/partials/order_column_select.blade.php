@if (in_array(Route::currentRouteName(), [
        'order.index',
        'salon-spa-order',
        'pest-control-order',
        'handyman-service-order',
        'automobile-order',
        'cleaning_package_order',
        'car-services-at-home-service-order',
        'survey-orders',
    ]))
    <input name="selected[]" value="{{ $orders->order_id }}" type="checkbox"
        class="minimal-red" style="height: 18px; width: 18px;">
@else
    <div class="d-none"><input name="selected[]" value="{{ $orders->order_id }}"
            type="checkbox" class="minimal-red"></div>
@endif

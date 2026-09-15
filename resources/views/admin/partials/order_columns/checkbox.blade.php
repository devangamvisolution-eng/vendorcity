<input name="selected[]" value="{{ $orders->order_id }}" type="checkbox" class="minimal-red" @if(Route::currentRouteName() == 'cleaning_package_order') style="height: 18px; width: 18px;" @endif>

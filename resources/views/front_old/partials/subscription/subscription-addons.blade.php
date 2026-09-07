@if(isset($addons) && count($addons) > 0)
<h5 class="mb-4" style="font-weight: 700; font-size: 20px;">People also added</h5>
<div class="addons-grid">
    @foreach ($addons as $addonsData)
        @php
            $priceaddons = $addonsData->price;
            $discount_priceaddons = 0;

            if (!empty($addonsData->discount) && isset($addonsData->discount_type)) {
                $discount_priceaddons =
                    $addonsData->discount_type == 0
                        ? ($addonsData->discount / 100) * $addonsData->price
                        : $addonsData->discount;

                $priceaddons -= $discount_priceaddons;
            }

            $addonImage = $addonsData->image;
            $addonImagePath = 'public/upload/addons/' . $addonImage;
            if (
                empty($addonImage) ||
                !file_exists(public_path('upload/addons/' . $addonImage))
            ) {
                if (strpos(strtolower($addonsData->name), 'balcony') !== false) {
                    $addonImagePath = 'public/upload/addons/1760765006-1729680028add-on_balcony-cleaning.webp';
                } else {
                    $addonImagePath = 'public/upload/addons/1760766270-no-image.png';
                }
            }
        @endphp
        <div class="addon-grid-card entrance-anim">
            <div class="addon-img-wrapper">
                <img src="{{ asset($addonImagePath) }}" alt="{{ $addonsData->image_alt_tag ?? $addonsData->name }}" class="addon-grid-img addon-clickable">

                @if ($discount_priceaddons > 0)
                    <div class="addon-discount-badge price-wrapper">
                        @if ($addonsData->discount_type == 0)
                            <span>-{{ round($addonsData->discount) }}%</span>
                        @else
                            <span>SAVE</span>
                            <span class="currency_dhiramnew">AED</span>
                            <span>{{ round($addonsData->discount) }}</span>
                        @endif
                    </div>
                @endif

                <!-- Floating Action Container -->
                <div class="addon-action-float">
                    <button type="button" class="addons-addbutton addon-float-add"
                        data-id="{{ $addonsData->id }}"
                        data-name="{{ $addonsData->name }}"
                        data-price="{{ $priceaddons }}"
                        data-oldprice="{{ $addonsData->price }}"
                        data-image="{{ asset($addonImagePath) }}"
                        data-type="addons">
                        <i class="fa-solid fa-plus"></i>
                    </button>

                    <div class="addons-quantity-control addon-float-quantity"
                        data-id="{{ $addonsData->id }}" style="display:none;">
                        <button class="addons-minus-btn" type="button"><i class="fa-solid fa-minus"></i></button>
                        <span class="addons-quantity">1</span>
                        <button class="addons-plus-btn" type="button"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
            </div>

            <div class="addon-grid-body addon-clickable">
                <h6 class="addon-grid-title">
                    {{ $addonsData->name ?? '' }}
                </h6>
                <div class="addon-grid-price">
                    <span class="price-addons price-wrapper">
                        <span class="currency_dhiramnew">AED</span>
                        <span>{{ number_format($priceaddons, 0) }}</span>
                    </span>
                    @if ($discount_priceaddons > 0)
                        <span class="old-price-addons price-wrapper">
                            <span class="currency_dhiramnew">AED</span>
                            <span>{{ number_format($addonsData->price, 0) }}</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif

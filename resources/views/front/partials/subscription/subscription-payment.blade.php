<div class="form-group mb-4 payment-selection-container">
    <label class="form-label fw500 dark-color"
        style="font-size: 1.1rem; margin-bottom: 4px;">How would you like to pay for your
        service?</label>
    <p style="font-size: 13px; color: #666; margin-bottom: 16px;">Please note cancellation
        or rescheduling fees may apply for last minute changes.</p>

    <div class="payment-methods-grid">
        <label class="payment-method-card" for="paymet_2">
            <input type="radio" id="paymet_2" name="payment_type" value="ONLINE"
                checked>
            <div class="payment-card-content">
                <div class="payment-card-header">
                    <div class="payment-name">
                        <span class="payment-radio-circle"></span>
                        Online
                    </div>
                    <img src="{{ asset('public/site/images/pay_logo_new.png') }}"
                        style="height: 22px; object-fit: contain;">
                </div>
            </div>
        </label>

        <label class="payment-method-card" for="paymet_1">
            <input type="radio" id="paymet_1" name="payment_type" value="COD">
            <div class="payment-card-content">
                <div class="payment-card-header">
                    <div class="payment-name">
                        <span class="payment-radio-circle"></span>
                        Cash
                    </div>
                </div>
                <p class="cash_fee price-wrapper">
                    <span>+</span>
                    <span class="currency_dhiramnew">AED</span>
                    <span>{{ \App\Enums\VC_ChargiesEnum::COD->percentage() }}</span>
                    <span>Cash handling charges will be applied.</span>
                </p>
            </div>
        </label>
    </div>

    <p class="form-error-text" id="payment_type_error" style="color: red; margin-top: 10px;"></p>
    <div class="">

        @php
            $userData = Session::get('user');
            if ($userData && isset($userData['userid'])) {
                $wallet_plus_amount = DB::table('front_user_wallet')
                    ->where('refer_id', $userData['userid'])
                    ->where('added_from', 0)
                    ->sum('wallet_amount');

                $wallet_minus_amount = DB::table('front_user_wallet')
                    ->where('refer_id', $userData['userid'])
                    ->where('added_from', 1)
                    ->sum('wallet_amount');

                $wallet_amount = $wallet_plus_amount - $wallet_minus_amount;
            } else {
                $wallet_amount = 0;
            }
        @endphp

        <div style="margin-top:20px; margin-bottom: 20px;">
            <label class="form-label fw500 dark-color" style="margin-bottom:12px;">Redeem Promo Code or Pay with Wallet Balance</label>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <!-- URL Promo Banner State -->
                    <div id="url_promo_ready_banner"
                        style="display:none; background: #e0f7fa; padding: 12px 16px; border-radius: 8px; margin-bottom: 12px; align-items: center; gap: 12px;">
                        <i class="fa-solid fa-tag" style="color: #00bcd4; font-size: 1.5rem;"></i>
                        <span style="font-size: 14px; color: #333;"><strong><span id="ready_promo_code_name"></span></strong> voucher code is ready, please select one or more options from the list to get this voucher code applied!</span>
                    </div>

                    <!-- Promo Input State -->
                    <div class="wallet-card-ui" id="promo_code_input_section" style="padding: 12px 16px;">
                        <div style="display:flex; align-items:center; gap:12px; flex:1;">
                            <div class="wallet-icon-box" style="background: rgba(22, 163, 74, 0.08); color: #16a34a;">
                                <i class="fa-solid fa-ticket-alt"></i>
                            </div>
                            <div class="wallet-info" style="flex:1;">
                                <div class="wallet-label">Promo Code</div>
                                <div class="promo-input-group">
                                    <input type="text" name="coupon_code" id="coupon_code" class="promo-input-field" placeholder="Enter Promo Code">
                                    <button type="button" id="promocode" class="promo-apply-btn" onclick="apply_coupon();">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="form-error-text mt-2" id="coupon_error" style="color: red; display:none; font-size: 13px;"></p>
                    <p class="form-success-text mt-2" id="coupon_success" style="color: green; display:none; font-size: 13px;"></p>

                    <!-- Promo Applied State -->
                    <div class="wallet-card-ui d-none promo_dicount_replace_div"
                        style="border-color: #16a34a; background: rgba(22, 163, 74, 0.04); display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; padding: 12px 16px;">
                        <div style="display:flex; align-items:flex-start; gap:12px; flex:1; min-width: 220px;">
                            <div class="wallet-icon-box" style="color: #16a34a; background: rgba(22, 163, 74, 0.1); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                                <i class="fa-solid fa-check-circle" style="font-size: 1.2rem;"></i>
                            </div>
                            <div class="wallet-info" style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
                                <div class="wallet-label" style="color: #16a34a; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 0; letter-spacing: 0.5px;">
                                    Coupon Applied: <span class="promo_code_name" style="font-weight: 800;"></span>
                                </div>
                                <div class="price-wrapper" style="display: flex !important; flex-direction: column !important; align-items: flex-start !important; gap: 4px; width: 100%;">
                                    <!-- Dynamically updated by JS -->
                                </div>
                            </div>
                        </div>
                        <div style="flex-shrink: 0; margin-left: auto;">
                            <button onclick="remove_coupon();" type="button" class="wallet_cancel_new" style="display: block; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 8px; font-weight: 700; color: #333; cursor: pointer; min-width: 80px;">Remove</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-12">
                    @if ($wallet_amount > 0)
                        <div class="wallet-card-ui mt10" style="margin-bottom: 12px;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="wallet-icon-box">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                                <div class="wallet-info">
                                    <div class="wallet-label">Wallet Balance</div>
                                    <div id="wallet_amount" class="price-wrapper">
                                        <span class="currency_dhiramnew" style="font-size: 0.95rem; font-weight:700; position:relative;">AED</span>
                                        <span>{{ $wallet_amount }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button onclick="apply_wallet_discount();" type="button" class="wallet_apply_new">Apply</button>
                                <button onclick="cancelWalletDiscount();" type="button" class="wallet_cancel_new" style="display: none;">Cancel</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

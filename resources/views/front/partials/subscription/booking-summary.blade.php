<div class="sidebar sidebar-summary" id="rightSidebar">
    <div class="font-weight-bold-summary h5 servicedetail_heading">Service Details</div>

    <div class="d-flex justify-content-between subheadingdev">
        <div>Service</div>
        <div class="font-weight-bold sm-summary" style="color: #0d6efd;">
            Cleaning Subscription
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev">
        <div>No. of Hours</div>
        <div class="font-weight-bold sm-summary" style="color: #0d6efd;" id="summaryHours">
            4 Hours
        </div>
    </div>
    <div class="d-flex justify-content-between subheadingdev">
        <div>Materials</div>
        <div class="font-weight-bold sm-summary" style="color: #0d6efd;" id="summaryMaterial">
            No
        </div>
    </div>
    <div class="d-flex justify-content-between subheadingdev">
        <div>Frequency</div>
        <div class="font-weight-bold sm-summary" style="color: #0d6efd;" id="summaryFrequency">
            -
        </div>
    </div>
    <div class="d-flex justify-content-between subheadingdev">
        <div>Date & Time</div>
        <div class="font-weight-bold sm-summary" style="color: #0d6efd;" id="summaryDateTime">
            -
        </div>
    </div>
    <div class="d-flex justify-content-between subheadingdev">
        <div>Address</div>
        <div class="font-weight-bold sm-summary" style="color: #0d6efd;" id="summaryAddress">
            -
        </div>
    </div>

    <span class="underline"></span>

    <div id="cart_item_list"></div>

    <div class="font-weight-bold-summary h5 summarydev pdheading">Payment Details</div>

    <!-- Sidebar: Add More To Apply Banner -->
    <div id="sidebar_promo_add_more_banner"
        style="display:none; background: linear-gradient(135deg, #fff8e1, #fffde7); border: 1.5px dashed #f59e0b; padding: 12px 14px; border-radius: 10px; margin-bottom: 10px;">
        <div style="display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-tag" style="color:#f59e0b; font-size:1rem; flex-shrink:0;"></i>
            <div style="flex:1;">
                <div
                    style="font-size:0.78rem; font-weight:800; color:#b45309; text-transform:uppercase; margin-bottom:2px;">
                    <span id="sidebar_promo_code_name"></span> Ready!
                </div>
                <div id="sidebar_promo_add_more_msg"
                    style="font-size:0.78rem; color:#78350f; font-weight:500; line-height:1.35;">Add more to unlock this
                    promo</div>
            </div>
        </div>
        <div style="margin-top:8px; background:#fde68a; border-radius:99px; height:5px; overflow:hidden;">
            <div id="sidebar_promo_progress_bar"
                style="height:5px; background:#f59e0b; border-radius:99px; transition:width 0.4s; width:0%;"></div>
        </div>
    </div>


    <div class="d-flex justify-content-between subheadingdev subtotal-div">
        <div>Sub Total</div>
        <div class="font-weight-bold sm-summary price-wrapper" style="color: #0d6efd;">
            <span class="currency_dhiramnew">AED</span>
            <span id="summarySubtotal">0.00</span>
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev vat-div align-items-center" id="summaryVatRow"
        style="display: none;">
        <div>VAT ({{ \App\Enums\VC_ChargiesEnum::VAT_PERCENT->percentage() }}%)</div>
        <div class="font-weight-bold sm-summary price-wrapper" style="color: #0d6efd;">
            <span class="currency_dhiramnew">AED</span>
            <span id="summaryVat">0.00</span>
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev vat-div align-items-center" id="summaryServiceFeeRow"
        style="display: none;">
        <span style="display:flex; align-items:center; gap:5px;">Service Fee
            @if (isset($subservice_data) && $subservice_data->service_fee_popup != '')
                <a data-bs-toggle="modal" data-bs-target="#service_fee_popup_{{ $subservice_id }}"
                    style="cursor:pointer; line-height:1;">
                    <img src="{{ asset('public/site/images/infoicon.svg') }}"
                        style="height:14px; width:14px; vertical-align:middle;">
                </a>
            @endif
        </span>
        <div class="font-weight-bold sm-summary price-wrapper" style="color: #0d6efd;">
            <span class="currency_dhiramnew">AED</span>
            <span id="summaryServiceFee">0.00</span>
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev vat-div" id="summaryDiscountRow" style="display: none;">
        <div>Discount</div>
        <div class="font-weight-bold sm-summary price-wrapper" style="color: #0d6efd;">
            - <span class="currency_dhiramnew">AED</span>
            <span id="summaryDiscount">0.00</span>
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev vat-div promo_dicount_summary_div align-items-center"
        style="display: none;">
        <div style="color: #6c757d; font-size: 14px;">Promo Code</div>
        <a href="javascript:void(0)" onclick="remove_coupon();"
            style="color: #333; margin-left: auto; margin-right: 20px; font-size: 18px; text-decoration: none;">
            <span class="flaticon-delete" style="font-size: 1.1rem; color: #555;"></span>
        </a>
        <div class="font-weight-bold sm-summary price-wrapper"
            style="color: #16a34a; font-size: 15px; font-weight: 700;">
            <span class="currency_dhiramnew">AED</span>
            <span class="promo_code_summary">0.00</span>
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev vat-div wallet_dicount_summary_div" style="display: none;">
        <div>Wallet Used</div>
        <div class="font-weight-bold sm-summary price-wrapper" style="color: #0d6efd;">
            - <span class="currency_dhiramnew">AED</span>
            <span class="wallet_used_summary">0.00</span>
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev vat-div wallet_reward_summary_div d-none">
        <div>Wallet Reward</div>
        <div class="font-weight-bold sm-summary price-wrapper" style="color: #16a34a;">
            + <span class="currency_dhiramnew">AED</span>
            <span class="wallet_reward_code_amount">0.00</span>
        </div>
    </div>

    <div class="d-flex justify-content-between subheadingdev vat-div" id="summaryCodRow" style="display: none;">
        <div>Cash Handling Fee</div>
        <div class="font-weight-bold sm-summary price-wrapper" style="color: #0d6efd;">
            <span class="currency_dhiramnew">AED</span>
            <span id="summaryCodFee">0.00</span>
        </div>
    </div>

    <div class="left-summary-total d-flex align-items-center justify-content-center"
        style="background-color: #0046fd; border-radius: 8px; margin-top: 15px; padding: 12px; gap: 10px;">
        <div class="cross_amount_div" style="display: none;">
            <strong class="price-wrapper" style="color: #a0c4ff; opacity: 0.8;">
                <span class="currency_dhiramnew" style="font-size: 14px; text-decoration: line-through;">AED</span>
                <span class="cross_amount" style="font-size: 14px; text-decoration: line-through;">0.00</span>
            </strong>
        </div>
        <strong>
            <div class="price-wrapper" style="color: #fff; display: flex; align-items: center; gap: 5px;">
                <span class="currency_dhiramnew" style="font-size: 16px;">AED</span>
                <span id="summaryTotalBtnVal" style="font-size: 16px;">0.00</span>
            </div>
        </strong>
    </div>
</div>

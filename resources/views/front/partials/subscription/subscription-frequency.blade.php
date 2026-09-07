<div class="frequency-slider-wrapper" id="frequenciesWrapper">
    <button type="button" class="freq-nav-btn left-arrow" onclick="scrollFreqSlider(-1); event.stopPropagation();"><i class="fa fa-chevron-left"></i></button>
    <div class="frequency-slider" id="frequenciesSelection">
        @foreach($frequencies as $index => $f)
            <div class="frequency-card {{ $index == 0 ? 'selected' : '' }}" data-val="{{ $f->id }}"
                data-visits="{{ $f->visits_per_week }}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong style="font-size: 15px; color: #111;">{{ $f->label }}</strong>
                    <span class="freq-discount-badge" style="display:none; color: #2e9f6c; font-weight: 700; font-size: 14px;">Save <span class="freq-discount-val">0</span>%</span>
                </div>
                
                <div class="freq-price-container" style="font-size: 15px; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eaeaea;">
                    <span style="color: #666;">From</span> 
                    <strong class="freq-price-hr" style="font-size: 16px; display: inline-flex; align-items: baseline; gap: 3px;">
                        <span class="currency_dhiramnew" style="font-size: 16px;">AED</span> 
                        <span class="price-val">0</span>
                    </strong>
                    <span class="freq-price-suffix" style="font-size: 16px;">/hr</span>
                </div>
                
                <ul style="list-style-type: disc; padding-left: 15px; font-size: 13px; color: #555; line-height: 1.8; margin-bottom: 0;">
                    <li>{{ $f->visits_per_week * 4 }} visits per month</li>
                    <li><span class="freq-hours-val">4</span> hours per visit</li>
                    <li>Same professional guaranteed</li>
                    <li>Monthly contract</li>
                </ul>
            </div>
        @endforeach
    </div>
    <button type="button" class="freq-nav-btn right-arrow" onclick="scrollFreqSlider(1); event.stopPropagation();"><i class="fa fa-chevron-right"></i></button>
</div>

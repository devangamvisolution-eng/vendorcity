<h5 class="mb-3 mt-4">How often do you need your cleaner?</h5>
<div class="row mb-3" id="packagesSelection">
    @foreach($packages as $index => $p)
        <div class="col-12 mb-3">
            <div class="subscription-option {{ $index == 0 ? 'selected' : '' }}"
                data-val="{{ $p->id }}">
                    <div style="display: flex; align-items: flex-start; width: 100%;">
                        <div class="radio-circle" style="margin-top: 2px;"></div>
                        <div style="flex-grow: 1;">
                            <span style="font-size: 16px;">{{ $p->name }}</span>
                            @if($p->discount_percentage)
                                <span class="badge" style="background: #ffd54f; color: #333; margin-left: 10px; font-weight: 600; padding: 4px 8px;"><i class="fa fa-tag mr-1"></i> Save up to {{ $p->discount_percentage }}%</span>
                            @endif
                            <div class="text-muted mt-1" style="font-size: 13px;">
                                Valid for {{ $p->validity_months }} month. Maximum 6 days per week
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dynamic Frequency Slider Container -->
                    <div class="frequency-container-target mt-3" id="freq-target-{{ $p->id }}" style="display: {{ $index == 0 ? 'block' : 'none' }};"></div>
            </div>
        </div>
    @endforeach
</div>

<div class="form-group mb-3 mt-3">
    <label class="form-label fw500 dark-color" for="country">What time would you like us to start?</label>
    <div class="radio-group time-slot-grid time_replace_ab">
        @php
            use Carbon\Carbon;
            date_default_timezone_set('Asia/Dubai');
            $currentTime = Carbon::now();
            $bufferTime = $currentTime->copy()->addHours(2);
            $i = 1;
        @endphp

        @foreach ($timeslot as $timeslot_data)
            @php
                // Parse the start time from slot name
                $startTimeString = explode('-', $timeslot_data->name)[0];
                $slotStartTime = Carbon::createFromFormat(
                    'g:i A',
                    trim($startTimeString),
                    'Asia/Dubai',
                );

                // Skip if slot is not after buffer time
                if ($slotStartTime->lt($bufferTime)) {
                    continue;
                }

                // Get service-specific timeslot price
                $timeslot_service = DB::table('subservice_timeslot_price')
                    ->where('subservice_id', $subservice_id)
                    ->where('time_slot_id', $timeslot_data->id)
                    ->where('is_active', 1)
                    ->first();

                $timeslot_service_price =
                    $timeslot_service && $timeslot_service->price > 0
                        ? $timeslot_service->price
                        : 0;
            @endphp

            @if ($timeslot_service && $timeslot_service->is_active == 1)
                <div class="surcharge-badge-timeslot items">
                    @if ($timeslot_service_price > 0)
                        <span class="badgespantime">
                            <span>+</span>
                            <span class="currency_dhiramnew">AED</span>
                            <span>{{ $timeslot_service_price }}</span>
                        </span>
                    @endif
                    <input type="radio" id="time{{ $i }}"
                        name="time_slot" value="{{ $timeslot_data->id }}"
                        onclick="timeSlotClick('{{ $timeslot_service_price }}','{{ $timeslot_data->name }}')">
                    <label class="labeltime" for="time{{ $i }}"
                        style="border-radius: 50px;">
                        {{ $timeslot_data->name }}
                    </label>
                </div>
            @endif
            @php $i++; @endphp
        @endforeach
    </div>
    <p class="form-error-text" id="time_slot_error" style="color: red; margin-top: 10px;"></p>
</div>

@if ($emiratesShow == true)
    <div class="timeslotinstruction">
        <h5><i class="fas fa-info-circle tabby-banner-info-icon ms-2"></i></h5>
        <h5 class="">
            If your selected time slot is fully booked, our professional will contact you to
            arrange an alternative appointment.</h5>
    </div>
@endif

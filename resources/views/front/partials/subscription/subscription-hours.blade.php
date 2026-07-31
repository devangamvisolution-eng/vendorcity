<h5 class="mb-3" style="font-size: 16px; font-weight: 700; color: #111;">How many hours do you need your professional to
    stay?</h5>
<div class="hours-pills" id="hoursSelection">
    @foreach($durations as $index => $duration)
        <div class="pill {{ $index == 0 ? 'selected' : '' }}" data-val="{{ $duration->hours }}" data-material-price="{{ $duration->material_price ?? 0 }}">{{ $duration->hours }}</div>
    @endforeach
</div>
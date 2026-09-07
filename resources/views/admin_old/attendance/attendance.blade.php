@extends('admin.includes.Template')

@section('content')

    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title">Crew Attendance</h3>
        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- WARNING -->
        @if (empty($crew_ids))
            <div class="alert alert-warning">
                No crew assigned yet for this order
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <!-- 🔍 MONTH FILTER -->
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="month" name="month" value="{{ $month }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('attendance.store') }}">
                    @csrf

                    <input type="hidden" name="order_id" value="{{ $order_id }}">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">

                            <!-- TABLE HEADER -->
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Date</th>

                                    @foreach ($crew_ids as $crew)
                                        <th>
                                            {{ $crews[$crew] ?? 'Crew ' . $crew }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($all_dates as $date)

                                    <tr>
                                        <!-- DATE -->
                                        <td>
                                            <strong>{{ date('d M Y', strtotime($date)) }}</strong><br>
                                            <span class="badge bg-info">
                                                {{ date('l', strtotime($date)) }}
                                            </span>
                                        </td>

                                        <!-- CREW LOOP -->
                                        @foreach ($crew_ids as $crew)
                                            @php
                                                $key = $crew . '_' . $date;
                                                $row = $attendance[$key] ?? null;
                                            @endphp

                                            <td style="min-width:220px; vertical-align:top">

                                                <!-- WORK TYPE -->
                                                <select name="attendance[{{ $crew }}][{{ $date }}][type]"
                                                    class="form-control mb-1">
                                                    <option value="">Select</option>
                                                    <option value="Full"
                                                        {{ @$row->work_type == 'Full' ? 'selected' : '' }}>Full
                                                        Day</option>
                                                    <option value="Half"
                                                        {{ @$row->work_type == 'Half' ? 'selected' : '' }}>
                                                        Half Day</option>
                                                    <option value="Hour"
                                                        {{ @$row->work_type == 'Hour' ? 'selected' : '' }}>
                                                        Hourly</option>
                                                    <option value="Absent"
                                                        {{ @$row->work_type == 'Absent' ? 'selected' : '' }}>
                                                        Absent</option>
                                                </select>

                                                <!-- HOURS -->
                                                <input type="number" step="0.5"
                                                    name="attendance[{{ $crew }}][{{ $date }}][hours]"
                                                    value="{{ @$row->hours }}" class="form-control mb-1"
                                                    placeholder="Hours">

                                                <!-- BONUS -->
                                                <input type="number"
                                                    name="attendance[{{ $crew }}][{{ $date }}][bonus]"
                                                    value="{{ @$row->bonus }}" class="form-control mb-1"
                                                    placeholder="Bonus ₹">

                                                <!-- MATERIAL -->
                                                <select
                                                    name="attendance[{{ $crew }}][{{ $date }}][material]"
                                                    class="form-control mb-1 material_toggle">
                                                    <option value="No">No Material</option>
                                                    <option value="Yes"
                                                        {{ @$row->material_used == 'Yes' ? 'selected' : '' }}>
                                                        Material Used</option>
                                                </select>

                                                <!-- MATERIAL COST -->
                                                <input type="number"
                                                    name="attendance[{{ $crew }}][{{ $date }}][material_cost]"
                                                    value="{{ @$row->material_cost }}"
                                                    class="form-control mb-1 material_cost" placeholder="Material ₹">

                                                <!-- REPLACEMENT -->
                                                <select
                                                    name="attendance[{{ $crew }}][{{ $date }}][replace]"
                                                    class="form-control mb-1">
                                                    <option value="">No Replace</option>
                                                    @foreach ($all_crews as $c)
                                                        <option value="{{ $c->id }}"
                                                            {{ @$row->replaced_by == $c->id ? 'selected' : '' }}>
                                                            {{ $c->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <!-- SHOW REPLACEMENT -->
                                                @if ($row && $row->replaced_by)
                                                    <small class="text-danger">
                                                        Replaced by:
                                                        {{ $all_crews->where('id', $row->replaced_by)->first()->name ?? '' }}
                                                    </small>
                                                @endif

                                            </td>
                                        @endforeach

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="10">No dates available</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- SAVE BUTTON -->
                    <div class="text-end mt-3">
                        <button class="btn btn-success">Save Attendance</button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@stop


@section('footer_js')

    <script>
        // 🔥 MATERIAL TOGGLE
        $(document).on('change', '.material_toggle', function() {

            let parent = $(this).closest('td');

            if ($(this).val() === 'Yes') {
                parent.find('.material_cost').show();
            } else {
                parent.find('.material_cost').hide().val('');
            }
        });

        // 🔥 INIT
        $('.material_toggle').trigger('change');
    </script>

@stop

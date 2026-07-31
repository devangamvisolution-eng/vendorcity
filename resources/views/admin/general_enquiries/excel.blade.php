<table>
    <thead>
        <tr>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 10px; text-align: center;">ID
            </th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 25px;">Customer Name</th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 20px;">Customer Phone</th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 25px;">Service</th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 25px;">Sub Service</th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 25px;">Source of Lead</th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 15px;">Status</th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 20px;">Salesperson</th>
            <th style="background-color: #2F75B5; color: #FFFFFF; font-weight: bold; width: 20px;">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($enquiries as $enquiry)
            @php
                $sourceIds = explode(',', $enquiry->source_lead_id);
                $sourceNames = [];
                foreach ($source_leads as $sl) {
                    if (in_array($sl->id, $sourceIds)) {
                        $sourceNames[] = $sl->name;
                    }
                }
                $sourceContact = !empty($sourceNames) ? implode(', ', $sourceNames) : '-';
            @endphp
            <tr>
                <td style="text-align: center;">{{ $enquiry->id }}</td>
                <td>{{ $enquiry->c_name }}</td>
                <td>{{ $enquiry->c_mobile }}</td>
                <td>{{ $enquiry->servicename }}</td>
                <td>{{ $enquiry->subservicename }}</td>
                <td>{{ $sourceContact }}</td>
                <td
                    style="color: {{ $enquiry->status == 'Booked' ? '#28a745' : ($enquiry->status == 'Pending' ? '#ffc107' : '#000000') }}; font-weight: bold;">
                    {{ $enquiry->status ?? 'Pending' }}
                </td>
                <td>{{ $enquiry->salesperson_name ?? 'Not Assigned' }}</td>
                <td>{{ date('d M Y', strtotime($enquiry->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th style="background-color: #5B9BD5; color: #FFFFFF; font-weight: bold; text-align: center;"
                colspan="2">SUBSERVICE WISE COUNT</th>
            <th></th>
            <th style="background-color: #5B9BD5; color: #FFFFFF; font-weight: bold; text-align: center;"
                colspan="2">SOURCE WISE COUNT</th>
            <th></th>
            <th style="background-color: #5B9BD5; color: #FFFFFF; font-weight: bold; text-align: center;"
                colspan="2">STATUS WISE COUNT</th>
        </tr>
        <tr>
            <th style="background-color: #DDEBF7; font-weight: bold;">Subservice</th>
            <th style="background-color: #DDEBF7; font-weight: bold; text-align: center;">Count</th>
            <th></th>
            <th style="background-color: #DDEBF7; font-weight: bold;">Source</th>
            <th style="background-color: #DDEBF7; font-weight: bold; text-align: center;">Count</th>
            <th></th>
            <th style="background-color: #DDEBF7; font-weight: bold;">Status</th>
            <th style="background-color: #DDEBF7; font-weight: bold; text-align: center;">Count</th>
        </tr>
    </thead>
    <tbody>
        @php
            $maxSummaryRows = max(count($subservice_summary), count($source_summary), count($status_summary));
        @endphp
        @for ($i = 0; $i < $maxSummaryRows; $i++)
            <tr>
                @if (isset($subservice_summary[$i]))
                    <td>{{ $subservice_summary[$i]->name ?? 'Unknown' }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $subservice_summary[$i]->total }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif

                <td></td>

                @if (isset($source_summary[$i]))
                    <td>{{ $source_summary[$i]->name ?? 'Unknown' }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $source_summary[$i]->total }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif

                <td></td>

                @if (isset($status_summary[$i]))
                    <td>{{ $status_summary[$i]->name ?? 'Pending' }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $status_summary[$i]->total }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
            </tr>
        @endfor
    </tbody>
</table>

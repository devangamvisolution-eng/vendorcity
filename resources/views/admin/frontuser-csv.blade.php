<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Added Date</th>



        </tr>
    </thead>
    <tbody>
        @foreach ($frontuser as $frontuser_data)
            <tr>
                <td>{{ $frontuser_data->name }}</td>
                <td>{{ $frontuser_data->email }}</td>
                <td>{{ $frontuser_data->mobile }}</td>
                @if ($frontuser_data->created_at != '0000-00-00 00:00:00' && $frontuser_data->created_at != null)
                    <td>{{ \Carbon\Carbon::parse($frontuser_data->created_at)->format('d - m - Y') }}</td>
                @else
                    <td>{{ '-' }}</td>
                @endif




            </tr>
        @endforeach
    </tbody>
</table>

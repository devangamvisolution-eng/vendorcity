<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer Id</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Note</th>
            <th>Amount (AED)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $data)
            <tr>
                <td>{{ $data->added_date && $data->added_date != '0000-00-00' ? date('d-m-Y', strtotime($data->added_date)) : 'N/A' }}</td>
                <td>{{ $data->customer_id }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->country_code }} {{ $data->mobile }}</td>
                <td>{{ $data->note ?? '-' }}</td>
                <td>{{ number_format($data->wallet_amount, 2) }}</td>
                <td>{{ $data->added_from == 0 ? 'Added' : 'Deducted' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

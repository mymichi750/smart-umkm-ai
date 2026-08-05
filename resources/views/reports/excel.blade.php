<table>
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Pelanggan</th>
            <th>Kasir</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->invoice }}</td>
                <td>{{ $transaction->customer->name ?? 'Umum' }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->total }}</td>
                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

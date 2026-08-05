<html>
    <head>
        <meta charset="UTF-8">
        <title>Laporan Penjualan</title>
        <style>
            body { font-family: Arial, sans-serif; color: #333; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { padding: 8px 10px; border: 1px solid #ddd; }
            th { background: #f8f9fa; text-align: left; }
            .text-right { text-align: right; }
        </style>
    </head>
    <body>
        <h4>Laporan Penjualan</h4>
        <p>Periode: {{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</p>
        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
                    <th>Kasir</th>
                    <th class="text-right">Total</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->invoice }}</td>
                        <td>{{ $transaction->customer->name ?? 'Umum' }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td class="text-right">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>

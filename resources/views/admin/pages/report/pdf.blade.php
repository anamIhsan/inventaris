<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan {{ ucfirst(str_replace('_', ' ', $type)) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 10px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .badge-danger {
            color: #fff;
            background-color: #dc3545;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <h2>Laporan {{ ucfirst(str_replace('_', ' ', $type)) }}</h2>
    <p class="subtitle">Periode: {{ $start }} s/d {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>

                @if ($type === 'incoming_item')
                    <th>Tanggal Masuk</th>
                    <th>Jumlah</th>
                    <th>Nama Supplier</th>
                @elseif ($type === 'exit_item')
                    <th>Tanggal Keluar</th>
                    <th>Jumlah</th>
                    <th>Lokasi</th>
                    <th>Penerima</th>
                    <th>Keterangan</th>
                @elseif ($type === 'stok_item')
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Minimal Stok</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data ?? [] as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    @if ($type === 'incoming_item')
                        <td>{{ $item['items']['name'] ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['entry_date'])->format('d M Y') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['suppliers']['name'] ?? '-' }}</td>
                    @elseif ($type === 'exit_item')
                        <td>{{ $item['items']['name'] ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['date_out'])->format('d M Y') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['location'] ?? '-' }}</td>
                        <td>{{ $item['recipient'] ?? '-' }}</td>
                        <td>{{ $item['notes'] ?? '-' }}</td>
                    @elseif ($type === 'stok_item')
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['categories']['name'] ?? '-' }}</td>
                        <td>
                            {{ $item['stok'] }}
                            @if (!empty($item['stok_warning']) && $item['stok_warning'])
                                <span class="badge-danger">Stok Rendah</span>
                            @endif
                        </td>
                        <td>{{ $item['minimum_stock'] }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

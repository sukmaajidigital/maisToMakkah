<!DOCTYPE html>
<html>

<head>
    <title>Data Penarikan Pending</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Data Penarikan Pending</h2>
    <p>Tanggal Cetak: {{ date('d M Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengguna</th>
                <th>Jumlah</th>
                <th>Tanggal Minta</th>
                <th>Bank</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdrawals as $withdrawal)
                <tr>
                    <td>{{ $withdrawal->id }}</td>
                    <td>{{ $withdrawal->user->longname }}</td>
                    <td>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                    <td>{{ $withdrawal->created_at->format('d M Y') }}</td>
                    <td>{{ $withdrawal->user->bank_name }} - {{ $withdrawal->user->bank_account_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

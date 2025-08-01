<!DOCTYPE html>
<html>

<head>
    <title>Data Pengguna</title>
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
    <h2>Data Pengguna</h2>
    <p>Tanggal Cetak: {{ date('d M Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Peringkat</th>
                <th>Upline</th>
                <th>Bank</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->longname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->rank->name ?? 'N/A' }}</td>
                    <td>{{ $user->parent->longname ?? '-' }}</td>
                    <td>{{ $user->bank_name }} - {{ $user->bank_account_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

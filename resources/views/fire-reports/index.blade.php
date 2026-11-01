<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan - Karhutla Monitor</title>
</head>
<body>
    <h1>Daftar Laporan Kebakaran</h1>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <a href="{{ url('/dashboard/' . auth()->user()->role) }}">
        Kembali ke Dashboard
    </a>

    <h2>Data Laporan</h2>

    <a href="{{ route('fire-reports.create') }}">Buat Laporan</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($reports->isEmpty())
        <p>Belum ada laporan kebakaran.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul</th>
                    <th>Pelapor</th>
                    <th>Wilayah</th>
                    <th>Waktu Kejadian</th>
                    <th>Tingkat Kondisi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $report->title }}</td>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ $report->area->name }}</td>
                        <td>{{ $report->incident_at->format('d-m-Y H:i') }}</td>
                        <td>{{ ucfirst($report->condition_level) }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($report->status)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $reports->links() }}
    @endif

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
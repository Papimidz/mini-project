<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peninjauan Laporan</title>
</head>
<body>
    <h1>Daftar Laporan untuk Ditinjau</h1>

    <p>
        <a href="{{ url('/dashboard/relawan') }}">Kembali ke Dashboard</a>
    </p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <hr>

    @if ($reports->isEmpty())
        <p>Belum ada laporan yang tersedia.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Laporan</th>
                    <th>Pelapor</th>
                    <th>Wilayah</th>
                    <th>Waktu Kejadian</th>
                    <th>Tingkat Kondisi</th>
                    <th>Status</th>
                    <th>Aksi</th>
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
                        <td>
                            <a href="{{ route('report-reviews.show', $report->id) }}">
                                Tinjau
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $reports->links() }}
    @endif
</body>
</html>

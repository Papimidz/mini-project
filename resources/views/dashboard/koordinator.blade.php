<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Koordinator - Karhutla Monitor</title>
</head>
<body>
    <h1>Dashboard Koordinator Relawan</h1>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <p>Role: Koordinator Relawan</p>

    <hr>

    <h2>Ringkasan Laporan Kebakaran</h2>

    <div>
        <h3>Total Laporan</h3>
        <p>{{ $totalReports }}</p>
    </div>

    <div>
        <h3>Menunggu Peninjauan</h3>
        <p>{{ $waitingReports }}</p>
    </div>

    <div>
        <h3>Laporan Selesai</h3>
        <p>{{ $completedReports }}</p>
    </div>

    <hr>

    <h2>Filter Laporan</h2>

    <form action="{{ route('dashboard.koordinator') }}" method="GET">
        <label for="area_id">Pilih Wilayah:</label>

        <select name="area_id" id="area_id">
            <option value="">Semua Wilayah</option>

            @foreach ($areas as $area)
                <option value="{{ $area->id }}"
                    {{ request('area_id') == $area->id ? 'selected' : '' }}>
                    {{ $area->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Terapkan Filter</button>

        <a href="{{ route('dashboard.koordinator') }}">Reset</a>
    </form>

    <hr>

    <h2>Daftar Laporan</h2>

    @if ($reports->isEmpty())
        <p>Belum ada laporan pada wilayah yang dipilih.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul Laporan</th>
                    <th>Pelapor</th>
                    <th>Wilayah</th>
                    <th>Tingkat Kondisi</th>
                    <th>Status</th>
                    <th>Waktu Kejadian</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $reports->firstItem() + $loop->index }}</td>
                        <td>{{ $report->title }}</td>
                        <td>{{ $report->user->name }}</td>
                        <td>{{ $report->area->name }}</td>
                        <td>{{ ucfirst($report->condition_level) }}</td>
                        <td>{{ str_replace('_', ' ', ucfirst($report->status)) }}</td>
                        <td>{{ $report->incident_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>
            Menampilkan {{ $reports->firstItem() }}–{{ $reports->lastItem() }}
            dari {{ $reports->total() }} laporan.
        </p>

        {{ $reports->links() }}
    @endif

    <hr>

    <h2>Menu Pengelolaan</h2>

    <p>
        <a href="{{ route('fire-reports.index') }}">Lihat Daftar Laporan</a>
    </p>

    <p>
        <a href="{{ route('fire-reports.create') }}">Buat Laporan</a>
    </p>

    <p>
        <a href="{{ route('areas.index') }}">Kelola Wilayah</a>
    </p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>

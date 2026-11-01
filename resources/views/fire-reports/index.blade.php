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

    <hr>

    <h3>Pencarian dan Filter Laporan</h3>

    <form action="{{ route('fire-reports.index') }}" method="GET">

        <div>
            <label for="search">Cari Judul:</label><br>
            <input
                type="text"
                id="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Masukkan judul laporan"
            >
        </div>

        <br>

        <div>
            <label for="area_id">Wilayah:</label><br>
            <select name="area_id" id="area_id">
                <option value="">Semua Wilayah</option>

                @foreach ($areas as $area)
                    <option
                        value="{{ $area->id }}"
                        {{ request('area_id') == $area->id ? 'selected' : '' }}
                    >
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label for="condition_level">Tingkat Kondisi:</label><br>
            <select name="condition_level" id="condition_level">
                <option value="">Semua Kondisi</option>
                <option value="rendah" {{ request('condition_level') == 'rendah' ? 'selected' : '' }}>
                    Rendah
                </option>
                <option value="sedang" {{ request('condition_level') == 'sedang' ? 'selected' : '' }}>
                    Sedang
                </option>
                <option value="tinggi" {{ request('condition_level') == 'tinggi' ? 'selected' : '' }}>
                    Tinggi
                </option>
            </select>
        </div>

        <br>

        <div>
            <label for="status">Status:</label><br>
            <select name="status" id="status">
                <option value="">Semua Status</option>
                <option value="menunggu_peninjauan" {{ request('status') == 'menunggu_peninjauan' ? 'selected' : '' }}>
                    Menunggu Peninjauan
                </option>
                <option value="perlu_tindak_lanjut" {{ request('status') == 'perlu_tindak_lanjut' ? 'selected' : '' }}>
                    Perlu Tindak Lanjut
                </option>
                <option value="sedang_ditindaklanjuti" {{ request('status') == 'sedang_ditindaklanjuti' ? 'selected' : '' }}>
                    Sedang Ditindaklanjuti
                </option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>
            </select>
        </div>

        <br>

        <button type="submit">Terapkan Filter</button>
        <a href="{{ route('fire-reports.index') }}">Reset</a>

    </form>

    <hr>

    <h3>Hasil Laporan</h3>

    @if ($reports->isEmpty())
        <p>Tidak ada laporan yang sesuai dengan pencarian atau filter.</p>
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
                        <td>{{ $reports->firstItem() + $loop->index }}</td>
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

        <p>
            {{ $reports->firstItem() }}–{{ $reports->lastItem() }}
            dari {{ $reports->total() }} laporan
        </p>

        {{ $reports->links() }}
    @endif

    <hr>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>

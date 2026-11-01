<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peninjauan Laporan</title>
</head>
<body>
    <h1>Detail Laporan Kebakaran</h1>

    <p>
        <a href="{{ route('report-reviews.index') }}">Kembali ke Daftar Laporan</a>
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <hr>

    <h3>Informasi Laporan</h3>

    <p><strong>Judul:</strong> {{ $fireReport->title }}</p>
    <p><strong>Pelapor:</strong> {{ $fireReport->user->name }}</p>
    <p><strong>Wilayah:</strong> {{ $fireReport->area->name }}</p>
    <p><strong>Deskripsi:</strong> {{ $fireReport->description }}</p>
    <p><strong>Waktu Kejadian:</strong> {{ $fireReport->incident_at->format('d-m-Y H:i') }}</p>
    <p><strong>Latitude:</strong> {{ $fireReport->latitude }}</p>
    <p><strong>Longitude:</strong> {{ $fireReport->longitude }}</p>
    <p><strong>Tingkat Kondisi:</strong> {{ ucfirst($fireReport->condition_level) }}</p>
    <p><strong>Status:</strong> {{ str_replace('_', ' ', ucfirst($fireReport->status)) }}</p>

    @if ($fireReport->evidence_path)
        <p>
            <strong>Bukti:</strong>
            <a href="{{ asset('storage/' . $fireReport->evidence_path) }}" target="_blank">
                Lihat Bukti
            </a>
        </p>
    @endif

    <hr>

    <h3>Berikan Catatan Peninjauan</h3>

    <form action="{{ route('report-reviews.store', $fireReport->id) }}" method="POST">
        @csrf

        <div>
            <label for="note">Catatan:</label><br>
            <textarea id="note" name="note" rows="5" cols="50" required>{{ old('note') }}</textarea>

            @error('note')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Simpan Catatan</button>
    </form>

    <hr>

    <h3>Riwayat Peninjauan</h3>

    @forelse ($fireReport->reviews as $review)
        <div>
            <p><strong>Relawan:</strong> {{ $review->reviewer->name }}</p>
            <p><strong>Catatan:</strong> {{ $review->note }}</p>
            <p><strong>Tanggal:</strong> {{ $review->created_at->format('d-m-Y H:i') }}</p>
        </div>
        <hr>
    @empty
        <p>Belum ada catatan peninjauan.</p>
    @endforelse
</body>
</html>

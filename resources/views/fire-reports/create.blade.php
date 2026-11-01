<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Karhutla Monitor</title>
</head>
<body>
    <h1>Buat Laporan Kebakaran</h1>

    <a href="{{ route('fire-reports.index') }}">
        Kembali ke Daftar Laporan
    </a>

    <form action="{{ route('fire-reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Judul Laporan</label><br>
            <input type="text" name="title" value="{{ old('title') }}" required>
            @error('title')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Deskripsi Kejadian</label><br>
            <textarea name="description" required>{{ old('description') }}</textarea>
            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Wilayah</label><br>
            <select name="area_id" required>
                <option value="">Pilih Wilayah</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}"
                        {{ old('area_id') == $area->id ? 'selected' : '' }}>
                        {{ $area->name }}
                    </option>
                @endforeach
            </select>
            @error('area_id')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Waktu Kejadian</label><br>
            <input type="datetime-local" name="incident_at"
                value="{{ old('incident_at') }}" required>
            @error('incident_at')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Latitude</label><br>
            <input type="number" step="any" name="latitude"
                value="{{ old('latitude') }}" required>
            @error('latitude')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Longitude</label><br>
            <input type="number" step="any" name="longitude"
                value="{{ old('longitude') }}" required>
            @error('longitude')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Tingkat Kondisi</label><br>
            <select name="condition_level" required>
                <option value="">Pilih Kondisi</option>
                <option value="rendah">Rendah</option>
                <option value="sedang">Sedang</option>
                <option value="tinggi">Tinggi</option>
            </select>
            @error('condition_level')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Bukti Pendukung (JPG, JPEG, PNG, PDF, maksimal 2 MB)</label><br>
            <input type="file" name="evidence"
                accept=".jpg,.jpeg,.png,.pdf">
            @error('evidence')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Kirim Laporan</button>
    </form>
</body>
</html>
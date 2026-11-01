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
            <select name="area_id" id="area_id" required>
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

        <div id="area-report-info">
            <p>Pilih wilayah untuk melihat informasi laporan.</p>
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
                <option value="rendah" {{ old('condition_level') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                <option value="sedang" {{ old('condition_level') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="tinggi" {{ old('condition_level') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
            </select>
            @error('condition_level')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Bukti Pendukung (JPG, JPEG, PNG, PDF, maksimal 2 MB)</label><br>
            <input type="file" name="evidence" accept=".jpg,.jpeg,.png,.pdf">
            @error('evidence')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Kirim Laporan</button>
    </form>

    <script>
        const areaSelect = document.getElementById('area_id');
        const areaReportInfo = document.getElementById('area-report-info');

        areaSelect.addEventListener('change', async function () {
            const areaId = this.value;

            if (!areaId) {
                areaReportInfo.innerHTML =
                    '<p>Pilih wilayah untuk melihat informasi laporan.</p>';
                return;
            }

            areaReportInfo.innerHTML = '<p>Memuat informasi laporan...</p>';

            try {
                const response = await fetch(`/fire-reports/area/${areaId}`);

                if (!response.ok) {
                    throw new Error('Gagal mengambil data laporan.');
                }

                const data = await response.json();

                areaReportInfo.innerHTML = `
                    <h3>Informasi Laporan Wilayah ${data.area}</h3>
                    <p>Total laporan aktif: ${data.total_reports}</p>
                `;

                if (data.reports.length === 0) {
                    areaReportInfo.innerHTML +=
                        '<p>Belum ada laporan aktif di wilayah ini.</p>';
                    return;
                }

                data.reports.forEach(report => {
                    const item = document.createElement('div');

                    const title = document.createElement('strong');
                    title.textContent = report.title;

                    const details = document.createElement('p');
                    details.textContent =
                        `Pelapor: ${report.reporter} | Kondisi: ${report.condition_level} | Status: ${report.status} | Waktu: ${report.incident_at}`;

                    item.appendChild(title);
                    item.appendChild(details);
                    areaReportInfo.appendChild(item);
                });

            } catch (error) {
                areaReportInfo.innerHTML =
                    '<p>Terjadi kesalahan saat mengambil informasi laporan.</p>';
            }
        });

        if (areaSelect.value) {
            areaSelect.dispatchEvent(new Event('change'));
        }
    </script>
</body>
</html>

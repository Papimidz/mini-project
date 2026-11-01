<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Wilayah - Karhutla Monitor</title>
</head>
<body>
    <h1>Tambah Wilayah</h1>

    <a href="{{ route('areas.index') }}">Kembali ke Daftar Wilayah</a>

    <form action="{{ route('areas.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nama Wilayah</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >

            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description">Deskripsi</label>
            <textarea
                id="description"
                name="description"
            >{{ old('description') }}</textarea>

            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Simpan Wilayah</button>
    </form>
</body>
</html>
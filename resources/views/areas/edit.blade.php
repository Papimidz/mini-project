<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wilayah - Karhutla Monitor</title>
</head>
<body>
    <h1>Edit Wilayah</h1>

    <a href="{{ route('areas.index') }}">Kembali ke Daftar Wilayah</a>

    <form action="{{ route('areas.update', $area->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Nama Wilayah</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $area->name) }}"
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
            >{{ old('description', $area->description) }}</textarea>

            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
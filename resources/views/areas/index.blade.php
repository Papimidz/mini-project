<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Wilayah - Karhutla Monitor</title>
</head>
<body>
    <h1>Data Wilayah</h1>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>

    <a href="{{ route('dashboard.koordinator') }}">Kembali ke Dashboard</a>

    <h2>Daftar Wilayah</h2>

    <a href="{{ route('areas.create') }}">Tambah Wilayah</a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($areas->isEmpty())
        <p>Belum ada data wilayah.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Wilayah</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $area)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $area->name }}</td>
                        <td>{{ $area->description ?? '-' }}</td>
                        <td>
                            <a href="{{ route('areas.edit', $area->id) }}">Edit</a>

                            <form action="{{ route('areas.destroy', $area->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Yakin ingin menghapus wilayah ini?')"
                                >
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $areas->links() }}
    @endif

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
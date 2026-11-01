<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Relawan - Karhutla Monitor</title>
</head>
<body>
    <h1>Dashboard Relawan Pemantau</h1>

    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <p>Role: Relawan Pemantau</p>

    <a href="{{ route('fire-reports.index') }}">Lihat Daftar Laporan</a>
    <br>
    <a href="{{ route('fire-reports.create') }}">Buat Laporan</a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
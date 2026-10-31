<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Karhutla Monitor</title>
</head>
<body>
    <h1>Selamat Datang di Karhutla Monitor</h1>

    <p>
        Halo, {{ auth()->user()->name }}!
        Kamu berhasil login.
    </p>

    <p>
        Role akun: {{ auth()->user()->role }}
    </p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>

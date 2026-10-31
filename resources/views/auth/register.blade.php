<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Karhutla Monitor</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 8px;
            color: #263238;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #26734d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #1d5c3d;
        }

        .error {
            color: #d32f2f;
            font-size: 13px;
            margin: -10px 0 12px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        a {
            color: #26734d;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Karhutla Monitor</h2>
        <p class="subtitle">Buat akun baru untuk melanjutkan</p>

        <form action="{{ url('/register') }}" method="POST">
            @csrf

            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name"
                value="{{ old('name') }}" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation"
                name="password_confirmation" required>

            <button type="submit">Daftar</button>
        </form>

        <div class="footer">
            Sudah punya akun?
            <a href="{{ url('/login') }}">Login di sini</a>
        </div>
    </div>
</body>
</html>

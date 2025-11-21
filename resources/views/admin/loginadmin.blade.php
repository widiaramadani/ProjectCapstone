<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Nurrahma Tour & Travel</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #d4d4d4;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 30px;
            color: #333;
            font-weight: normal;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #a67c52;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #a67c52;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #8d6a44;
        }

        .error-message {
            color: #d32f2f;
            font-size: 14px;
            margin-top: 10px;
        }

        footer {
            background-color: #d4d4d4;
            padding: 20px;
            text-align: center;
            color: #333;
            font-size: 14px;
        }

    </style>
</head>

<body>
    <header>
        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 80'%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='Arial' font-size='24' fill='%23333'%3ENurrahma%3C/text%3E%3Ctext x='50%25' y='75%25' dominant-baseline='middle' text-anchor='middle' font-family='Arial' font-size='12' fill='%23666'%3ETour %26 Travel%3C/text%3E%3C/svg%3E" 
        alt="Nurrahma Logo" class="logo">
    </header>

    <main>
        <div class="login-container">
            <h1>Masuk ke halaman admin</h1>

            {{-- Tampilkan Error dari Backend --}}
            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email Admin</label>
                    <input type="text" id="email" name="email" placeholder="admin@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </div>
    </main>

    <footer>
        <p>Nurrahma Tour & Travel</p>
    </footer>

</body>
</html>

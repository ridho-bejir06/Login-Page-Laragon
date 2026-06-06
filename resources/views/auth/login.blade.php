<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Welcome Back</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 600;
        }

        .login-header p {
            color: #6b7280;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Styling Alerts */
        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Styling Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4b5563;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        .form-group input:focus {
            border-color: #4f46e5;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s ease, transform 0.1s ease;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
            margin-top: 10px;
        }

        .btn-submit:hover {
            opacity: 0.95;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-footer a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: #3b82f6;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h2>Welcome Back!</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit">Login Sekarang</button>
        </form>

        <div class="login-footer">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
    </div>

</body>
</html>
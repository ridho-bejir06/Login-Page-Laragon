<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Create Account</title>
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

        .register-container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            margin: 20px 0;
        }

        .register-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .register-header h2 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 600;
        }

        .register-header p {
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

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        /* Styling Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #4b5563;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
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

        .register-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6b7280;
        }

        .register-footer a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .register-footer a:hover {
            color: #3b82f6;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="register-header">
            <h2>Daftar Akun</h2>
            <p>Lengkapi data di bawah untuk mendaftar</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required>
            </div>

            <button type="submit" class="btn-submit">Daftar Sekarang</button>
        </form>

        <div class="register-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>

</body>
</html>
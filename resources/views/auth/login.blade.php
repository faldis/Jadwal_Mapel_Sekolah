<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Jadwal Sekolah</title>
    <meta name="description" content="Login ke Sistem Manajemen Jadwal Pelajaran Sekolah">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 30%, #f8fafc 60%, #dbeafe 100%);
            position: relative;
            overflow: hidden;
        }

        /* Soft decorative shapes */
        .decor {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .decor-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.7), transparent 70%);
            top: -200px; right: -100px;
            animation: float-1 8s ease-in-out infinite alternate;
        }
        .decor-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.65), transparent 70%);
            bottom: -150px; left: -100px;
            animation: float-2 10s ease-in-out infinite alternate;
        }
        .decor-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.8), transparent 70%);
            top: 40%; left: 10%;
            animation: float-3 9s ease-in-out infinite alternate;
        }

        @keyframes float-1 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-80px, 60px) scale(1.1); }
            100% { transform: translate(40px, 120px) scale(0.9); }
        }
        @keyframes float-2 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(100px, -60px) scale(1.15); }
            100% { transform: translate(-40px, -100px) scale(0.85); }
        }
        @keyframes float-3 {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(80px, 80px) scale(1.2); }
            100% { transform: translate(-60px, -40px) scale(0.8); }
        }

        /* Login card */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 380px;
            margin: 0 20px;
            padding: 36px 32px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
            animation: cardAppear 0.6s ease;
        }
        @keyframes cardAppear {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.8rem;
            color: #fff;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
        }

        .login-title {
            text-align: center;
            margin-bottom: 6px;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .login-subtitle {
            text-align: center;
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
            position: relative;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            transition: color 0.3s ease;
        }
        .form-control {
            width: 100%;
            padding: 14px 18px 14px 46px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            color: #1e293b;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: #fff;
        }
        .form-control:focus ~ i {
            color: #3b82f6;
        }
        .form-control::placeholder {
            color: #94a3b8;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }
        .remember-row input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #3b82f6;
            cursor: pointer;
        }
        .remember-row label {
            font-size: 0.95rem;
            color: #64748b;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            font-size: 1.05rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.25);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
        }
        .btn-login:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 22px;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .footer-text {
            text-align: center;
            margin-top: 28px;
            font-size: 0.85rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <!-- Soft decorative shapes -->
    <div class="decor decor-1"></div>
    <div class="decor decor-2"></div>
    <div class="decor decor-3"></div>

    <!-- Login Card -->
    <div class="login-card">
        <div class="login-icon">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <h1 class="login-title">Jadwal Sekolah</h1>
        <p class="login-subtitle">Masuk ke sistem manajemen jadwal</p>

        @if($errors->any())
            <div class="error-message" id="login-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" id="login-form">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" name="email" id="email" class="form-control"
                           placeholder="admin@admin.com" value="{{ old('email') }}" required autofocus>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="••••••••" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <div class="remember-row">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login" id="btn-login">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>

        <p class="footer-text">Sistem Manajemen Jadwal Pelajaran</p>
    </div>
</body>
</html>

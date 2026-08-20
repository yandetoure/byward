<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — Byward Logistics</title>
    
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/scss/app.scss'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #071528 0%, #0b1f3f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.5rem;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo img {
            height: 48px;
            width: auto;
        }
        .form-label {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            font-size: 0.9rem;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #fff;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.35);
            color: #fff;
            box-shadow: none;
        }
        .btn-login {
            background-color: #c8202c;
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.2s ease;
            width: 100%;
            margin-top: 1.5rem;
        }
        .btn-login:hover {
            background-color: #a8121f;
            color: #fff;
            transform: translateY(-1px);
        }
        .alert-login {
            background: rgba(200, 32, 44, 0.15);
            border: 1px solid rgba(200, 32, 44, 0.3);
            color: #ff8e96;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-logo">
        <img src="{{ asset('images/logo-light.png') }}" alt="Byward Logistics">
        <h1 class="h4 text-white mt-3 fw-bold">Admin Portal</h1>
    </div>
    
    @if ($errors->any())
        <div class="alert-login" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@bywardlogistics.com">
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
        </div>
        
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label text-white-50 small" for="remember">Remember me</label>
        </div>
        
        <button type="submit" class="btn btn-login">
            Sign In
        </button>
    </form>
</div>

</body>
</html>

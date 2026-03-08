<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – Admin Terminal FECOSA</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    :root { --red:#cc1e37; --dark:#262626; }
    body {
        font-family: 'Nunito', sans-serif;
        background: var(--dark);
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
        background-image: radial-gradient(circle at 20% 50%, rgba(204,30,55,.12) 0%, transparent 50%),
                          radial-gradient(circle at 80% 20%, rgba(204,30,55,.08) 0%, transparent 40%);
    }
    .login-card {
        background: #1e1e1e;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        width: 100%;
        max-width: 400px;
        border: 1px solid rgba(255,255,255,.08);
        box-shadow: 0 20px 60px rgba(0,0,0,.4);
    }
    .login-logo {
        font-family: 'Barlow Condensed', sans-serif;
        font-weight: 800; font-size: 1.6rem; color: #fff;
        margin-bottom: 4px;
    }
    .login-logo span { color: var(--red); }
    .login-sub { font-size: .8rem; color: rgba(255,255,255,.4); font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }

    .form-label { color: rgba(255,255,255,.7); font-size: .85rem; font-weight: 600; margin-bottom: 5px; }
    .form-control {
        background: rgba(255,255,255,.07);
        border: 1.5px solid rgba(255,255,255,.12);
        color: #fff; border-radius: 10px;
        padding: .65rem 1rem;
        font-family: 'Nunito', sans-serif;
        transition: border-color .2s;
    }
    .form-control:focus {
        background: rgba(255,255,255,.1);
        border-color: var(--red);
        color: #fff; box-shadow: none;
    }
    .form-control::placeholder { color: rgba(255,255,255,.25); }

    .btn-login {
        background: var(--red); color: #fff; border: none;
        border-radius: 10px; font-weight: 700; font-size: 1rem;
        padding: .7rem;
        width: 100%;
        transition: background .2s, transform .15s;
        letter-spacing: .3px;
    }
    .btn-login:hover { background: #a3152b; transform: translateY(-1px); }

    .divider { border-color: rgba(255,255,255,.08); }
    .back-link { color: rgba(255,255,255,.4); font-size: .82rem; text-decoration: none; transition: color .2s; }
    .back-link:hover { color: rgba(255,255,255,.8); }
</style>
</head>
<body>

<div class="login-card">
    <!-- Logo -->
    <div class="text-center mb-4">
        <div class="login-logo">TERMINAL <span>FECOSA</span></div>
        <div class="login-sub">Panel de Administración</div>
    </div>

    <hr class="divider mb-4">

    @if($errors->any())
        <div class="alert alert-danger py-2 px-3 mb-3" style="background:rgba(204,30,55,.2);border:1px solid rgba(204,30,55,.4);border-radius:8px;color:#ff8896;font-size:.85rem;">
            <i class="fa-solid fa-circle-exclamation me-1"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" placeholder="admin@terminalfecosa.com"
                   value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       style="background-color:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);">
                <label class="form-check-label" for="remember" style="color:rgba(255,255,255,.5);font-size:.82rem;">
                    Recordarme
                </label>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="fa-solid fa-right-to-bracket me-2"></i>Ingresar
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="back-link">
            <i class="fa-solid fa-arrow-left me-1"></i>Volver al sitio
        </a>
    </div>
</div>

</body>
</html>

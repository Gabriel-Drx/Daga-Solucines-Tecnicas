<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Principal</title>
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="loginleft">
                <h2>Iniciar Sesión</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('principal.submit') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="email">Usuario</label>
                        <input type="email" id="email" name="email" placeholder="email@email.com" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="***********" required>
                    </div>
                    <button type="submit" class="login-btn">Acceder</button>
                </form>
            </div>
            <div class="login-right">
                <img src="{{ asset('imagenes/dagafot.png') }}" alt="Daga Soluciones Técnicas">
            </div>
        </div>
    </div>
</body>
</html>


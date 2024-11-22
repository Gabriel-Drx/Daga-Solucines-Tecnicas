<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/estilo2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/factura.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/65c5954a63.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>@yield('title', 'Daga Dashboard')</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
            <a href="{{ url('/dashboard2') }}" class="logo-link">
                <span class="image">
                    <img src="{{ asset('imagenes/dagafot.png') }}" alt="Logo">
                </span>
            </a>

                <div class="text logo-text">
                    <span class="name"></span>
                    <span class="profession">Daga Soluciones</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <li class="nav-link">
                    <a href="{{ url('/dashboard2') }}">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="{{ url('/cliente') }}">
                        <i class='bx bx-user icon'></i>
                        <span class="text nav-text">Clientes</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ url('/presupuesto') }}">
                        <i class='bx bx-calculator icon'></i>
                        <span class="text nav-text">Presupuesto</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="{{ url('/informes') }}">
                        <i class='bx bx-file icon'></i>
                        <span class="text nav-text">Informes</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ url('/factura') }}">
                        <i class='bx bx-receipt icon'></i>
                        <span class="text nav-text">Factura</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ url('/presu') }}">
                        <i class='bx bx-calculator icon'></i>
                        <span class="text nav-text">Subir Presupuesto</span>
                    </a>
                </li>
              
            </div>

            <div class="bottom-content">
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Cerrar Sesión</span>
                </a>
            </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Modo oscuro</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
            </div>
        </div>
    </nav>
    
    <section class="home">
        <!-- Sección de bienvenida añadida aquí -->
        <div class="welcome-section">
                <span class="welcome-text">
                Bienvenido, {{ session('nombre', 'Invitado') }}
            </span> 
            <div class="profile-image">
                   <img src="{{ asset(session('imagen')) }}" alt="Imagen de perfil">
             </div>
        </div>

        @yield('content')
    </section>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

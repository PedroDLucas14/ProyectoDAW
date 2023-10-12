<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Star wars hunters</title>
    <meta charset="UTF-8">
    <meta name="description" content="StarWars Template TFC">
    <meta name="keywords" content="starwars, game, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Pedro David Lucas Gómez" />
    <!-- Token-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('/img/favicon.png') }}" rel="shortcut icon" />

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i" rel="stylesheet"> --}}
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" />


    @yield('cssExtra')

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    @yield('jsExtra')

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- Header section -->
    <header class="header-section">
        <div class="container">
            <!-- logo -->
            <a class="site-logo" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="img-logo">
            </a>
            <div class="user-panel">
                @auth
                    <a href="{{ route('salir') }}">Desconectar</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}">Login</a> / <a href="{{ route('registro') }}">Registrarse</a>
                @endguest
            </div>
            <!-- responsive -->
            <div class="nav-switch">
                <i class="fa fa-bars"></i>
            </div>
            <!-- site menu -->
            <nav class="main-menu">
                <ul>
                    @yield('mainMenu')

                    @auth
                        <li id="logout-menu"><a href="{{ route('salir') }}">Desconectar</a></li>
                    @endauth
                    @guest
                    <li id="login-menu"><a href="{{ route('login') }}">Login</a> / <a href="{{ route('registro') }}">Registrarse</a></li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>
    <!-- Header section end -->
    <!-- Main section -->
    <main>
        @yield('content')
    </main>

    <!-- End Main section-->
    <!-- Footer section-->
    <footer class="footer mt-auto py-3 bg-dark footer-secction">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-2 text-muted">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Sobre Nosotros</a></li>
            <li class="nav-item"><a href="{{ route('index.clasificacion') }}"
                    class="nav-link px-2 text-muted">Clasificación</a></li>
            <li class="nav-item"><a href="https://starwars.fandom.com/es/wiki/Portada"
                    class="nav-link px-2 text-muted">Wiki</a></li>
        </ul>
        <p class="text-center text-muted">&copy; {{ date('Y') }} Pedro David Lucas Gómez</p>
    </footer>
    <!-- Footer section end -->
    <!--====== Javascripts & Jquery ======-->
    <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.marquee.min.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>

</html>

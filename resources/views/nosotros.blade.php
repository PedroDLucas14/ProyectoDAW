@extends('layouts.plantilla')
@section('cssExtra')
    <style>
        main {
            background: url({{ asset('img/fondo.jpg') }});
        }

        main {
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
        }

        iframe {
            width: 50%;
        }

        #nosotros>div h1 {

            text-align: center
        }

        #nosotros>div p {
            font-size: x-large;
            font-weight: bold;
        }

        #nosotros>div {
            background: white;
            padding: 2rem;
            border: 1px solid red;
            border-radius: 25px;
        }
    </style>
@endsection

@section('mainMenu')
    @auth
        @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('jugador'))
            <li><a href="{{ route('jugar') }}">Jugar</a></li>
        @endif
    @endauth
    <li><a href="{{ route('index.clasificacion') }}">Clasificación</a></li>
    @auth
        @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('jugador'))
            <li><a href="{{ route('perfil.inventario') }}">Inventario</a></li>
            <li><a href="{{ route('mercado.ver') }}">Mercado</a></li>
        @endif
        @if (Auth::user()->puedePermiso('administrador') || Auth::user()->puedePermiso('mantenimiento'))
            <li><a href="{{ route('gestion') }}">Gestión</a></li>
        @endif
        <li> <a href="{{ route('perfil.index') }}">Usuario: {{ Auth::user()->nick }}</a> </li>
    @endauth
@endsection
@section('content')
    <div class="container pt-4" id="nosotros">
        <div class="d-flex align-items-center flex-column ">
            <h1 class="p-4">Star wars hunters</h1>
            <iframe src="https://www.youtube.com/embed/QEFsuif0q-s" title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
            <p class="pt-4">
                Es un proeycto realizado para el proyecto integrado de "Desarrollo de Aplicaciones Web" del IES Pedro
                Espinosa.<br>
                Realizado por Pedro David Lucas Gómez.<br>
                Nace de mi gusto por los juegos de gestión y estrategia , y la competición.<br>
                Ademas de rendir homenaje al universo Star Wars del cual soy un gran fan.<br>
                Para el desarrollo del mismo he usado framework de php(Laravel) y JavaScrip como lenguajes, y HTML y CSS
                junto con boostrap, para la parte gráfica.
            </p>
        </div>
    </div>
@endsection

@extends('layouts.plantilla')

@section('cssExtra')
    <link rel="stylesheet" href="{{ asset('css/juego.css') }}">
    <style>
        main {
            background: url({{ asset('img/fondo.jpg') }});

        }

        main {
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            margin-bottom: 0;
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            main {
                height: auto;
            }

            .datosJugador {
                flex-direction: column;
            }

            .contendor-batalla {
                height: 100%;
            }
        }

        @media only screen and (max-width: 767px) {
            main {
                height: auto;
            }

            .datosJugador {
                flex-direction: column;
            }

            .contendor-batalla {
                height: 100%;
            }
        }
    </style>
@endsection
@section('jsExtra')
    <script src="{{ asset('js/juego.js') }}" type="module"></script>
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
    <div id="loading-message">Cargando...</div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Selección</h5>
                </div>
                <div class="modal-body" id="mensaje-Modal">
                    <i class="bi bi-exclamation-circle-fill" style="red"></i> Debes de elegir un piloto y una nave
                </div>
            </div>
        </div>
    </div>
    <h2 id="tituloJuego">Lista de rivales</h2>
    <h3 id="infoTituloJuego" class="text-center mt-2 mb-3">Seleccione un adversario</h3>
    <div class="adversarios">
        @if (count($rivales) > 0)
            @foreach ($rivales as $rival)
                <div id="{{ $rival->cod_usuario }}">
                    <h4>{{ $rival->nick }}</h4>
                    <h5>{{ $rival->puntos }} pts</h5>
                    <img src="{{ asset($rival->division->imagen) }}" alt="img-division">
                </div>
            @endforeach
            <img id="recargar" src="{{ asset('img/utilidades/recargar.png') }}" alt="imagen-recargar">
        @else
            <h2>No hay rivales disponibles</h2>
            <img id="recargar" src="{{ asset('img/utilidades/recargar.png') }}" alt="imagen-recargar">
        @endif

    </div>
@endsection

@extends('layouts.plantilla')


{{-- @dd($datosDevuelta) --}}
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
            .datosJugador {
                flex-direction: column;
            }

            main {
                height: 100%;
            }
        }

        @media only screen and (max-width: 767px) {
            .datosJugador {
                flex-direction: column;
            }

            main {
                height: 100%;
            }
        }
    </style>
@endsection
@section('jsExtra')
    <script src="{{ asset('js/verPartida.js') }}" type="module"></script>
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
  
    <div class="batalla" id="{{ $cod_batalla }}">
        <div id="loading-message">Cargando...</div>
        <div class="batalla-jugador">
            <h5>{{ $datosDevuelta['inicialesJugador']['nombre'] }}</h5>
            <img src="{{ asset($datosDevuelta['inicialesJugador']['imagenNave']) }}" alt="nave-simulacion-partida">
            <div class="progress">
                <div id="vidaJugador" class="progress-bar bg-success" role="progressbar"
                    aria-valuenow="{{ $datosDevuelta['inicialesJugador']['resistencia'] }}" aria-valuemin="0"
                    aria-valuemax="{{ $datosDevuelta['inicialesJugador']['resistencia'] }}"
                    style="width: 100%; height: 20px;"></div>
            </div>
        </div>
        <div class="batalla-rival">
            <h5>{{ $datosDevuelta['inicialesRival']['nombre'] }}</h5>
            <img src="{{ asset($datosDevuelta['inicialesRival']['imagenNave']) }}" alt="nave-simulacion-partida">
            <div class="progress">
                <div id="vidaRival" class="progress-bar bg-success" role="progressbar"
                    aria-valuenow="{{ $datosDevuelta['inicialesRival']['resistencia'] }}" aria-valuemin="0"
                    aria-valuemax="{{ $datosDevuelta['inicialesRival']['resistencia'] }}"
                    style="width: 100%; height: 20px;"></div>
            </div>
        </div>
    </div>
@endsection

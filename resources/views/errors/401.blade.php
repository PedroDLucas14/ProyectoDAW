@extends('layouts.plantillaErroes')
@section('cssExtra')
    <style>
        main {
            height: 100%;
        }
    </style>
@endsection
@section('mainMenu')
    <li><a href="{{ route('sobreNosotros') }}"> StarWars Hunters</a></li>
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
@section('error')
    <div id="layoutError">
        <div id="layoutError_content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mt-4">
                            <h1 class="display-1">401</h1>
                            <img class="mb-4 img-error" src="{{ asset('img/imagenError.jpg') }}" />
                            <p class="lead">No autorizado</p>
                            <p>El acceso a este recurso está denegado.</p>
                            <a href="{{ route('home') }}">
                                <i class="fas fa-arrow-left me-1"></i>
                                Volver a inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

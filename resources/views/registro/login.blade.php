@extends('layouts.plantilla')
@section('cssExtra')
    <style>
        body {
            overflow-y: hidden;
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
@section('content')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 text-black">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <form style="width: 23rem;" method="post">
                            @csrf
                            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Iniciar sesion</h3>
                            <div class="form-outline mb-4">
                                <input type="text" id="nick" name="nick" class="form-control form-control-lg" />
                                <label class="form-label" for="nick">Nick</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" id="pass" name="password"
                                    class="form-control form-control-lg" />
                                <label class="form-label" for="pass">Contraseña</label>
                            </div>
                            <label for="remember">Recuerdame</label>
                            <input type="checkbox" name="remember" id="remember">
                            <div class="pt-1 mb-4">
                                <button class="btn btn-info btn-lg btn-block" type="submit">Login</button>
                            </div>
                            <p>¿No tienes cuenta aún? <a href="{{ route('registro') }}" class="link-info">Registrate
                                    aquí</a></p>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img id="img-login" src="https://picstatio.com/large/a1b1e2/fan-art-star-wars-darth-vader.jpg"
                        alt="Login image" class="w-100 vh-100 ">
                </div>
            </div>
        </div>
    </section>
@endsection

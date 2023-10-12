@extends('layouts.plantilla')
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
@section('cssExtra')
    <style>
        main {
            height: 100% !important;
        }
    </style>
@endsection
@section('content')
    <div style="padding: 2%">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header registro">Registro</div>
                    <div class="card-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <label for="usuarios_nick"
                                    class="col-md-4 col-form-label text-md-end text-start">Nick</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('nick') is-invalid @enderror"
                                        id="usuarios_nick" name="nick" value="{{ old('nick') }}">
                                    @if ($errors->has('nick'))
                                        <span class="text-danger">{{ $errors->first('nick') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="usuarios_nombre"
                                    class="col-md-4 col-form-label text-md-end text-start">Nombre</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                        id="usuarios_nombre" name="nombre" value="{{ old('nombre') }}">
                                    @if ($errors->has('nombre'))
                                        <span class="text-danger">{{ $errors->first('nombre') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="usuarios_fechaNac" class="col-md-4 col-form-label text-md-end text-start">Fecha
                                    de
                                    Nacimiento</label>
                                <div class="col-md-6">
                                    <input type="date"
                                        class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                        id="usuarios_fechaNac" name="fecha_nacimiento"
                                        value="{{ old('fecha_nacimiento') }}">
                                    @if ($errors->has('fecha_nacimiento'))
                                        <span class="text-danger">{{ $errors->first('fecha_nacimientow') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="usuarios_correo"
                                    class="col-md-4 col-form-label text-md-end text-start">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="usuarios_correo" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password_confirmation"
                                    class="col-md-4 col-form-label text-md-end text-start">Confirmar contraseña</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password_confirmation" name="confirmarPassword">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="usuarios_imagen" class="col-md-4 col-form-label text-md-end text-start">Imagen
                                    de perfil</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" id="usuarios_imagen" name="avatar">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-starwars" value="Registrarse">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
